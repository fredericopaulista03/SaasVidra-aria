<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

$primaryDomain = parse_url(config('app.url'), PHP_URL_HOST);

// Register routes for the primary domain
Route::domain($primaryDomain)->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    // Landlord Routes
    Route::middleware(['auth', 'verified'])->prefix('landlord')->name('landlord.')->group(function () {
        Route::resource('tenants', App\Http\Controllers\Landlord\TenantController::class);
    });

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
});

// Redirect other central domains to the primary domain
foreach (config('tenancy.central_domains') as $domain) {
    if ($domain === $primaryDomain) {
        continue;
    }

    Route::domain($domain)->group(function () use ($primaryDomain) {
        Route::any('/{path?}', function ($path = null) use ($primaryDomain) {
            $url = config('app.url') . ($path ? '/' . $path : '');
            return redirect($url, 301);
        })->where('path', '.*');
    });
}
