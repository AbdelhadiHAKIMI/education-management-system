<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $establishmentId = session('establishment')->id ?? (Auth::check() && Auth::user()->establishment ? Auth::user()->establishment->id : 1);
        $students = Student::whereHas('branch.level.academicYear', function ($q) use ($establishmentId) {
            $q->where('establishment_id', $establishmentId);
        })->with(['branch.level.academicYear'])->get();
        return view('admin.students.index', compact('students'));
    }

    // Add this store method to always set academic_year_id
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'level_id' => 'required|exists:levels,id',
            // ...other validation rules...
        ]);

        $user = Auth::user();
        $establishmentId = $user ? $user->establishment_id : null;
        $activeAcademicYear = null;
        if ($establishmentId) {
            $activeAcademicYear = \App\Models\AcademicYear::where('establishment_id', $establishmentId)
                ->where('status', true)
                ->first();
        }

        $data = $request->all();
        if ($activeAcademicYear) {
            $data['academic_year_id'] = $activeAcademicYear->id;
        } else {
            return redirect()->back()->withErrors(['academic_year_id' => 'لا توجد سنة دراسية نشطة للمؤسسة.']);
        }

        // Only allow fillable fields
        $allowed = [
            'full_name',
            'birth_date',
            'origin_school',
            'health_conditions',
            'parent_phone',
            'student_phone',
            'quran_level',
            'branch_id',
            'initial_classroom',
            'level_id',
            'academic_year_id'
        ];
        $data = array_intersect_key($data, array_flip($allowed));

        \App\Models\Student::create($data);
        return redirect()->route('admin.students.index')->with('success', 'تم إضافة الطالب بنجاح');
    }

    // Add create, edit, show methods as needed...
}
