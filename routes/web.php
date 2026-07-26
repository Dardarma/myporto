<?php

use App\Http\Controllers\Admin\PortfolioAdminController;
use App\Http\Controllers\PortfolioHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', PortfolioHomeController::class)->name('home');

Route::redirect('dashboard', 'admin/portfolio/profiles')->middleware('auth');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('portfolio/{resource?}', [PortfolioAdminController::class, 'index'])->name('portfolio.index');
    Route::post('portfolio/{resource}', [PortfolioAdminController::class, 'store'])->name('portfolio.store');
    Route::put('portfolio/{resource}/{id}', [PortfolioAdminController::class, 'update'])->name('portfolio.update');
    Route::delete('portfolio/{resource}/{id}', [PortfolioAdminController::class, 'destroy'])->name('portfolio.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
