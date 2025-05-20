<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Program;
use App\Models\Program_invitation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use App\Models\Level;
use League\Csv\Writer;
use SplTempFileObject;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ProgramInvitationImportController extends Controller
{
    public function showImportForm()
    {
        $programs = Program::all(['id', 'name']);
        $levels = Level::all(['id', 'name']);
        return view('admin.program_invitations.import', compact('programs', 'levels'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
            'program_id' => 'required|exists:programs,id',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        $headers = array_map('trim', $rows[1]);
        $studentNameIndex = array_search('student_name', $headers);
        $programIdIndex = array_search('program_id', $headers);
        $statusIndex = array_search('status', $headers);
        $isExemptIndex = array_search('is_exempt', $headers);
        $invitedAtIndex = array_search('invited_at', $headers);
        $respondedAtIndex = array_search('responded_at', $headers);

        $studentsByName = \App\Models\Student::pluck('id', 'full_name');

        $imported = 0;
        $skipped = [];

        for ($i = 2; $i <= count($rows); $i++) {
            $row = $rows[$i];
            $studentName = trim($row[$studentNameIndex] ?? '');
            if (!$studentName || !isset($studentsByName[$studentName])) {
                $skipped[] = "سطر $i: اسم الطالب غير موجود أو غير صحيح";
                continue;
            }
            $studentId = $studentsByName[$studentName];

            try {
                \App\Models\Program_invitation::create([
                    'student_id' => $studentId,
                    'program_id' => $request->input('program_id'),
                    'status' => $row[$statusIndex] ?? 'invited',
                    'is_exempt' => $row[$isExemptIndex] ?? 0,
                    'invited_at' => $row[$invitedAtIndex] ?? now(),
                    'responded_at' => $row[$respondedAtIndex] ?? null,
                ]);
                $imported++;
            } catch (\Exception $e) {
                $skipped[] = "سطر $i: خطأ في الحفظ";
            }
        }

        $msg = "تم استيراد $imported دعوة بنجاح.";
        if ($skipped) {
            $msg .= "<br>لم يتم استيراد بعض الصفوف:<br>" . implode('<br>', $skipped);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function prototype(Request $request)
    {
        $levelId = $request->query('level_id');
        $students = [];
        if ($levelId) {
            $students = \App\Models\Student::where('level_id', $levelId)->get();
        }

        $headers = [
            'student_name', // will be mapped to student_id on upload
            'program_id',
            'status',
            'is_exempt',
            'invited_at',
            'responded_at'
        ];

        $statusOptions = ['invited', 'accepted', 'rejected'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        foreach ($headers as $col => $header) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($columnLetter . '1', $header);
        }

        // Fill student rows
        $rowNum = 2;
        if ($students && count($students)) {
            foreach ($students as $student) {
                $sheet->setCellValue('A' . $rowNum, $student->full_name);
                $sheet->setCellValue('B' . $rowNum, ''); // program_id
                $sheet->setCellValue('C' . $rowNum, $statusOptions[0]); // status
                $sheet->setCellValue('D' . $rowNum, '0'); // is_exempt
                $sheet->setCellValue('E' . $rowNum, ''); // invited_at
                $sheet->setCellValue('F' . $rowNum, ''); // responded_at

                // Add dropdown for status
                $validation = $sheet->getCell('C' . $rowNum)->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $statusOptions) . '"');

                $rowNum++;
            }
        } else {
            // Example row if no students
            $sheet->setCellValue('A2', 'مثال: أحمد محمد');
            $sheet->setCellValue('B2', '1');
            $sheet->setCellValue('C2', $statusOptions[0]);
            $sheet->setCellValue('D2', '0');
            $sheet->setCellValue('E2', '2024-06-01 10:00:00');
            $sheet->setCellValue('F2', '');
            $validation = $sheet->getCell('C2')->getDataValidation();
            $validation->setType(DataValidation::TYPE_LIST);
            $validation->setErrorStyle(DataValidation::STYLE_STOP);
            $validation->setAllowBlank(true);
            $validation->setShowInputMessage(true);
            $validation->setShowErrorMessage(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('"' . implode(',', $statusOptions) . '"');
        }

        $level = $levelId ? \App\Models\Level::find($levelId) : null;
        $filename = 'program_invitations_prototype' . ($level ? '_' . $level->name : '') . '.xlsx';

        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return response($excelOutput)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
