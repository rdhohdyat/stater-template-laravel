<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root to login or dashboard
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : redirect('/login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Auth required)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/settings', [\App\Http\Controllers\ProfileController::class, 'index'])->name('settings');
    Route::put('/settings', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/settings/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/settings/photo', [\App\Http\Controllers\ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::delete('/settings', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/history', [\App\Http\Controllers\ActivityLogController::class, 'history'])->name('activitylogs.history');

    // Admin Only Routes
    Route::middleware('role:admin')->group(
        function () {
            Route::get('/activity-logs', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activitylogs.index');
            Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
            Route::get('/users/export/excel', [\App\Http\Controllers\UserController::class, 'exportExcel'])->name('users.export.excel');
            Route::get('/users/{user}/export/pdf', [\App\Http\Controllers\UserController::class, 'exportPdf'])->name('users.export.pdf');
            Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
            Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

            // Backup Routes
            Route::get('/backups', [\App\Http\Controllers\BackupController::class, 'index'])->name('backups.index');
            Route::post('/backups/run', [\App\Http\Controllers\BackupController::class, 'run'])->name('backups.run');
            Route::get('/backups/download', [\App\Http\Controllers\BackupController::class, 'download'])->name('backups.download');
        }
    );
});
