<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Student;
use App\Models\ProgramInvitation;
use Illuminate\Support\Facades\DB;

class ProgramInvitationImportController extends Controller
{
    /**
     * Import invitations for all students in a given program.
     * You can call this with a POST request and provide program_id and (optionally) student_ids[].
     */
    public function import(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $programId = $request->input('program_id');
        $studentIds = $request->input('student_ids');

        // If no student_ids provided, invite all students for the program's level and academic year
        if (empty($studentIds)) {
            $program = Program::findOrFail($programId);
            $studentIds = Student::where('level_id', $program->level_id)
                ->where('academic_year_id', $program->academic_year_id)
                ->pluck('id')
                ->toArray();
        }

        $now = now();
        $invitations = [];
        foreach ($studentIds as $studentId) {
            $invitations[] = [
                'student_id' => $studentId,
                'program_id' => $programId,
                'status' => 'invited',
                'is_exempt' => false,
                'invited_at' => $now,
                'responded_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Avoid duplicates: only insert if not already invited
        $existing = ProgramInvitation::where('program_id', $programId)
            ->whereIn('student_id', $studentIds)
            ->pluck('student_id')
            ->toArray();

        $toInsert = array_filter($invitations, function ($inv) use ($existing) {
            return !in_array($inv['student_id'], $existing);
        });

        if (!empty($toInsert)) {
            ProgramInvitation::insert($toInsert);
        }

        return response()->json([
            'inserted' => count($toInsert),
            'skipped_existing' => count($existing),
            'total_requested' => count($studentIds),
        ]);
    }
}
