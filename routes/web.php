<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\OpenCodeAiController;

// ── Home (Open to both regular users and admins!) ───────────────────────────
Route::get('/', fn () => view('home'))->name('home');

// ── Auth (guest only) ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ── Auth (logged in) ───────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// ── Cart (Removed 'user' middleware so admin can safely browse items) ──────
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',            [CartController::class, 'index'])->name('index');
    Route::get('/data',        [CartController::class, 'cartData'])->name('data');
    Route::post('/add',        [CartController::class, 'add'])->name('add');
    Route::post('/update-qty', [CartController::class, 'update'])->name('update');
    Route::post('/remove',     [CartController::class, 'remove'])->name('remove');
    Route::post('/clear',      [CartController::class, 'clear'])->name('clear');
});

// ── Checkout & Order (Keep 'user' here so admins cannot place orders) ──────
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/checkout',            [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/order/place',        [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order/success/{id}',  [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/history',       [OrderController::class, 'history'])->name('order.history');
});

// ── OpenCode AI (auth + admin only) ─────────────────────────────────────────
Route::prefix('admin/ai')->name('admin.ai.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/',                     [OpenCodeAiController::class, 'index'])->name('index');
    Route::post('generate-description', [OpenCodeAiController::class, 'generateDescription'])->name('generate-description');
    Route::get('order-trends',          [OpenCodeAiController::class, 'orderTrends'])->name('order-trends');
    Route::post('customer-reply',       [OpenCodeAiController::class, 'customerReply'])->name('customer-reply');
    Route::post('custom-prompt',        [OpenCodeAiController::class, 'customPrompt'])->name('custom-prompt');
});

// ── Admin Panel (auth + admin only) ────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Foods
    Route::get('/foods',               [AdminController::class, 'foods'])->name('foods');
    Route::get('/foods/create',        [AdminController::class, 'createFood'])->name('foods.create');
    Route::post('/foods',              [AdminController::class, 'storeFood'])->name('foods.store');
    Route::get('/foods/{food}/edit',   [AdminController::class, 'editFood'])->name('foods.edit');
    Route::post('/foods/{food}',       [AdminController::class, 'updateFood'])->name('foods.update');
    Route::post('/foods/{food}/delete', [AdminController::class, 'deleteFood'])->name('foods.delete');

    // Orders
    Route::get('/orders',                   [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}',           [AdminController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/status',   [AdminController::class, 'updateOrderStatus'])->name('orders.status');

    // Users
    Route::get('/users',                    [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/role',       [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::post('/users/{user}/delete',     [AdminController::class, 'deleteUser'])->name('users.delete');
});