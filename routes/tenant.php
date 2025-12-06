<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('tenant.dashboard');

    Route::resource('clients', App\Http\Controllers\Tenant\ClientController::class)
        ->names('tenant.clients')
        ->middleware(['auth', 'verified']);

    Route::resource('products', App\Http\Controllers\Tenant\ProductController::class)
        ->names('tenant.products')
        ->middleware(['auth', 'verified']);

    Route::resource('budgets', App\Http\Controllers\Tenant\BudgetController::class)
        ->names('tenant.budgets')
        ->middleware(['auth', 'verified']);

    Route::get('/kanban', [App\Http\Controllers\Tenant\KanbanController::class, 'index'])
        ->name('tenant.kanban.index')
        ->middleware(['auth', 'verified']);
        
    Route::put('/kanban/{card}', [App\Http\Controllers\Tenant\KanbanController::class, 'update'])
        ->name('tenant.kanban.update')
        ->middleware(['auth', 'verified']);

    Route::resource('finance', App\Http\Controllers\Tenant\FinancialTransactionController::class)
        ->names('tenant.finance')
        ->middleware(['auth', 'verified']);

    Route::get('/schedule', [App\Http\Controllers\Tenant\ScheduleController::class, 'index'])
        ->name('tenant.schedule.index')
        ->middleware(['auth', 'verified']);

    // Chat Routes
    Route::get('/chat', [App\Http\Controllers\Tenant\ChatController::class, 'index'])
        ->name('tenant.chat.index')
        ->middleware(['auth', 'verified']);
    Route::post('/chat', [App\Http\Controllers\Tenant\ChatController::class, 'store'])
        ->name('tenant.chat.store')
        ->middleware(['auth', 'verified']);

    require __DIR__.'/auth.php';
});

// Webhook Route (Public)
Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::post('/webhook/evolution', [App\Http\Controllers\Tenant\ChatController::class, 'webhook'])
        ->name('tenant.chat.webhook');
});

// Client Portal Routes (Public but Signed)
Route::middleware([
    'web',
    'signed',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/portal/budget/{budget}', [App\Http\Controllers\Tenant\ClientPortalController::class, 'show'])
        ->name('tenant.portal.budget');
    Route::get('/portal/budget/{budget}/approve', [App\Http\Controllers\Tenant\ClientPortalController::class, 'approve'])
        ->name('tenant.portal.approve');
    Route::get('/portal/budget/{budget}/reject', [App\Http\Controllers\Tenant\ClientPortalController::class, 'reject'])
        ->name('tenant.portal.reject');
});
