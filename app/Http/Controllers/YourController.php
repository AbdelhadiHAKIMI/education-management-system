<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class YourController extends Controller
{
    // ...existing methods...

    public function yourMethodName()
    {
        // Fetch the active academic year ID (example logic, adjust as needed)
        $activeAcademicYearId = AcademicYear::where('is_active', true)->value('id');

        return view('your-view-name', [
            'activeAcademicYearId' => $activeAcademicYearId,
            // ...existing data...
        ]);
    }

    // ...existing methods...
}
