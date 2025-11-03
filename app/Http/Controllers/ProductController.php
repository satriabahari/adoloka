<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProductCategory::withCount(['products' => function ($q) {
            $q->where('is_active', true)->where('stock', '>', 0);
        }])->get();

        $query = Product::with(['category', 'umkm'])
            ->where('is_active', true)
            ->where('stock', '>', 0);

        if ($request->filled('category') && $request->category !== 'all') {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        $products = $query->latest()->get();

        return view('products', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'umkm']);
        abort_if(!$product->is_active, 404);
        return view('product-detail', compact('product'));
    }

    public function createPayment(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity'        => 'required|integer|min:1|max:' . $product->stock,
            'customer_name'   => 'required|string|max:255',
            'customer_email'  => 'required|email|max:255',
            'customer_phone'  => 'required|string|max:20',
            'notes'           => 'nullable|string|max:500',
        ], [
            'customer_name.required'  => 'Nama lengkap harus diisi',
            'customer_email.required' => 'Email harus diisi',
            'customer_email.email'    => 'Format email tidak valid',
            'customer_phone.required' => 'Nomor WhatsApp harus diisi',
            'quantity.max'            => 'Jumlah melebihi stok yang tersedia',
        ]);

        if ($product->stock < $validated['quantity']) {
            return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi'], 400);
        }

        try {
            // Midtrans config
            Config::$serverKey    = config('services.midtrans.server_key');
            Config::$isProduction = (bool) config('services.midtrans.is_production', false);
            Config::$isSanitized  = (bool) config('services.midtrans.is_sanitized', true);
            Config::$is3ds        = (bool) config('services.midtrans.is_3ds', true);

            $quantity     = (int) $validated['quantity'];
            $pricePerUnit = (int) $product->price;
            $totalAmount  = $pricePerUnit * $quantity;

            // order_number (user-facing) & midtrans_order_id (API Midtrans)
            $orderNumber     = 'PROD-' . strtoupper(Str::random(10));
            $midtransOrderId = 'MID-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6));

            // Simpan order sebelum hit Midtrans
            $order = ProductOrder::create([
                'order_number'       => $orderNumber,
                'midtrans_order_id'  => $midtransOrderId,
                'product_id'         => $product->id,
                'user_id'            => Auth::id(),
                'quantity'           => $quantity,
                'price_per_unit'     => $pricePerUnit,
                'total_amount'       => $totalAmount, // << selaras migration
                'customer_name'      => $validated['customer_name'],
                'customer_email'     => $validated['customer_email'],
                'customer_phone'     => $validated['customer_phone'],
                'notes'              => $validated['notes'] ?? null,
                'payment_status'     => 'pending',
            ]);

            // Payload Snap
            $params = [
                'transaction_details' => [
                    'order_id'     => $order->midtrans_order_id, // << gunakan midtrans_order_id
                    'gross_amount' => (int) $totalAmount,
                ],
                'item_details' => [[
                    'id'       => (string) $product->id,
                    'price'    => (int) $pricePerUnit,
                    'quantity' => (int) $quantity,
                    'name'     => mb_strimwidth($product->name, 0, 50, '…'),
                ]],
                'customer_details' => [
                    'first_name' => $order->customer_name,
                    'email'      => $order->customer_email,
                    'phone'      => $order->customer_phone,
                ],
                'enabled_payments' => [
                    'credit_card',
                    'gopay',
                    'shopeepay',
                    'other_qris',
                    'bca_va',
                    'bni_va',
                    'bri_va',
                    'permata_va',
                    'other_va',
                    'indomaret',
                    'alfamart'
                ],
            ];

            $snapToken = Snap::getSnapToken($params);
            $order->update(['snap_token' => $snapToken]);

            // Kembalikan order_number untuk URL status
            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'order_id'   => $order->order_number,
            ]);
        } catch (\Throwable $e) {
            Log::error('Midtrans Payment Error', ['msg' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Gagal membuat transaksi: ' . $e->getMessage()], 500);
        }
    }

    public function paymentStatus($orderNumber)
    {
        $order = ProductOrder::where('order_number', $orderNumber)
            ->with(['product.category', 'product.umkm'])
            ->firstOrFail();

        return view('components.product-payment-status', compact('order'));
    }

    public function paymentCallback(Request $request)
    {
        // Hardening: verifikasi signature manual (lebih aman dari sekadar Notification helper)
        $serverKey = config('services.midtrans.server_key');
        $calcSig   = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if (!hash_equals($calcSig, (string) $request->signature_key)) {
            Log::warning('Invalid Midtrans signature', ['payload' => $request->all()]);
            return response()->json(['success' => false, 'message' => 'Invalid signature'], 403);
        }

        try {
            $midtransOrderId   = $request->order_id;                 // ini = midtrans_order_id
            $transactionStatus = $request->transaction_status;       // settlement|capture|pending|deny|expire|cancel
            $paymentType       = $request->payment_type ?? null;
            $fraudStatus       = $request->fraud_status ?? null;

            $order = ProductOrder::where('midtrans_order_id', $midtransOrderId)->firstOrFail();

            // Idempotensi: kalau sudah final, jangan proses ulang (hindari double-decrement stok)
            if (in_array($order->payment_status, ['paid', 'failed', 'expired'])) {
                $order->update(['midtrans_response' => json_encode($request->all())]);
                return response()->json(['success' => true, 'message' => 'Already processed']);
            }

            DB::transaction(function () use ($order, $transactionStatus, $paymentType, $fraudStatus, $request) {
                if (in_array($transactionStatus, ['capture', 'settlement'])) {
                    // Jika CC & fraud challenge → tetap pending
                    if ($fraudStatus === 'challenge') {
                        $order->update([
                            'payment_status'    => 'pending',
                            'payment_type'      => $paymentType,
                            'midtrans_response' => json_encode($request->all()),
                        ]);
                        return;
                    }

                    $order->update([
                        'payment_status'    => 'paid',
                        'payment_type'      => $paymentType,
                        'paid_at'           => now(),
                        'midtrans_response' => json_encode($request->all()),
                    ]);

                    // Kurangi stok hanya saat jadi paid pertama kali
                    $order->product()->decrement('stock', $order->quantity);
                } elseif ($transactionStatus === 'pending') {
                    $order->update([
                        'payment_status'    => 'pending',
                        'payment_type'      => $paymentType,
                        'midtrans_response' => json_encode($request->all()),
                    ]);
                } elseif (in_array($transactionStatus, ['deny', 'cancel'])) {
                    $order->update([
                        'payment_status'    => 'failed',
                        'payment_type'      => $paymentType,
                        'midtrans_response' => json_encode($request->all()),
                    ]);
                } elseif ($transactionStatus === 'expire') {
                    $order->update([
                        'payment_status'    => 'expired',
                        'payment_type'      => $paymentType,
                        'midtrans_response' => json_encode($request->all()),
                    ]);
                } else {
                    // status lain (refund/chargeback) → sederhanakan jadi failed
                    $order->update([
                        'payment_status'    => 'failed',
                        'payment_type'      => $paymentType,
                        'midtrans_response' => json_encode($request->all()),
                    ]);
                }
            });

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            Log::error('Midtrans Callback Error', ['msg' => $e->getMessage()]);
            return response()->json(['success' => false], 500);
        }
    }
}
