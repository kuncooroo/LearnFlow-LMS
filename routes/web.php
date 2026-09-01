<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\Shared\FoundationStatus;
use Illuminate\Support\Facades\Route;

Route::get('/', FoundationStatus::class)->name('home');

Route::middleware('auth')->group(function (): void {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
