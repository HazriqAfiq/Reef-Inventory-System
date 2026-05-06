<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'slug',
        'product_type_id',
        'category_id',
        'volume_ml',
        'description',
        'top_note',
        'heart_note',
        'base_note',
        'fragrance_family',
        'wholesale_price',
        'retail_price',
        'stock',
        'release_date',
        'is_active',
        'promotion_type',
        'promotion_value',
        'promotion_badge',
        'promotion_badge_color',
        'promotion_starts_at',
        'promotion_ends_at',
        'promotion_min_qty',
        'promotion_min_amount',
        'promotion_target',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'release_date' => 'date',
        'wholesale_price' => 'decimal:2',
        'retail_price' => 'decimal:2',
        'promotion_starts_at' => 'datetime',
        'promotion_ends_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && !$product->isDirty('slug')) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function resellerStocks()
    {
        return $this->hasMany(ResellerStock::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('release_date', '>=', now()->subMonths(3))
                     ->orderBy('release_date', 'desc');
    }

    public function scopeOnPromotion($query, $user = null)
    {
        $now = now();
        $query->whereNotNull('promotion_type')
              ->where(function($q) use ($now) {
                  $q->whereNull('promotion_starts_at')
                    ->orWhere('promotion_starts_at', '<=', $now);
              })
              ->where(function($q) use ($now) {
                  $q->whereNull('promotion_ends_at')
                    ->orWhere('promotion_ends_at', '>=', $now);
              });

        // Target audience filtering
        if ($user && method_exists($user, 'isReseller') && $user->isReseller()) {
            $query->whereIn('promotion_target', ['all', 'reseller']);
        } else {
            $query->whereIn('promotion_target', ['all', 'direct']);
        }

        return $query;
    }

    public static function hasActivePromotions($user = null)
    {
        return self::active()->onPromotion($user)->exists();
    }

    public function isPromotionActive($quantity = null, $user = null)
    {
        if (empty($this->promotion_type)) {
            return false;
        }

        $now = now();
        
        // Time window check
        if ($this->promotion_starts_at && $this->promotion_starts_at > $now) {
            return false;
        }

        if ($this->promotion_ends_at && $this->promotion_ends_at < $now) {
            return false;
        }

        // Quantity check (if provided)
        if ($quantity !== null && $this->promotion_min_qty > 0) {
            if ($quantity < $this->promotion_min_qty) {
                return false;
            }
        }

        // Target audience check
        if ($user && method_exists($user, 'isReseller') && $user->isReseller()) {
            return in_array($this->promotion_target, ['all', 'reseller']);
        }

        return in_array($this->promotion_target, ['all', 'direct']);
    }

    public function getDiscountedPriceAttribute()
    {
        if (!$this->isPromotionActive() || $this->promotion_type !== 'discount_percent') {
            return $this->retail_price;
        }

        // If there's a minimum quantity required, the base displayed price should remain the retail price.
        // The discount is only applied in the cart when the threshold is met.
        if ($this->promotion_min_qty > 1) {
            return $this->retail_price;
        }

        $discount = $this->retail_price * ($this->promotion_value / 100);
        return max(0, $this->retail_price - $discount);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get the badge text to display for promotions.
     * Fallback to type-based defaults if no custom badge is set.
     */
    public function getEffectivePromotionBadgeAttribute()
    {
        $minText = $this->promotion_min_qty > 1 ? ' (MIN ' . $this->promotion_min_qty . ')' : '';

        if ($this->promotion_badge) {
            return $this->promotion_badge . $minText;
        }

        if ($this->promotion_type === 'bogo') {
            return '1+1' . $minText;
        }

        if ($this->promotion_type === 'discount_percent') {
            return $this->promotion_value . '% OFF' . $minText;
        }

        return 'PROMO' . $minText;
    }
}
