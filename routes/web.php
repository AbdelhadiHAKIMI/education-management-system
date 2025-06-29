<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController; // Keep this import if you use it for webmaster.dashboard
use App\Http\Controllers\CsvProcessorController;
use App\Http\Controllers\EstablishmentController;
use App\Http\Controllers\AddStudentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProgramController;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ClassroomsController;
use App\Http\Controllers\ProgramInvitationImportController;
use App\Http\Controllers\Admin\ProgramInvitationController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\StaffController;
use App\Models\Branch;
use App\Models\Subject;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\Admin\ExamSessionController;


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


// // Steff Routes
// Route::prefix('admin/staffs')->middleware(['auth'])->group(function () {
//     Route::get('/', [StaffController::class, 'index'])->name('admin.staffs.index');
//     Route::get('/create', [StaffController::class, 'create'])->name('admin.staffs.create');
//     Route::post('/', [StaffController::class, 'store'])->name('admin.staffs.store');
//     Route::get('/{staff}', [StaffController::class, 'show'])->name('admin.staffs.show');
//     Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('admin.staffs.edit');
//     Route::put('/{staff}', [StaffController::class, 'update'])->name('admin.staffs.update');
//     Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('admin.staffs.destroy'); 
// });

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
   Route::get('/dashboard', function () {
      $establishment = session('establishment') ?? (Auth::user()->establishment ?? null);
      // $establishmentId = $establishment->id ?? null; // No longer needed for programs

      // FIX: Remove establishment_id filter from programs query
      $studentsCount = \App\Models\Student::count();

      // Active programs count (no establishment_id filter)
      $programsCount = \App\Models\Program::where('is_active', true)->count();

      // Example: Monthly payments (replace with your real logic)
      $monthlyPayments = 12500;

      // Example: Attendance rate (replace with your real logic)
      $attendanceRate = 89; // You should calculate this from your attendance table

      // Fetch recent students
      $recentStudents = \App\Models\Student::latest()->take(3)->get();

      // Fetch recent programs (no establishment_id filter)
      $recentPrograms = \App\Models\Program::latest()->take(3)->get();

      // Remove recentPayments section (no payments table)
      $recentPayments = [];

      // Remove recentAttendance section (no attendances table)
      $recentAttendance = [];

      $recentActivities = [];

      foreach ($recentPrograms as $program) {
         $recentActivities[] = [
            'icon' => 'fas fa-calendar-plus',
            'icon_bg' => 'bg-indigo-100',
            'icon_color' => 'text-indigo-600',
            'title' => 'تم إنشاء برنامج جديد: ' . $program->name,
            'desc' => 'الفترة: ' . \Carbon\Carbon::parse($program->start_date)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($program->end_date)->format('d/m/Y'),
            'time' => $program->created_at ? $program->created_at->diffForHumans() : '',
         ];
      }

      foreach ($recentStudents as $student) {
         $recentActivities[] = [
            'icon' => 'fas fa-user-plus',
            'icon_bg' => 'bg-blue-100',
            'icon_color' => 'text-blue-600',
            'title' => 'تم تسجيل طالب جديد: ' . $student->full_name,
            'desc' => 'الشعبة: ' . ($student->branch->name ?? '-'),
            'time' => $student->created_at ? $student->created_at->diffForHumans() : '',
         ];
      }

      // Remove recentPayments loop (no payments table)
      // Remove recentAttendance loop (no attendances table)

      // Sort all activities by time (most recent first)
      usort($recentActivities, function ($a, $b) {
         return strtotime($b['time']) <=> strtotime($a['time']);
      });

      return view('admin.dashboard', compact(
         'establishment',
         'recentActivities',
         'studentsCount',
         'programsCount',
         'monthlyPayments',
         'attendanceRate'
      ));
   })->name('admin.dashboard');

   // Place the show route BEFORE the update route and restrict {program} to numbers
   Route::get('/programs/show/{program}', [ProgramController::class, 'show'])->name('admin.programs.show');

   // Programs Routes
   Route::get('/programs/index', [ProgramController::class, 'index'])->name('admin.programs.index');
   Route::get('/programs/create', [ProgramController::class, 'create'])->name('admin.programs.create');
   Route::post('/programs/store', [ProgramController::class, 'store'])->name('admin.programs.store');
   Route::get('/programs/{program}/edit', [ProgramController::class, 'edit'])->where('program', '[0-9]+')->name('admin.programs.edit');
   Route::get('/programs/{program}/show', [ProgramController::class, 'show'])->where('program', '[0-9]+')->name('admin.programs.show');
   Route::put('/programs/{program}', [ProgramController::class, 'update'])->where('program', '[0-9]+')->name('admin.programs.update');

   // REMOVE this line to avoid route conflict:
   // Route::get('/programs/{program}', [ProgramController::class, 'show'])->name('admin.programs.show');

   Route::get('/programs/attendance', [ProgramController::class, 'attendance'])->name('admin.programs.attendance');


   // Students Routes
   Route::get('/students/index', [StudentController::class, 'index'])->name('admin.students.index');
   Route::get('/students/create', [StudentController::class, 'create'])->name('admin.students.create');
   Route::get('/students/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
   Route::get('/students/show', [StudentController::class, 'show'])->name('admin.students.show');
   Route::post('/store', [AddStudentController::class, 'store'])->name('students.store');
});

