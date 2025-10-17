<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Livewire\Pages\Profile\Profile;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Livewire\Pages\Auth\MultiStepRegistration;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('events', [EventController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('events');

Route::get('events/{event}', [EventController::class, 'show'])
    ->name('events.show');

Route::get('products', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('products');

Route::get('products/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::get('services', [ServiceController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('services');

Route::middleware(['auth'])->group(function () {
    Route::post('/order/create/{product}', [OrderController::class, 'createOrder'])->name('order.create');

    Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/pending', [OrderController::class, 'pending'])->name('order.pending');
    Route::get('/order/failed', [OrderController::class, 'failed'])->name('order.failed');
});

Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');

Route::get('/profile/test', Profile::class)
    ->middleware(['auth'])
    ->name('profile');;

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile-old');

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();

    // $user->token
});

// Google OAuth
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::get('/register', MultiStepRegistration::class)->name('register');
Route::get('/register/umkm', MultiStepRegistration::class)->name('register.umkm');

require __DIR__ . '/auth.php';
