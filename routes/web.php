<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\RespondentController;
use App\Http\Controllers\FormSettingController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FeedbackController::class, 'index'])->name('home');
Route::post('/feedback-store', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.form');

Route::get('/units/by-office/{office}', [FeedbackController::class, 'getUnitsByOffice'])
     ->name('public.units.by_office');
Route::get('/employees/by-unit/{unit}', [FeedbackController::class, 'getEmployeesByUnit'])
     ->name('public.employees.by_unit');

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login',  [AdminLoginController::class, 'showLoginForm'])
         ->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])
         ->name('admin.login.submit');
});

/*
|--------------------------------------------------------------------------
| Admin Panel (protected)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
     ->middleware('auth:admin')
     ->name('admin.')
     ->group(function () {

    // Dashboard & Logout
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])
         ->name('dashboard');
    Route::post('/logout', [AdminLoginController::class, 'logout'])
         ->name('logout');

    // Respondents
    Route::get('/respondents', [RespondentController::class, 'respondents'])
         ->name('respondents');
    Route::get('/respondents/{id}/preview', [RespondentController::class, 'preview'])
         ->name('respondent.preview');
    Route::get('/respondents/filter/{year}', [RespondentController::class, 'filterByYear'])
         ->name('respondents.filter');
    Route::get('/respondents/export/pdf/{year}', [RespondentController::class, 'exportToPDF'])
         ->name('respondents.export.pdf');
    Route::get('/respondents/export/csv/{year}', [RespondentController::class, 'exportCSV'])
         ->name('respondents.export.csv');

    // Form Settings
    Route::get('/manage_form', [FormSettingController::class, 'index'])
         ->name('manage_form');
    Route::post('/manage_form/update', [FormSettingController::class, 'update'])
         ->name('manage_form.update');

    // Years JSON endpoint
    Route::get('/years', [YearController::class, 'getYears'])
         ->name('years');

    /*
    |--------------------------------------------------------------------------
    | Office CRUD (modal)
    |--------------------------------------------------------------------------
    */
    Route::get('/offices', [OfficeController::class, 'index'])
         ->name('offices');                        // admin.offices
    Route::post('/offices', [OfficeController::class, 'store'])
         ->name('offices.store');                  // admin.offices.store
    Route::put('/offices/{office}', [OfficeController::class, 'update'])
         ->name('offices.update');                 // admin.offices.update
    Route::post('/offices/{office}/toggle-status', [OfficeController::class, 'toggleStatus'])
         ->name('offices.toggle_status');          // admin.offices.toggle_status

    /*
    |--------------------------------------------------------------------------
    | Units CRUD (modal)
    |--------------------------------------------------------------------------
    */
    Route::get('/units', [UnitController::class, 'index'])
         ->name('units');                          // admin.units
    Route::post('/units', [UnitController::class, 'store'])
         ->name('units.store');                    // admin.units.store
    Route::put('/units/{unit}', [UnitController::class, 'update'])
         ->name('units.update');                   // admin.units.update
    Route::post('/units/{unit}/toggle-status', [UnitController::class, 'toggleStatus'])
         ->name('toggle_unit_status');             // admin.toggle_unit_status

    /*
    |--------------------------------------------------------------------------
    | Employees CRUD (modal)
    |--------------------------------------------------------------------------
    */
    Route::get('/employees', [EmployeeController::class, 'index'])
         ->name('employees');                      // admin.employees
    Route::post('/employees', [EmployeeController::class, 'store'])
         ->name('employees.store');                // admin.employees.store
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])
         ->name('employees.update');               // admin.employees.update
    Route::post('/employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])
         ->name('toggle_employee_status');         // admin.toggle_employee_status
});
