<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopProduct;
use Inertia\Inertia;

class StorefrontController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'shops' => Shop::withCount('products')->get(),
            'listings' => ShopProduct::with(['product', 'shop:id,name,slug'])->latest()->get(),
        ]);
    }

    public function show(Shop $shop)
    {
        return Inertia::render('Shop', [
            'shop' => $shop->only('id', 'name', 'slug'),
            'listings' => $shop->products()->with('product')->get(),
        ]);
    }
}
