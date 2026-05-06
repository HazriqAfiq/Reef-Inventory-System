<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'sku',
        'retail_price',
        'wholesale_price',
        'stock',
        'volume_ml',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getDiscountedPriceAttribute()
    {
        if (!$this->product->isPromotionActive() || $this->product->promotion_type !== 'discount_percent') {
            return $this->retail_price;
        }

        $discount = $this->retail_price * ($this->product->promotion_value / 100);
        return max(0, $this->retail_price - $discount);
    }
}
