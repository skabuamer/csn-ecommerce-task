<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    //
    protected $fillable = ['owner_id', 'name', 'slug'];

    function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    function products()
    {
        return $this->hasMany(ShopProduct::class);
    }
}
