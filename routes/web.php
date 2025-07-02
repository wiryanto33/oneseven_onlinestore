<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\StoreShow;
use App\Livewire\ProductDetail;
use App\Livewire\ShoppingCart;
use App\Livewire\OrderPage;
use App\Livewire\OrderDetail;
use App\Livewire\Checkout;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\PaymentConfirmationPage;
use App\Livewire\Profile;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PointController;
use App\Livewire\RewardHistory;
use App\Livewire\RewardPage;
use App\Livewire\Rewards;

Route::get('/', StoreShow::class)->name('home');
Route::get('/product/{slug}', ProductDetail::class)->name('product.detail');
Route::get('/rewards', RewardPage::class)->name('rewards');


Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/shopping-cart', ShoppingCart::class)->name('shopping-cart');
    Route::get('/orders', OrderPage::class)->name('orders');

    Route::get('/order-detail/{orderNumber}', OrderDetail::class)->name('order-detail');
    Route::get('/payment-confirmation/{orderNumber}', PaymentConfirmationPage::class)->name('payment-confirmation');


    Route::get('/reward-history', RewardHistory::class)->name('reward.history');
    Route::get('/earn-points', [PointController::class, 'earnPoints'])->name('earn.points');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', Checkout::class)->name('checkout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Invoice routes with explicit naming
    Route::get('invoice/{order}/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('invoice/{order}/preview', [InvoiceController::class, 'preview'])->name('invoice.preview');
});




require __DIR__.'/auth.php';


