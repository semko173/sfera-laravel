<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\FavoritesController;
/*
|--------------------------------------------------------------------------
| Публичные роуты
|--------------------------------------------------------------------------
*/
Route::get('/favorites', [FavoritesController::class, 'index'])->name('favorites.index');
Route::post('/favorites/toggle', [FavoritesController::class, 'toggle'])->name('favorites.toggle');
Route::post('/favorites/remove', [FavoritesController::class, 'remove'])->name('favorites.remove');
Route::post('/favorites/clear', [FavoritesController::class, 'clear'])->name('favorites.clear');
Route::view('/guarantees', 'static.guarantees')->name('guarantees');
Route::view('/about', 'static.about')->name('about');
Route::view('/contacts', 'static.contacts')->name('contacts');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::middleware('auth')->prefix('checkout')->name('checkout.')->group(function () {
Route::get('/', [CheckoutController::class, 'index'])->name('index');
Route::post('/', [CheckoutController::class, 'store'])->name('store');
Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');



/*
|--------------------------------------------------------------------------
| Роуты залогиненных (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::get('/orders', [ProfileController::class, 'orders'])->name('orders');
    Route::get('/prescriptions', [ProfileController::class, 'prescriptions'])->name('prescriptions');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::patch('/settings', [ProfileController::class, 'update'])->name('update');
    Route::post('/prescriptions', [ProfileController::class, 'storePrescription'])->name('prescriptions.store');
    Route::delete('/prescriptions/{prescription}', [ProfileController::class, 'destroyPrescription'])->name('prescriptions.destroy');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';