<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShopProductController extends Controller
{

    private function shop()
    {
        $shop = auth()->user()->shop;
        abort_unless($shop, 403, 'No shop is assigned to your account yet.');

        return $shop;
    }

    public function catalog()
    {
        $shop = $this->shop();

        return Inertia::render('Owner/Catalog', [
            'products' => Product::latest()->get(),
            'listedIds' => $shop->products()->pluck('product_id'),
        ]);
    }

    // "Add to my shop" function
    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:100',
            'details' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            unset($validated['thumbnail']);
        }

        ShopProduct::firstOrCreate(
            ['shop_id' => $this->shop()->id, 'product_id' => $product->id],
            $validated
        );
        return back()->with('success', 'Added to your shop.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Owner/Listings', [
            'listings' => $this->shop()->products()->with('product')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeProduct(Request $request, Product $product)
    {
        $shop = $this->shop();

        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'details' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $path = $request->hasFile('thumbnail')
            ? $request->file('thumbnail')->store('thumbnails', 'public')
            : null;

        $product = Product::create([
            'created_by' => $request->user()->id,
            'title' => $validated['title'],
            'details' => $validated['details'] ?? null,
            'price' => $validated['price'],
            'thumbnail' => $path,
        ]);

        ShopProduct::create([
            'shop_id' => $shop->id,
            'product_id' => $product->id,
            'price' => $validated['price'],
        ]);

        return redirect()->route('owner.listings.index')->with('success', 'Product created and listed in your shop.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShopProduct $shopProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopProduct $shopProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShopProduct $shopProduct)
    {
        abort_unless((int) $shopProduct->shop_id === (int) $this->shop()->id, 403);

        $validated = $request->validate([
            'title' => 'nullable|string|max:100',
            'details' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        } else {
            unset($validated['thumbnail']);
        }

        $shopProduct->update($validated);

        return back()->with('success', 'Listing updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopProduct $shopProduct)
    {
        abort_unless((int) $shopProduct->shop_id === (int) $this->shop()->id, 403);

        $shopProduct->delete();

        return back()->with('success', 'Removed from your shop.');
    }
}
