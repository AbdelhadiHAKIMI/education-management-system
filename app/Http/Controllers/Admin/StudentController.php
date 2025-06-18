<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Level;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AcademicYear;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $establishmentId = $user ? $user->establishment_id : null;
        $activeAcademicYear = null;
        if ($establishmentId) {
            $activeAcademicYear = AcademicYear::where('establishment_id', $establishmentId)
                ->where('status', true)
                ->first();
        }

        $branchId = $request->input('branch_id');
        $studentsQuery = $activeAcademicYear
            ? \App\Models\Student::with(['branch', 'level'])
            ->where('academic_year_id', $activeAcademicYear->id)
            : \App\Models\Student::query()->whereRaw('0=1'); // empty if no active year

        if ($branchId) {
            $studentsQuery->where('branch_id', $branchId);
        }

        $students = $studentsQuery->paginate(10);
        $branches = \App\Models\Branch::all();

        return view('admin.students.index', compact('students', 'branches', 'branchId'));
    }

    public function create()
    {
        $levels = Level::all();
        $branches = Branch::all();
        return view('admin.students.create', compact('levels', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'level_id' => 'required|exists:levels,id',
            // Add other validation rules as needed
        ]);
        Student::create($request->all());
        return redirect()->route('admin.students.index')->with('success', 'تم إضافة الطالب بنجاح');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $levels = Level::all();
        $branches = Branch::all();
        return view('admin.students.edit', compact('student', 'levels', 'branches'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'branch_id' => 'required|exists:branches,id',
            'level_id' => 'required|exists:levels,id',
            // Add other validation rules as needed
        ]);
        $student->update($request->all());
        return redirect()->route('admin.students.index')->with('success', 'تم تحديث بيانات الطالب بنجاح');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'تم حذف الطالب بنجاح');
    }
}
