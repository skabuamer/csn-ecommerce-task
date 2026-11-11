<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopProductController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//  Public (customers) 
Route::get('/', [StorefrontController::class, 'index'])->name('home');
Route::get('/shops/{shop:slug}', [StorefrontController::class, 'show'])->name('shops.show');

//  Login / logout 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

// After login
Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.shops.index')
        : redirect()->route('owner.listings.index');
})->middleware('auth')->name('dashboard');

//  Admin only 
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('shops', ShopController::class)->except('show');
    Route::resource('products', ProductController::class)->except('show');
    Route::resource('owners', UserController::class)->except('show')->parameters(['owners' => 'user']);
});

//  Shop owner only 
Route::middleware(['auth', 'role:shop_owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('catalog', [ShopProductController::class, 'catalog'])->name('catalog');
    Route::post('catalog/{product}/add', [ShopProductController::class, 'add'])->name('catalog.add');
    Route::post('products', [ShopProductController::class, 'storeProduct'])->name('products.store');
    Route::get('listings', [ShopProductController::class, 'index'])->name('listings.index');
    Route::post('listings/{shopProduct}', [ShopProductController::class, 'update'])->name('listings.update');
    Route::delete('listings/{shopProduct}', [ShopProductController::class, 'destroy'])->name('listings.destroy');
});
