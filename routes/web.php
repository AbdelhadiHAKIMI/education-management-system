<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // Keep this import if you use it for webmaster.dashboard
use App\Http\Controllers\CsvProcessorController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\StaffController;
use App\Models\Branch; // Make sure Branch is imported
use App\Models\Subject; // Make sure Subject is imported
use Illuminate\Support\Facades\Auth; // Make sure Auth is imported

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

// Webmaster Routes
Route::prefix('webmaster')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('webmaster.dashboard');

    // Establishments Routes
    Route::prefix('establishments')->group(function () {
        Route::get('/', [EstablishmentController::class, 'index'])
            ->name('webmaster.establishments.index');

        Route::get('/create', function () {
            return view('webmaster.establishments.create');
        })->name('webmaster.establishments.create');

        Route::post('/store', [EstablishmentController::class, 'store'])
            ->name('webmaster.establishments.store');

        Route::get('/{establishment}/edit', [EstablishmentController::class, 'edit'])
            ->name('webmaster.establishments.edit');

        Route::get('/{establishment}', [EstablishmentController::class, 'show'])
            ->name('webmaster.establishments.show');

        Route::put('/{establishment}', [EstablishmentController::class, 'update'])
            ->name('webmaster.establishments.update');

        Route::delete('/{establishment}', [EstablishmentController::class, 'destroy'])
            ->name('webmaster.establishments.destroy');

        Route::delete('/remove-admin/{user}', [EstablishmentController::class, 'removeAdmin'])
            ->name('webmaster.establishments.removeAdmin');
    });
});

// Home Route
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('/webmaster/dashboard');
});

// ADMIN DASHBOARD - KEPT STATIC AS REQUESTED
Route::get('/admin/dashboard', function () {
    return view('/admin/dashboard');
})->name('admin.dashboard');

// ADMIN PROGRAMS ROUTES - KEPT AS IS FOR NOW
Route::get('/admin/program/create', function () {
    return view('/admin/programs/create');
});

Route::get('/admin/programs/index', function () {
    return view('/admin/programs/index');
});


// **FIXED STAFF ROUTES**
// Group all admin-related staff routes under a single 'admin' prefix
// This ensures that the StaffController methods are correctly mapped to URLs like /admin/staffs, /admin/staffs/create, etc.
Route::prefix('admin')->middleware(['auth'])->group(function () {

    // Define the resource routes for staff. This single line correctly generates:
    // GET      /admin/staffs           -> StaffController@index  (admin.staffs.index)
    // GET      /admin/staffs/create    -> StaffController@create (admin.staffs.create)
    // POST     /admin/staffs           -> StaffController@store  (admin.staffs.store)
    // GET      /admin/staffs/{staff}   -> StaffController@show   (admin.staffs.show)
    // GET      /admin/staffs/{staff}/edit -> StaffController@edit (admin.staffs.edit)
    // PUT/PATCH /admin/staffs/{staff}  -> StaffController@update (admin.staffs.update)
    // DELETE   /admin/staffs/{staff}   -> StaffController@destroy (admin.staffs.destroy)
    Route::resource('staffs', StaffController::class)->names('admin.staffs');

    // API endpoint for fetching subjects by branch, now correctly placed
    // This route needs to be inside the 'admin' prefix so its URL is /admin/branches/{branch}/subjects
    // and it's protected by the 'auth' middleware.
    Route::get('/branches/{branch}/subjects', function(Branch $branch) {
        // Authorization check: Ensure the branch belongs to the user's establishment
        if (Auth::check() && $branch->level->academicYear->establishment_id !== Auth::user()->establishment_id) {
            abort(403, 'Unauthorized access to branch subjects.');
        }
        return $branch->subjects()->get(['id', 'name']); // Return only ID and name for efficiency
    })->name('admin.branches.subjects');

});
// **END FIXED STAFF ROUTES**


// CSV Processor Routes (ensure these are correctly permissioned/middleware protected)
Route::prefix('csv-processor')->middleware(['auth'])->group(function () { // Added middleware for security
    Route::get('/', [CsvProcessorController::class, 'index'])->name('csv.processor');
    Route::post('/upload', [CsvProcessorController::class, 'upload'])->name('csv.upload');
    Route::post('/filter', [CsvProcessorController::class, 'filter'])->name('csv.filter');
    Route::post('/generate', [CsvProcessorController::class, 'generate'])->name('csv.generate');
    Route::get('/download', [CsvProcessorController::class, 'download'])->name('csv.download');
    Route::get('/show', [CsvProcessorController::class, 'show'])->name('csv.show');
    Route::get('/prototype', [CsvProcessorController::class, 'prototype'])->name('csv.prototype');
    Route::get('/prototype-xlsx', [CsvProcessorController::class, 'prototypeXlsx'])->name('csv.prototype.xlsx');
});