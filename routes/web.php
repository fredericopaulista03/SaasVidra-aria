<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/debug.php';

$primaryDomain = parse_url(config('app.url'), PHP_URL_HOST);

// Register routes for the primary domain (Global)
Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // Landlord Routes (Super Admin)
    Route::middleware(['auth', 'verified', App\Http\Middleware\EnsureUserIsSuperAdmin::class])->prefix('landlord')->name('landlord.')->group(function () {
        Route::resource('tenants', App\Http\Controllers\Landlord\TenantController::class);
        
        // SaaS Management
        Route::resource('plans', App\Http\Controllers\Landlord\PlanController::class);
        Route::post('plans/{plan}/toggle-status', [App\Http\Controllers\Landlord\PlanController::class, 'toggleStatus'])->name('plans.toggle-status');
        
        Route::resource('subscriptions', App\Http\Controllers\Landlord\SubscriptionController::class);
        Route::resource('invoices', App\Http\Controllers\Landlord\InvoiceController::class);
        Route::get('payment-logs', [App\Http\Controllers\Landlord\PaymentLogController::class, 'index'])->name('payment-logs.index');
    });

    // Shared Auth Routes (Profile) - Adjusted to handle context dynamically or via middleware
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
});

// Tenant Routes - Initialized by User Session
Route::middleware(['web', 'auth', 'verified', App\Http\Middleware\InitializeTenancyByUser::class])
    ->group(function () {
        // Load tenant routes manually here since we disabled automatic loading
        // We can require the file, but we need to ensure the file itself doesn't have conflicting middleware
        // For now, let's define the core tenant dashboard here to test
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Include other tenant routes
        // We will refactor tenant.php to be just a list of routes without the Route::group wrapper
        // or we can define them here directly.
        // Let's require the modified tenant.php
        require __DIR__.'/tenant.php';
    });
