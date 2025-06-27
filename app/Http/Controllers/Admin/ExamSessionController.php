<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamSession;
use App\Models\AcademicYear;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExamSessionController extends Controller
{
    public function activate($id)
    {
        DB::beginTransaction();
        try {
            $session = ExamSession::findOrFail($id);

            // Deactivate all sessions for the same academic year
            $affected1 = ExamSession::where('academic_year_id', $session->academic_year_id)
                ->update(['is_current' => false]);
            Log::info("Deactivated sessions for academic_year_id {$session->academic_year_id}: $affected1 rows affected");

            // Activate the selected session (use update to avoid model cache issues)
            $affected2 = ExamSession::where('id', $session->id)->update(['is_current' => true]);
            Log::info("Activated session id {$session->id}: $affected2 rows affected");

            // Ensure the academic year status is updated correctly
            $affected3 = AcademicYear::where('id', $session->academic_year_id)
                ->update(['status' => true]);
            Log::info("Activated academic year id {$session->academic_year_id}: $affected3 rows affected");

            // Deactivate other academic years
            $affected4 = AcademicYear::where('id', '!=', $session->academic_year_id)
                ->update(['status' => false]);
            Log::info("Deactivated other academic years: $affected4 rows affected");

            DB::commit();
            return redirect()->back()->with('success', 'تم تفعيل جلسة الامتحان بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Exam session activation failed: " . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء تفعيل جلسة الامتحان.');
        }
    }
}
