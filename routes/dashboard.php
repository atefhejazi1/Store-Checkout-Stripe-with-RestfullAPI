<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Vendor;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── ADMIN DASHBOARD ─────────────────────────────────────────────────────────
Route::prefix('admin/dashboard')
     ->name('admin.')
     ->middleware(['auth', 'verified', 'admin'])
     ->group(function () {

    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Vendor management
    Route::get('vendors', [Admin\VendorController::class, 'index'])->name('vendors.index');
    Route::patch('vendors/{store}/approve', [Admin\VendorController::class, 'approve'])->name('vendors.approve');
    Route::patch('vendors/{store}/block',   [Admin\VendorController::class, 'block'])->name('vendors.block');

    // Categories (full CRUD — admin only)
    Route::resource('categories', Admin\CategoryController::class);

    // Products (read-only platform overview)
    Route::resource('products', Admin\ProductController::class)->only(['index', 'show']);
});

// ─── VENDOR DASHBOARD ────────────────────────────────────────────────────────
Route::prefix('vendor/dashboard')
     ->name('vendor.')
     ->middleware(['auth', 'verified', 'vendor'])
     ->group(function () {

    // Pending page — accessible before approval
    Route::get('pending', [Vendor\DashboardController::class, 'pending'])->name('pending');

    // Dashboard — accessible to pending AND approved vendors (shows overlay when pending)
    Route::get('/', [Vendor\DashboardController::class, 'index'])->name('dashboard');

    // Profile — accessible regardless of approval state
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // All action routes require approval
    Route::middleware('vendor.approved')->group(function () {
        // Products (scoped to own store)
        Route::resource('products', Vendor\ProductController::class);

        // Orders (scoped to own store)
        Route::get('orders', [Vendor\OrderController::class, 'index'])->name('orders.index');

        // Store settings
        Route::get('store/edit', [Vendor\StoreController::class, 'edit'])->name('store.edit');
        Route::patch('store',    [Vendor\StoreController::class, 'update'])->name('store.update');
    });
});
