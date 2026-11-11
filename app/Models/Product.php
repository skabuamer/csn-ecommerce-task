<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
    //
    protected $appends = ['thumbnail_url'];

    protected $fillable = ['created_by', 'title', 'details', 'price', 'thumbnail'];

    function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // shop-products
    function shops()
    {
        return $this->hasMany(ShopProduct::class);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? '/storage/' . $this->thumbnail : null;
    }
}
