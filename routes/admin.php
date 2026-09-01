<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('users-import/template', [UserController::class, 'downloadTemplate'])
        ->name('users.import.template');
    Route::get('users-import', [UserController::class, 'import'])->name('users.import');
    Route::post('users-import', [UserController::class, 'storeImport'])->name('users.import.store');

    Route::resource('users', UserController::class)->only(['index', 'create', 'show', 'edit']);
});
