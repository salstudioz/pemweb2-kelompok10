<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Livewire Pages
use App\Livewire\Pages\Homepage;
use App\Livewire\Pages\Shop;
use App\Livewire\Pages\ProductDetail;
use App\Livewire\Pages\Cart;
use App\Livewire\Pages\Checkout;
use App\Livewire\Pages\Account;
use App\Livewire\Pages\WishlistPage;
use App\Livewire\Pages\UpgradePremium;
use App\Livewire\Pages\Sigame;
use App\Livewire\Pages\SigamePlay;
use App\Livewire\Pages\LegacyBid;
use App\Livewire\Pages\OrderHistory;
use App\Livewire\Pages\OrderDetail;

// Auth
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;

// Admin
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Products;
use App\Livewire\Admin\Genres;
use App\Livewire\Admin\Orders;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Games;
use App\Livewire\Admin\Auctions;
use App\Livewire\Admin\Coupons;

// Middleware
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\PremiumMiddleware;

// =============================================
// AUTH ROUTES (Guest only)
// =============================================
Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->name('logout');

// =============================================
// PUBLIC ROUTES (no login required)
// =============================================
Route::get('/', Homepage::class)->name('home');
Route::get('/shop', Shop::class)->name('shop');
Route::get('/product/{slug}', ProductDetail::class)->name('product.detail');
Route::get('/cart', Cart::class)->name('cart');

// =============================================
// PROTECTED ROUTES (login required)
// =============================================
Route::middleware('auth')->group(function () {
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/account', Account::class)->name('account');
    Route::get('/wishlist', WishlistPage::class)->name('wishlist');
    Route::get('/upgrade-premium', UpgradePremium::class)->name('upgrade.premium');
    Route::get('/order-history', OrderHistory::class)->name('order.history');
    Route::get('/order/{id}', OrderDetail::class)->name('order.detail');

    // =============================================
    // PREMIUM ROUTES (premium members only)
    // =============================================
    Route::middleware(PremiumMiddleware::class)->group(function () {
        Route::get('/sigame', Sigame::class)->name('sigame');
        Route::get('/sigame/{slug}', SigamePlay::class)->name('sigame.play');
        Route::get('/legacybid', LegacyBid::class)->name('legacybid');
    });

    // =============================================
    // ADMIN ROUTES (admin only)
    // =============================================
    Route::middleware(RoleMiddleware::class . ':admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', Dashboard::class)->name('dashboard');
            Route::get('/products', Products::class)->name('products');
            Route::get('/genres', Genres::class)->name('genres');
            Route::get('/orders', Orders::class)->name('orders');
            Route::get('/users', Users::class)->name('users');
            Route::get('/games', Games::class)->name('games');
            Route::get('/auctions', Auctions::class)->name('auctions');
            Route::get('/coupons', Coupons::class)->name('coupons');
        });
});