<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Level;
use App\Models\Staff;
use App\Models\Student;

class ProgramController extends Controller
{
    // ...existing code...

    public function create()
    {
        // Fetch all students from the database
        $students = Student::all(); // Ensure the Student model is imported

        // Fetch academic years, levels, and staff for other steps
        $academicYears = AcademicYear::all();
        $levels = Level::all();
        $staff = Staff::all();

        // Pass the data to the view
        return view('admin.programs.create', compact('students', 'academicYears', 'levels', 'staff'));
    }

    // ...existing code...
}
