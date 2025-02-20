<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', [FeedbackController::class, 'index'])->name('home');
Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/respondents', [AdminDashboardController::class, 'respondents'])->name('admin.respondents'); // ✅ Add this line
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});
