<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUS_PENDING    = 'pending';
    public const STATUS_PAID       = 'paid';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED    = 'shipped';
    public const STATUS_DELIVERED  = 'delivered';
    public const STATUS_CANCELLED  = 'cancelled';

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'billplz_id',
        'courier_name',
        'tracking_number',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the tracking URL based on courier name and tracking number.
     */
    public function getTrackingUrlAttribute(): ?string
    {
        if (!$this->tracking_number) {
            return null;
        }

        $courier = strtolower(trim($this->courier_name));

        if (str_contains($courier, 'poslaju') || str_contains($courier, 'pos laju')) {
            return "https://www.tracking.my/couriers/poslaju/{$this->tracking_number}";
        }
        if (str_contains($courier, 'j&t') || str_contains($courier, 'j and t') || str_contains($courier, 'jt')) {
            return "https://www.tracking.my/couriers/j-t-express/{$this->tracking_number}";
        }
        if (str_contains($courier, 'dhl')) {
            return "https://www.dhl.com/en/express/tracking.html?AWB={$this->tracking_number}";
        }
        if (str_contains($courier, 'fedex')) {
            return "https://www.fedex.com/apps/fedextrack/?tracknumbers={$this->tracking_number}";
        }
        if (str_contains($courier, 'ninja') || str_contains($courier, 'ninjavan')) {
            return "https://www.tracking.my/couriers/ninja-van/{$this->tracking_number}";
        }
        if (str_contains($courier, 'gdex') || str_contains($courier, 'gd express')) {
            return "https://www.tracking.my/couriers/gdex/{$this->tracking_number}";
        }

        // Fallback to global tracking aggregate search
        return "https://www.tracking.my/track/{$this->tracking_number}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class);
    }
}
