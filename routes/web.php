<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/forgot-password', function () {return view('auth.forgot-password');})->name('password.request');

Route::get('/reset-password/{token}', function ($token) {return view('auth.reset-password', ['token' => $token]);})->name('password.reset');

// Webmaster Routes
Route::prefix('webmaster')->group(function () {
    Route::get('/dashboard', function () {
        return view('webmaster.dashboard');
    })->name('webmaster.dashboard');
    
    Route::prefix('establishments')->group(function () {
        Route::get('/', function () {
            return view('webmaster.establishments.index');
        })->name('webmaster.establishments.index');
        
        Route::get('/create', function () {
            return view('webmaster.establishments.create');
        })->name('webmaster.establishments.create');
        
        Route::get('/{id}', function ($id) {
            return view('webmaster.establishments.show', ['id' => $id]);
        })->name('webmaster.establishments.show');
        
        Route::get('/{id}/edit', function ($id) {
            return view('webmaster.establishments.edit', ['id' => $id]);
        })->name('webmaster.establishments.edit');
    });
});

// Home Route
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('/webmaster/dashboard');
});

Route::get('/admin/dashboard', function () {
    return view('/admin/dashboard');
});

Route::get('/admin/programs/create', function () {
    return view('/admin/programs/create');
});
Route::get('/admin/programs/index', function () {
    return view('/admin/programs/index');
});