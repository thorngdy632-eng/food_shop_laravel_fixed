<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// ── Home ────────────────────────────────────────────────────────────────────
Route::get('/', fn () => view('home'))->name('home');

// ── Auth (guest only) ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// ── Auth (logged in) ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// ── Cart (session-based) ───────────────────────────────────────────────────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',        [CartController::class, 'index'])  ->name('index');
    Route::get('/data',    [CartController::class, 'cartData']) ->name('data');
    Route::post('/add',    [CartController::class, 'add'])    ->name('add');
    Route::post('/update-qty', [CartController::class, 'update']) ->name('update');
    Route::post('/remove', [CartController::class, 'remove']) ->name('remove');
    Route::post('/clear',  [CartController::class, 'clear'])  ->name('clear');
});

// ── Checkout & Order (auth required) ───────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/checkout',          [OrderController::class, 'checkout'])   ->name('checkout.index');
    Route::post('/order/place',      [OrderController::class, 'placeOrder']) ->name('order.place');
    Route::get('/order/success/{id}', [OrderController::class, 'success'])   ->name('order.success');
    Route::get('/order/history',     [OrderController::class, 'history'])    ->name('order.history');
});
