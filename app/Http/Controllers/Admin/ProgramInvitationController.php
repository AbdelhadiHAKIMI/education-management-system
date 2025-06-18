<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgramInvitation;
use App\Models\Student;
use App\Models\Level;
use League\Csv\Writer;
use SplTempFileObject;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class ProgramInvitationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $establishmentId = $user ? $user->establishment_id : null;
        $activeAcademicYear = null;
        if ($establishmentId) {
            $activeAcademicYear = \App\Models\AcademicYear::where('establishment_id', $establishmentId)
                ->where('status', true)
                ->first();
        }

        $levelId = $request->input('level_id');
        $query = \App\Models\ProgramInvitation::with(['student', 'program']);

        if ($activeAcademicYear) {
            $query->whereHas('student', function ($q) use ($activeAcademicYear) {
                $q->where('academic_year_id', $activeAcademicYear->id);
            });
        }

        if ($levelId) {
            $query->whereHas('student', function ($q) use ($levelId) {
                $q->where('level_id', $levelId);
            });
        }

        $programInvitations = $query->get();
        $levels = \App\Models\Level::all();

        return view('admin.program_invitations.index', compact('programInvitations', 'levels', 'levelId'));
    }

    public function create()
    {
        return view('admin.program_invitations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'program_id' => 'required|exists:programs,id',
            'status' => 'required|string',
            'is_exempt' => 'required|boolean',
            'invited_at' => 'required|date',
            'responded_at' => 'nullable|date',
        ]);

        ProgramInvitation::create($request->all());

        return redirect()->route('admin.program_invitations.index')
            ->with('success', 'Program invitation created successfully.');
    }

    public function show(ProgramInvitation $programInvitation)
    {
        return view('admin.program_invitations.show', compact('programInvitation'));
    }

    public function edit(ProgramInvitation $programInvitation)
    {
        return view('admin.program_invitations.edit', compact('programInvitation'));
    }

    public function update(Request $request, ProgramInvitation $programInvitation)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'program_id' => 'required|exists:programs,id',
            'status' => 'required|string',
            'is_exempt' => 'required|boolean',
            'invited_at' => 'required|date',
            'responded_at' => 'nullable|date',
        ]);

        $programInvitation->update($request->all());

        return redirect()->route('admin.program_invitations.index')
            ->with('success', 'Program invitation updated successfully.');
    }

    public function destroy(ProgramInvitation $programInvitation)
    {
        $programInvitation->delete();

        return redirect()->route('admin.program_invitations.index')
            ->with('success', 'Program invitation deleted successfully.');
    }

    public function downloadStudents(Request $request)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id'
        ]);
        $levelId = $request->input('level_id');
        $students = Student::where('level_id', $levelId)->get();

        $headers = [
            'student_name',
            'birth_date',
            'origin_school',
            'health_conditions',
            'parent_phone',
            'student_phone',
            'quran_level',
            'branch_id',
            'initial_classroom'
        ];

        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->setDelimiter(';');
        $csv->setOutputBOM(Writer::BOM_UTF8);
        $csv->insertOne($headers);

        foreach ($students as $student) {
            $csv->insertOne([
                $student->full_name,
                $student->birth_date,
                $student->origin_school,
                $student->health_conditions,
                $student->parent_phone,
                $student->student_phone,
                $student->quran_level,
                $student->branch_id,
                $student->initial_classroom,
            ]);
        }

        $level = Level::find($levelId);
        $filename = 'students_level_' . ($level ? $level->name : $levelId) . '.csv';

        return response($csv->getContent())
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function examResultsPrototype()
    {
        $levels = Level::all(['id', 'name']);
        $branches = Branch::all(['id', 'name']);
        $students = Student::orderBy('full_name')->get(['id', 'full_name']);

        $headers = [
            'student_name',
            'level',
            'branch',
            'overall_score',
            'success_status'
        ];

        $statusOptions = ['passed', 'failed'];
        $levelNames = $levels->pluck('name')->toArray();
        $branchNames = $branches->pluck('name')->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        foreach ($headers as $col => $header) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($columnLetter . '1', $header);
        }

        // Fill student rows
        $rowNum = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $rowNum, $student->full_name);
            // Level and branch dropdowns
            $sheet->setCellValue('B' . $rowNum, '');
            $sheet->setCellValue('C' . $rowNum, '');
            // Score and status
            $sheet->setCellValue('D' . $rowNum, '');
            $sheet->setCellValue('E' . $rowNum, $statusOptions[0]);

            // Level dropdown
            $validationLevel = $sheet->getCell('B' . $rowNum)->getDataValidation();
            $validationLevel->setType(DataValidation::TYPE_LIST);
            $validationLevel->setErrorStyle(DataValidation::STYLE_STOP);
            $validationLevel->setAllowBlank(true);
            $validationLevel->setShowInputMessage(true);
            $validationLevel->setShowErrorMessage(true);
            $validationLevel->setShowDropDown(true);
            $validationLevel->setFormula1('"' . implode(',', $levelNames) . '"');

            // Branch dropdown
            $validationBranch = $sheet->getCell('C' . $rowNum)->getDataValidation();
            $validationBranch->setType(DataValidation::TYPE_LIST);
            $validationBranch->setErrorStyle(DataValidation::STYLE_STOP);
            $validationBranch->setAllowBlank(true);
            $validationBranch->setShowInputMessage(true);
            $validationBranch->setShowErrorMessage(true);
            $validationBranch->setShowDropDown(true);
            $validationBranch->setFormula1('"' . implode(',', $branchNames) . '"');

            // Status dropdown
            $validationStatus = $sheet->getCell('E' . $rowNum)->getDataValidation();
            $validationStatus->setType(DataValidation::TYPE_LIST);
            $validationStatus->setErrorStyle(DataValidation::STYLE_STOP);
            $validationStatus->setAllowBlank(true);
            $validationStatus->setShowInputMessage(true);
            $validationStatus->setShowErrorMessage(true);
            $validationStatus->setShowDropDown(true);
            $validationStatus->setFormula1('"' . implode(',', $statusOptions) . '"');

            $rowNum++;
        }

        $filename = 'exam_results_prototype.xlsx';
        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return response($excelOutput)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
