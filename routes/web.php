<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RespondentController;
use App\Http\Controllers\FormSettingController;
use App\Http\Controllers\YearController;

// Public Routes
Route::get('/', [FeedbackController::class, 'index'])->name('home');
Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
});

// Admin Panel Routes (Protected)
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');

    // Respondents List
    Route::get('/respondents', [RespondentController::class, 'index'])->name('admin.respondents');
    Route::get('/respondents/{id}/preview', [RespondentController::class, 'preview'])->name('admin.respondent.preview');

    // Manage Form Routes
    Route::get('/manage_form', [FormSettingController::class, 'index'])->name('admin.manage_form');
    Route::post('/manage_form/update', [FormSettingController::class, 'update'])->name('admin.manage_form.update');

    Route::get('/admin/years', [YearController::class, 'getYears'])->name('admin.years');

    // Logout Route
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
});
