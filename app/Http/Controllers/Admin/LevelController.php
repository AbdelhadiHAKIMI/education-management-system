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
        // Fetch academic years for the user's establishment
        $academicYears = \App\Models\AcademicYear::where('establishment_id', $establishmentId)
            ->orderByDesc('end_date')
            ->get();
        $levels = Level::orderByDesc('id')->get();

        return view('admin.levels.dashboard', compact('levels', 'academicYears'));
    }

    public function store(Request $request)
    {
        // Remove academic_year_id validation
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        \App\Models\Level::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.levels.dashboard')->with('success', 'تم إضافة المستوى بنجاح');
    }

    public function update(Request $request, \App\Models\Level $level)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $level->update([
            'name' => $request->name,
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
