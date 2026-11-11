<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    //

    protected $appends = ['display_title', 'display_details', 'display_thumbnail'];

    public function getDisplayTitleAttribute()
    {
        return $this->title ?? $this->product?->title;
    }
    public function getDisplayDetailsAttribute()
    {
        return $this->details ?? $this->product?->details;
    }
    public function getDisplayThumbnailAttribute()
    {
        $t = $this->thumbnail ?? $this->product?->thumbnail;
        return $t ? asset('storage/' . $t) : null;
    }
    protected $fillable = ['shop_id', 'product_id', 'title', 'details', 'price', 'thumbnail'];

    function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    function product()
    {
        return $this->belongsTo(Product::class);
    }
}
