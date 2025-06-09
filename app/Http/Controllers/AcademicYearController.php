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

    // ...existing code...
}
