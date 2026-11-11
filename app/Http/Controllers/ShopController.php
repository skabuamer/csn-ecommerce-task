<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Shops', [
            'shops' => Shop::with('owner:id,name')->withCount('products')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/ShopForm', [
            'owners' => User::where('role', 'shop_owner')->doesntHave('shop')->get(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'owner_id' => 'required|exists:users,id|unique:shops,owner_id',
        ]);

        $slug = $base = Str::slug($validated['name']);

        $i = 1;
        while (Shop::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }
        $validated['slug'] = $slug;

        Shop::create($validated);

        return redirect()->route('admin.shops.index')->with('success', 'Shop created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        return Inertia::render('Admin/ShopForm', [
            'shop' => $shop,
            'owners' => User::where('role', 'shop_owner')
                ->where(fn($q) => $q->doesntHave('shop')->orWhere('id', $shop->owner_id))
                ->get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shop $shop)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'owner_id' => ['required', 'exists:users,id', Rule::unique('shops', 'owner_id')->ignore($shop->id)],
        ]);

        $shop->update($validated);

        return redirect()->route('admin.shops.index')->with('success', 'Shop updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        $shop->products()->delete();
        $shop->delete();

        return back()->with('success', 'Shop deleted.');
    }
}
