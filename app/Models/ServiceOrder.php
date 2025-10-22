<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $fillable = [
        'order_number',
        'service_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'quantity',
        'price_per_unit',
        'total_price',
        'notes',
        'payment_status',
        'snap_token',
        'midtrans_order_id',
        'payment_data',
        'order_status',
        'paid_at',
    ];

    protected $casts = [
        'payment_data' => 'array',
        'paid_at' => 'datetime',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Generate order number
    public static function generateOrderNumber(): string
    {
        $prefix = 'SRV';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));

        return "{$prefix}-{$date}-{$random}";
    }

    // Check if order is paid
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    // Format price
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}
