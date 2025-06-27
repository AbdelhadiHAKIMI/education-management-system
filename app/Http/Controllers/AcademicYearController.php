<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    // ...existing code...

    public function activate($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        // Deactivate all other years for this establishment (set status to false)
        AcademicYear::where('establishment_id', $academicYear->establishment_id)
            ->where('status', true)
            ->update(['status' => false]);

        // Activate the selected year (set status to true)
        $academicYear->update(['status' => true]);

        return back()->with('success', 'Academic year activated!');
    }

    public function store(Request $request)
    {
        // Add validation for start_date and end_date
        $request->validate([
            'name' => 'required|string|max:255',
            'establishment_id' => 'required|exists:establishments,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $academicYear = AcademicYear::create([
            'name' => $request->input('name'),
            'establishment_id' => $request->input('establishment_id'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'status' => false, // or true if you want to activate by default
        ]);

        // Create three default exam sessions
        $sessions = [
            ['name' => 'الفصل الأول', 'semester' => 'first'],
            ['name' => 'الفصل الثاني', 'semester' => 'second'],
            ['name' => 'الفصل الثالث ', 'semester' => 'third'],
        ];
        foreach ($sessions as $session) {
            \App\Models\ExamSession::create([
                'name' => $session['name'],
                'academic_year_id' => $academicYear->id,
                'semester' => $session['semester'],
                'is_current' => false,
            ]);
        }

        return redirect()->back()->with('success', 'تمت إضافة السنة الدراسية بنجاح.');
    }

    // ...existing code...
}
