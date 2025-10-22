<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set Midtrans Configuration
        \Midtrans\Config::$serverKey = config('services.midtrans.server_key');
        \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function createOrder(Request $request, Service $service)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'notes' => 'nullable|string|max:1000',
            ]);

            // Check if service is active
            if (!$service->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Layanan tidak tersedia'
                ], 400);
            }

            $quantity = $validated['quantity'];
            $totalPrice = $service->price * $quantity;

            // Create order
            $order = DB::transaction(function () use ($service, $validated, $quantity, $totalPrice) {
                $orderNumber = ServiceOrder::generateOrderNumber();

                $order = ServiceOrder::create([
                    'order_number' => $orderNumber,
                    'service_id' => $service->id,
                    'user_id' => Auth::id(),
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'],
                    'quantity' => $quantity,
                    'price_per_unit' => $service->price,
                    'total_price' => $totalPrice,
                    'notes' => $validated['notes'] ?? null,
                    'payment_status' => 'pending',
                    'order_status' => 'pending',
                ]);

                return $order;
            });

            // Prepare Midtrans transaction
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_number,
                    'gross_amount' => (int) $order->total_price,
                ],
                'customer_details' => [
                    'first_name' => $order->customer_name,
                    'email' => $order->customer_email,
                    'phone' => $order->customer_phone,
                ],
                'item_details' => [
                    [
                        'id' => $service->id,
                        'price' => (int) $service->price,
                        'quantity' => $quantity,
                        'name' => $service->name,
                    ],
                ],
                'callbacks' => [
                    'finish' => route('payment.finish'),
                ]
            ];

            // Get Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Update order with snap token
            $order->update([
                'snap_token' => $snapToken,
                'midtrans_order_id' => $order->order_number,
            ]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id' => $order->order_number,
                'message' => 'Order berhasil dibuat'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan, silakan coba lagi'
            ], 500);
        }
    }

    public function notification(Request $request)
    {
        try {
            $notification = new \Midtrans\Notification();

            $orderNumber = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            $order = ServiceOrder::where('order_number', $orderNumber)->firstOrFail();

            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $order->update(['payment_status' => 'pending']);
                } else if ($fraudStatus == 'accept') {
                    $order->update([
                        'payment_status' => 'paid',
                        'order_status' => 'processing',
                        'paid_at' => now(),
                        'payment_data' => $notification->getResponse(),
                    ]);
                }
            } else if ($transactionStatus == 'settlement') {
                $order->update([
                    'payment_status' => 'paid',
                    'order_status' => 'processing',
                    'paid_at' => now(),
                    'payment_data' => $notification->getResponse(),
                ]);
            } else if ($transactionStatus == 'pending') {
                $order->update(['payment_status' => 'pending']);
            } else if ($transactionStatus == 'deny') {
                $order->update(['payment_status' => 'failed']);
            } else if ($transactionStatus == 'expire') {
                $order->update(['payment_status' => 'expired']);
            } else if ($transactionStatus == 'cancel') {
                $order->update([
                    'payment_status' => 'failed',
                    'order_status' => 'cancelled'
                ]);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function finish(Request $request)
    {
        $orderNumber = $request->get('order_id');
        $order = ServiceOrder::where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('services.index')->with('error', 'Order tidak ditemukan');
        }

        return redirect()->route('payment.status', $order->order_number);
    }

    public function status($orderNumber)
    {
        $order = ServiceOrder::with('service')->where('order_number', $orderNumber)->firstOrFail();

        return view('components.status', compact('order'));
    }
}
