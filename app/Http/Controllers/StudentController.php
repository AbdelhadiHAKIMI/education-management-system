<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request){
        $establishmentId = session('establishment')->id ?? (Auth::check() && Auth::user()->establishment ? Auth::user()->establishment->id : 1);
        $students = Student::whereHas('branch.level.academicYear', function($q) use ($establishmentId) {
            $q->where('establishment_id', $establishmentId);
        })->with(['branch.level.academicYear'])->get();
        return view('admin.students.index', compact('students'));
    }

    // Add create, edit, show methods as needed...
}
