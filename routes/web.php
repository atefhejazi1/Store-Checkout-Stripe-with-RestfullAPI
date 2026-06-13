<?php

use App\Http\Controllers\front\CartController;
use App\Http\Controllers\front\CategoriesController;
use App\Http\Controllers\front\CheckoutController;
use App\Http\Controllers\front\CustomerDashboardController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\PaymentsController;
use App\Http\Controllers\front\ProductsController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('products.show');

Route::resource('/cart', CartController::class);

// Checkout, payment, and order confirmation require authentication
Route::middleware('auth')->group(function () {
    Route::get('customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');

    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);

    Route::get('orders/{order}/pay', [PaymentsController::class, 'create'])
        ->name('orders.payments.create');
    Route::post('orders/{order}/stripe/payment-intent', [PaymentsController::class, 'createStripePaymentIntent'])
        ->name('stripe.paymentIntent.create');
    Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
        ->name('stripe.return');
    Route::get('orders/{order}/confirmation', [PaymentsController::class, 'confirmation'])
        ->name('orders.confirmation');
});

// ── Secure one-time migration trigger ────────────────────────────────────────
// Set MIGRATION_SECRET in Render env vars. Remove once schema is stable.
Route::get('/run-migrations/{token}', function (string $token) {
    $secret = config('services.migration_secret');

    if (! $secret || ! hash_equals("$secret", "$token")) {
        abort(404);
    }

    try {
        Artisan::call('migrate', ['--force' => true]);
        $output = Artisan::output();
    } catch (\Throwable $e) {
        return response("Migration failed:\n" . $e->getMessage(), 500)
            ->header('Content-Type', 'text/plain');
    }

    return response("Migrations ran successfully.\n\n" . $output, 200)
        ->header('Content-Type', 'text/plain');
});

// ── Secure one-time seeder trigger ───────────────────────────────────────────
// Set SEEDER_SECRET in Render env vars. Remove once seed data is confirmed.
Route::get('/run-seeders/{token}', function (string $token) {
    $secret = config('services.seeder_secret');

    if (! $secret || ! hash_equals("$secret", "$token")) {
        abort(404);
    }

    try {
        Artisan::call('db:seed', ['--force' => true]);
        $output = Artisan::output();
    } catch (\Throwable $e) {
        return response("Seeding failed:\n" . $e->getMessage(), 500)
            ->header('Content-Type', 'text/plain');
    }

    return response("Database seeded successfully.\n\n" . $output, 200)
        ->header('Content-Type', 'text/plain');
});

require __DIR__ . '/auth.php';
