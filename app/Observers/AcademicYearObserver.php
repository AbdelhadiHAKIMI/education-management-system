<?php

namespace App\Observers;

use App\Models\AcademicYear;

class AcademicYearObserver
{
    public function updating(AcademicYear $academicYear)
    {
        if ($academicYear->isDirty('status') && $academicYear->status === 'active') {
            AcademicYear::where('establishment_id', $academicYear->establishment_id)
                ->where('id', '!=', $academicYear->id)
                ->update(['status' => 'inactive']);
        }
    }
}
