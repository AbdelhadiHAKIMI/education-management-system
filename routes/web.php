<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CsvProcessorController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ProgramInvitationImportController;
use App\Http\Controllers\Admin\ProgramInvitationController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Admin\LevelController;

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


Route::get('/admin/dashboard', function () {
   return view('/admin/dashboard');
})->name('admin.dashboard');


Route::get('/admin/program/create', function () {
   return view('/admin/programs/create');
});

Route::prefix('admin/staffs')->middleware(['auth'])->group(function () {
   Route::get('/', [StaffController::class, 'index'])->name('admin.staffs.index');
   Route::get('/create', [StaffController::class, 'create'])->name('admin.staffs.create');
   Route::post('/', [StaffController::class, 'store'])->name('admin.staffs.store');
   Route::get('/{staff}', [StaffController::class, 'show'])->name('admin.staffs.show');
   Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('admin.staffs.edit');
   Route::put('/{staff}', [StaffController::class, 'update'])->name('admin.staffs.update');
   Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('admin.staffs.destroy');
});
Route::get('/admin/programs/index', function () {
   return view('/admin/programs/index');
});

Route::get('/csv-processor', [CsvProcessorController::class, 'index'])->name('csv.processor');
Route::post('/csv-processor/upload', [CsvProcessorController::class, 'upload'])->name('csv.upload');
Route::post('/csv-processor/filter', [CsvProcessorController::class, 'filter'])->name('csv.filter');
Route::post('/csv-processor/generate', [CsvProcessorController::class, 'generate'])->name('csv.generate');
Route::get('/csv-processor/download', [CsvProcessorController::class, 'download'])->name('csv.download');
Route::get('/csv-processor/show', [CsvProcessorController::class, 'show'])->name('csv.show');
Route::get('/csv-processor/prototype', [CsvProcessorController::class, 'prototype'])->name('csv.prototype');
Route::get('/csv-processor/prototype-xlsx', [CsvProcessorController::class, 'prototypeXlsx'])->name('csv.prototype.xlsx');

Route::get('/admin/students/classrooms', [ClassroomsController::class, 'index'])->name('admin.students.classrooms');
Route::get('/admin/students/classrooms/generate', [ClassroomsController::class, 'generate'])->name('admin.students.classrooms.generate');

Route::get('/admin/program-invitations/import', [ProgramInvitationImportController::class, 'showImportForm'])->name('admin.program_invitations.import.form');
Route::post('/admin/program-invitations/import', [ProgramInvitationImportController::class, 'import'])->name('admin.program_invitations.import');

Route::view('/admin/program-invitations/import-blade', 'admin.program_invitations.import')->name('admin.program_invitations.import.blade');

Route::get('/admin/program-invitations/prototype', [ProgramInvitationImportController::class, 'prototype'])->name('admin.program_invitations.prototype');

Route::get('admin/program-invitations/download-students', [ProgramInvitationController::class, 'downloadStudents'])->name('admin.program_invitations.download_students');

Route::get('/admin/exam-results/prototype', [\App\Http\Controllers\Admin\ProgramInvitationController::class, 'examResultsPrototype'])->name('admin.exam_results.prototype');

Route::get('/exam-results/prototype', [\App\Http\Controllers\Admin\ProgramInvitationController::class, 'examResultsPrototype']);

Route::get('/exam-results/prototype-form', [ExamResultController::class, 'prototypeForm'])->name('exam_results.prototype.form');
Route::get('/exam-results/prototype-download', [ExamResultController::class, 'prototypeDownload'])->name('exam_results.prototype.download');
Route::post('/exam-results/import', [ExamResultController::class, 'importResults'])->name('exam_results.import');
Route::get('/exam-results/reset', [ExamResultController::class, 'resetSelection'])->name('exam_results.prototype.reset');

Route::get('/admin/levels/dashboard', function () {
   return view('admin.levels.dashboard');
})->name('admin.levels.dashboard');

Route::prefix('admin/levels')->middleware(['auth'])->group(function () {
   Route::get('/dashboard', [LevelController::class, 'index'])->name('admin.levels.dashboard');
   Route::post('/', [LevelController::class, 'store'])->name('admin.levels.store');
   Route::put('/{level}', [LevelController::class, 'update'])->name('admin.levels.update');
   Route::delete('/{level}', [LevelController::class, 'destroy'])->name('admin.levels.destroy');
   Route::get('/{level}', [LevelController::class, 'show'])->name('admin.levels.show');
});
