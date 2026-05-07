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
        'wholesale_price',
        'retail_price',
        'stock',
        'release_date',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'release_date' => 'date',
        'wholesale_price' => 'decimal:2',
        'retail_price' => 'decimal:2',
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

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}
