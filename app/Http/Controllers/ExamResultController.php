<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Level;
use App\Models\Branch;
use App\Models\ExamSession;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExamResultController extends Controller
{
    public function prototypeForm(Request $request)
    {
        $levels = Level::all(['id', 'name']);
        $branches = Branch::all(['id', 'name']);
        $students = Student::orderBy('full_name')->get(['id', 'full_name', 'branch_id', 'initial_classroom']);
        $currentSession = ExamSession::where('is_current', true)->first();
        $currentSemester = $currentSession ? $currentSession->semester : null;
        return view('exam_results.prototype', compact('levels', 'branches', 'students', 'currentSemester'));
    }

    public function prototypeDownload(Request $request)
    {
        $query = Student::query();

        if ($request->filled('level_id')) {
            $query->where('level_id', $request->input('level_id'));
        }
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        if ($request->filled('initial_classroom')) {
            $query->where('initial_classroom', $request->input('initial_classroom'));
        }
        if ($request->filled('student_ids')) {
            $query->whereIn('id', $request->input('student_ids'));
        }

        $students = $query->orderBy('full_name')->get();

        $levels = Level::all(['id', 'name']);
        $branches = Branch::all(['id', 'name']);
        $levelNames = $levels->pluck('name', 'id');
        $branchNames = $branches->pluck('name', 'id');
        $statusOptions = ['passed', 'failed'];

        $headers = [
            'student_name',
            'level',
            'branch',
            'overall_score',
            'success_status'
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($headers as $col => $header) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($columnLetter . '1', $header);
        }

        $rowNum = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A' . $rowNum, $student->full_name);
            // Fill level and branch automatically
            $sheet->setCellValue('B' . $rowNum, $levelNames[$student->level_id] ?? '');
            $sheet->setCellValue('C' . $rowNum, $branchNames[$student->branch_id] ?? '');
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
            $validationLevel->setFormula1('"' . implode(',', $levelNames->values()->toArray()) . '"');

            // Branch dropdown
            $validationBranch = $sheet->getCell('C' . $rowNum)->getDataValidation();
            $validationBranch->setType(DataValidation::TYPE_LIST);
            $validationBranch->setErrorStyle(DataValidation::STYLE_STOP);
            $validationBranch->setAllowBlank(true);
            $validationBranch->setShowInputMessage(true);
            $validationBranch->setShowErrorMessage(true);
            $validationBranch->setShowDropDown(true);
            $validationBranch->setFormula1('"' . implode(',', $branchNames->values()->toArray()) . '"');

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

        // Build filename based on filters
        $filenameParts = ['exam_results_prototype'];
        if ($request->filled('level_id')) {
            $level = $levels->find($request->input('level_id'));
            if ($level) $filenameParts[] = 'level_' . str_replace(' ', '_', $level->name);
        }
        if ($request->filled('branch_id')) {
            $branch = $branches->find($request->input('branch_id'));
            if ($branch) $filenameParts[] = 'branch_' . str_replace(' ', '_', $branch->name);
        }
        if ($request->filled('initial_classroom')) {
            $filenameParts[] = 'class_' . str_replace(' ', '_', $request->input('initial_classroom'));
        }
        if ($request->filled('student_ids')) {
            $filenameParts[] = 'selected';
        }
        $filename = implode('_', $filenameParts) . '.xlsx';

        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return response($excelOutput)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function importResults(Request $request)
    {
        $request->validate([
            'results_file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('results_file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $headers = array_map('trim', $rows[1]);
        $studentNameIndex = array_search('student_name', $headers);
        $levelIndex = array_search('level', $headers);
        $branchIndex = array_search('branch', $headers);
        $scoreIndex = array_search('overall_score', $headers);
        $statusIndex = array_search('success_status', $headers);

        $studentsByName = Student::pluck('id', 'full_name');
        $branchesByName = Branch::pluck('id', 'name');
        $currentSession = ExamSession::where('is_current', true)->first();

        $imported = 0;
        $skipped = [];

        for ($i = 2; $i <= count($rows); $i++) {
            $row = $rows[$i];
            $studentName = trim($row[$studentNameIndex] ?? '');
            $branchName = trim($row[$branchIndex] ?? '');
            if (!$studentName || !isset($studentsByName[$studentName])) {
                $skipped[] = "سطر $i: اسم الطالب غير موجود أو غير صحيح";
                continue;
            }
            $studentId = $studentsByName[$studentName];
            $branchId = $branchesByName[$branchName] ?? null;
            if (!$branchId) {
                $skipped[] = "سطر $i: اسم الشعبة غير صحيح";
                continue;
            }
            try {
                \App\Models\ExamResult::create([
                    'student_id' => $studentId,
                    'exam_session_id' => $currentSession ? $currentSession->id : null,
                    'branch_id' => $branchId,
                    'overall_score' => $row[$scoreIndex] ?? 0,
                    'success_status' => $row[$statusIndex] ?? 'failed',
                ]);
                $imported++;
            } catch (\Exception $e) {
                $skipped[] = "سطر $i: خطأ في الحفظ";
            }
        }

        $msg = "تم استيراد $imported نتيجة بنجاح.";
        if ($skipped) {
            $msg .= "<br>لم يتم استيراد بعض الصفوف:<br>" . implode('<br>', $skipped);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function resetSelection(Request $request)
    {
        return redirect()->route('exam_results.prototype.form');
    }
}
