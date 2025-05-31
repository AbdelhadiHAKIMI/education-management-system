<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class AddStudentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'origin_school' => 'nullable|string|max:255',
            'health_conditions' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:30',
            'student_phone' => 'nullable|string|max:30',
            'quran_level' => 'nullable|string|max:255',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        Student::create($validated);

        return redirect()->back()->with('success', 'تمت إضافة الطالب بنجاح');
    }
}