// ADMIN PROGRAMS ROUTES - KEPT AS IS FOR NOW
Route::get('/admin/program/create', function () {
   return view('/admin/programs/create');
});


// Route::get('/admin/programs/create', function () {
//    return view('/admin/programs/create');
// });


Route::prefix('admin/staffs')->middleware(['auth'])->group(function () {
   Route::get('/', [StaffController::class, 'index'])->name('admin.staffs.index');
   Route::get('/create', [StaffController::class, 'create'])->name('admin.staffs.create');
   Route::post('/', [StaffController::class, 'store'])->name('admin.staffs.store');
   Route::get('/{staff}', [StaffController::class, 'show'])->name('admin.staffs.show');
   Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('admin.staffs.edit');
   Route::put('/{staff}', [StaffController::class, 'update'])->name('admin.staffs.update');
   Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('admin.staffs.destroy');
});
// Route::get('/admin/programs/index', function () {
//    return view('/admin/programs/index');
// });


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
   Route::get('/branches/{branch}/subjects', function (Branch $branch) {
      // Always get the active academic year for the user's establishment
      $userEstablishmentId = Auth::user()->establishment_id;
      $activeAcademicYear = \App\Models\AcademicYear::where('establishment_id', $userEstablishmentId)
         ->where('status', true)
         ->first();

      // Authorization: Ensure the branch's academic year matches the user's active academic year
      if (
         !$activeAcademicYear ||
         $branch->level->academicYear->establishment_id !== $userEstablishmentId ||
         $branch->level->academic_year_id !== $activeAcademicYear->id
      ) {
         abort(403, 'Unauthorized access to branch subjects.');
      }

      // Return as { subjects: [...] } for frontend compatibility
      return response()->json([
         'subjects' => $branch->subjects()->get(['id', 'name'])
      ]);
   })->name('admin.branches.subjects');

   // Update invitation status (AJAX)
   Route::post('/programs/invitations/{invitation}/status', [ProgramController::class, 'updateInvitationStatus'])
      ->name('admin.programs.invitations.updateStatus');

   // Filter/search invited students (AJAX)
   Route::get('/programs/{program}/invitations/filter', [ProgramController::class, 'filterInvitedStudents'])
      ->name('admin.programs.invitations.filter');
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

// Exam Results Prototype Page (UI for download/upload)
Route::get('/exam-results/prototype-form', [\App\Http\Controllers\ExamResultController::class, 'prototypeForm'])->name('exam_results.prototype.form');
Route::get('/exam-results/prototype-download', [ExamResultController::class, 'prototypeDownload'])->name('exam_results.prototype.download');
Route::post('/exam-results/import', [ExamResultController::class, 'importResults'])->name('exam_results.import');
Route::get('/exam-results/reset', [ExamResultController::class, 'resetSelection'])->name('exam_results.prototype.reset');


Route::get('/admin/levels/dashboard', function () {
   return view('admin.levels.dashboard');
})->name('admin.levels.dashboard');

Route::prefix('admin/levels')->middleware(['auth'])->group(function () {
   Route::get('/', [LevelController::class, 'index'])->name('admin.levels.index');
   Route::get('/dashboard', [LevelController::class, 'index'])->name('admin.levels.dashboard');
   Route::post('/', [LevelController::class, 'store'])->name('admin.levels.store');
   Route::put('/{level}', [LevelController::class, 'update'])->name('admin.levels.update');
   Route::delete('/{level}', [LevelController::class, 'destroy'])->name('admin.levels.destroy');
   Route::get('/{level}', [LevelController::class, 'show'])->name('admin.levels.show');
});


