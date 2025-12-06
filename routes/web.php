<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/debug.php';

// Webhook Routes (outside CSRF protection)
Route::post('/webhooks/asaas', [App\Http\Controllers\WebhookController::class, 'asaas'])->name('webhooks.asaas');

$primaryDomain = parse_url(config('app.url'), PHP_URL_HOST);

// Register routes for the primary domain (Global)
Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // Landlord Routes (Super Admin)
    Route::middleware(['auth', 'verified', App\Http\Middleware\EnsureUserIsSuperAdmin::class])->prefix('admin')->name('landlord.')->group(function () {
        // Tenants Management
        Route::resource('empresas', App\Http\Controllers\Landlord\TenantController::class);
        Route::post('empresas/{tenant}/suspender', [App\Http\Controllers\Landlord\TenantController::class, 'suspend'])->name('tenants.suspend');
        Route::post('empresas/{tenant}/ativar', [App\Http\Controllers\Landlord\TenantController::class, 'activate'])->name('tenants.activate');
        
        // Plans Management
        Route::resource('planos', App\Http\Controllers\Landlord\PlanController::class);
        Route::post('planos/{plan}/toggle-status', [App\Http\Controllers\Landlord\PlanController::class, 'toggleStatus'])->name('plans.toggle-status');
        
        Route::resource('subscriptions', App\Http\Controllers\Landlord\SubscriptionController::class);
        Route::resource('invoices', App\Http\Controllers\Landlord\InvoiceController::class);
        Route::get('payment-logs', [App\Http\Controllers\Landlord\PaymentLogController::class, 'index'])->name('payment-logs.index');
        
        // Settings
        Route::get('configuracoes', [App\Http\Controllers\Landlord\SettingsController::class, 'index'])->name('settings.index');
        Route::post('configuracoes', [App\Http\Controllers\Landlord\SettingsController::class, 'update'])->name('settings.update');
        Route::post('configuracoes/test-email', [App\Http\Controllers\Landlord\SettingsController::class, 'testEmail'])->name('settings.test-email');
        
        // Email Templates
        Route::get('email-templates', [App\Http\Controllers\Landlord\EmailTemplateController::class, 'index'])->name('email-templates.index');
        Route::get('email-templates/{emailTemplate}/edit', [App\Http\Controllers\Landlord\EmailTemplateController::class, 'edit'])->name('email-templates.edit');
        Route::put('email-templates/{emailTemplate}', [App\Http\Controllers\Landlord\EmailTemplateController::class, 'update'])->name('email-templates.update');
    });

    // Shared Auth Routes (Profile) - Adjusted to handle context dynamically or via middleware
    Route::middleware('auth')->group(function () {
        Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
