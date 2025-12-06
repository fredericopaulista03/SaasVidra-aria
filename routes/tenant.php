<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

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


// Tenant Routes (Loaded via web.php with InitializeTenancyByUser middleware)

Route::name('tenant.')->group(function () {
    
    // Dashboard is already defined in web.php but we can alias it here if needed or keep it consistent
    // Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('clients', App\Http\Controllers\Tenant\ClientController::class);
    Route::resource('products', App\Http\Controllers\Tenant\ProductController::class);
    Route::resource('budgets', App\Http\Controllers\Tenant\BudgetController::class);
    Route::get('/budgets/{budget}/pdf', [App\Http\Controllers\Tenant\BudgetController::class, 'downloadPdf'])->name('budgets.pdf');

    Route::get('/kanban', [App\Http\Controllers\Tenant\KanbanController::class, 'index'])->name('kanban.index');
    Route::put('/kanban/{card}', [App\Http\Controllers\Tenant\KanbanController::class, 'update'])->name('kanban.update');

    Route::resource('finance', App\Http\Controllers\Tenant\FinancialTransactionController::class);
    Route::get('/schedule', [App\Http\Controllers\Tenant\ScheduleController::class, 'index'])->name('schedule.index');

    // Chat Routes
    Route::get('/chat', [App\Http\Controllers\Tenant\ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [App\Http\Controllers\Tenant\ChatController::class, 'store'])->name('chat.store');
});