Route::post('/academic-years/{id}/activate', [AcademicYearController::class, 'activate'])->name('academic-years.activate');

// Students CRUD routes (add under admin prefix, with auth middleware)
Route::prefix('admin/students')->middleware(['auth'])->group(function () {
   Route::get('/', [\App\Http\Controllers\Admin\StudentController::class, 'index'])->name('admin.students.index');
   Route::get('/create', [\App\Http\Controllers\Admin\StudentController::class, 'create'])->name('admin.students.create');
   Route::post('/', [\App\Http\Controllers\Admin\StudentController::class, 'store'])->name('admin.students.store');
   Route::get('/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'show'])->name('admin.students.show');
   Route::get('/{student}/edit', [\App\Http\Controllers\Admin\StudentController::class, 'edit'])->name('admin.students.edit');
   Route::put('/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'update'])->name('admin.students.update');
   Route::delete('/{student}', [\App\Http\Controllers\Admin\StudentController::class, 'destroy'])->name('admin.students.destroy');
   Route::post('/import', [\App\Http\Controllers\Admin\StudentController::class, 'import'])->name('admin.students.import');
});

// Add this route for subject creation in admin panel
Route::post('/admin/subjects/store', [\App\Http\Controllers\Admin\SubjectController::class, 'store'])->name('admin.subjects.store');

Route::get('/exam-results/dashboard', [\App\Http\Controllers\ExamResultController::class, 'dashboard'])->name('exam_results.dashboard');

Route::prefix('admin/programs')->middleware(['auth'])->group(function () {
   Route::get('/wizard/step1', [ProgramController::class, 'wizardStep1'])->name('admin.programs.wizard.step1');
   Route::post('/wizard/step1', [ProgramController::class, 'wizardStep1Post'])->name('admin.programs.wizard.step1.post');
   Route::get('/wizard/step2', [ProgramController::class, 'wizardStep2'])->name('admin.programs.wizard.step2');
   Route::post('/wizard/step2', [ProgramController::class, 'wizardStep2Post'])->name('admin.programs.wizard.step2.post');
   Route::get('/wizard/step3', [ProgramController::class, 'wizardStep3'])->name('admin.programs.wizard.step3');
   Route::post('/wizard/step3', [ProgramController::class, 'wizardStep3Post'])->name('admin.programs.wizard.step3.post');
   Route::get('/wizard/step4', [ProgramController::class, 'wizardStep4'])->name('admin.programs.wizard.step4');
   Route::post('/wizard/step4', [ProgramController::class, 'wizardStep4Post'])->name('admin.programs.wizard.step4.post');
});

// Exam Results Prototype Upload (admin, filtered)
Route::get('admin/exam-results/prototype/{establishment_id}/{academic_year_id}', [\App\Http\Controllers\ExamResultController::class, 'adminPrototypeForm'])
   ->name('admin.exam_results.prototype')
   ->middleware(['auth', 'admin']);

// Exam Results Dashboard (admin, filtered)
Route::get('admin/exam-results/dashboard/{establishment_id}/{academic_year_id}/{exam_session_id}', [\App\Http\Controllers\ExamResultController::class, 'adminDashboard'])
   ->name('admin.exam_results.dashboard')
   ->middleware(['auth', 'admin']);

// Set active exam session (only one active per establishment at a time)
Route::post('admin/exam-sessions/{exam_session}/activate', [\App\Http\Controllers\ExamResultController::class, 'activateExamSession'])
   ->name('admin.exam_sessions.activate')
   ->middleware(['auth', 'admin']);

// New routes for Exam Results functionality
Route::middleware(['auth'])->group(function () {
   Route::get('/exam-results/prototype', [ExamResultController::class, 'prototypeForm'])->name('exam_results.prototype.form');
   Route::get('/exam-results/dashboard', [ExamResultController::class, 'dashboard'])->name('exam_results.dashboard');
   Route::post('/exam-sessions/{session}/activate', [App\Http\Controllers\Admin\ExamSessionController::class, 'activate'])->name('exam_sessions.activate');
});

Route::post('/academic-years', [AcademicYearController::class, 'store'])->name('academic-years.store');

Route::post('/academic-years', [AcademicYearController::class, 'store'])->name('academic-years.store');
