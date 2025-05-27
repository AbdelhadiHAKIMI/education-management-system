<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $establishmentId = $user->establishment_id;
        $academicYears = AcademicYear::where('establishment_id', $establishmentId)->orderByDesc('end_date')->get();
        $levels = Level::with('academicYear')
            ->whereHas('academicYear', function ($q) use ($establishmentId) {
                $q->where('establishment_id', $establishmentId);
            })
            ->orderByDesc('id')
            ->get();

        return view('admin.levels.dashboard', compact('levels', 'academicYears'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $establishmentId = $user->establishment_id;

        // Only allow academic years for this establishment
        $request->validate([
            'name' => 'required|string|max:100',
            'academic_year_id' => [
                'required',
                'exists:academic_years,id',
                function ($attribute, $value, $fail) use ($establishmentId) {
                    $year = \App\Models\AcademicYear::find($value);
                    if (!$year || $year->establishment_id != $establishmentId) {
                        $fail('السنة الدراسية غير صالحة.');
                    }
                }
            ],
        ]);

        \App\Models\Level::create([
            'name' => $request->name,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('admin.levels.dashboard')->with('success', 'تم إضافة المستوى بنجاح');
    }

    public function update(Request $request, \App\Models\Level $level)
    {
        $user = Auth::user();
        $establishmentId = $user->establishment_id;

        $request->validate([
            'name' => 'required|string|max:100',
            'academic_year_id' => [
                'required',
                'exists:academic_years,id',
                function ($attribute, $value, $fail) use ($establishmentId) {
                    $year = \App\Models\AcademicYear::find($value);
                    if (!$year || $year->establishment_id != $establishmentId) {
                        $fail('السنة الدراسية غير صالحة.');
                    }
                }
            ],
        ]);

        $level->update([
            'name' => $request->name,
            'academic_year_id' => $request->academic_year_id,
        ]);

        return redirect()->route('admin.levels.dashboard')->with('success', 'تم تحديث المستوى بنجاح');
    }

    public function show(Level $level)
    {
        return response()->json($level->load('academicYear'));
    }

    public function destroy(\App\Models\Level $level)
    {
        $level->delete();
        return redirect()->route('admin.levels.dashboard')->with('success', 'تم حذف المستوى بنجاح');
    }
}
