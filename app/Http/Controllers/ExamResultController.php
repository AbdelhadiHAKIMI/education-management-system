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
use Illuminate\Support\Facades\Auth;

class ExamResultController extends Controller
{
    public function prototypeForm(Request $request)
    {
        $levels = Level::all(['id', 'name']);
        $branches = Branch::all(['id', 'name']);
        $students = Student::orderBy('full_name')->get(['id', 'full_name', 'branch_id', 'initial_classroom']);
        $currentSession = ExamSession::where('is_current', true)->first();
        $currentSemester = $currentSession ? $currentSession->semester : null;

        // Add: Get active academic year and exam session id
        $activeAcademicYear = \App\Models\AcademicYear::where('status', true)->first();
        $activeAcademicYearId = $activeAcademicYear ? $activeAcademicYear->id : null;
        $currentExamSessionId = $currentSession ? $currentSession->id : null;

        return view('exam_results.prototype', compact(
            'levels',
            'branches',
            'students',
            'currentSemester',
            'activeAcademicYearId',
            'currentExamSessionId'
        ));
    }

    // Add this helper to map branch/stream to subjects and coefficients
    private function getStreamSubjectsAndCoefficients($branchName)
    {
        $map = [
            'علوم تجريبية' => [
                ['subject' => 'ع.الطبيعة والحياة', 'coefficient' => 6],
                ['subject' => 'علوم فيزيائية', 'coefficient' => 5],
                ['subject' => 'رياضيات', 'coefficient' => 5],
                ['subject' => 'ل.عربية وآدابها', 'coefficient' => 3],
                ['subject' => 'لغة فرنسية', 'coefficient' => 2],
                ['subject' => 'لغة إنجليزية', 'coefficient' => 2],
                ['subject' => 'فلسفة', 'coefficient' => 2],
                ['subject' => 'تاريخ وجغرافيا', 'coefficient' => 2],
                ['subject' => 'علوم إسلامية', 'coefficient' => 2],
                ['subject' => 'تربية بدنية', 'coefficient' => 1],
            ],
            'رياضيات' => [
                ['subject' => 'رياضيات', 'coefficient' => 7],
                ['subject' => 'علوم فيزيائية', 'coefficient' => 6],
                ['subject' => 'ل.عربية وآدابها', 'coefficient' => 3],
                ['subject' => 'ع.الطبيعة والحياة', 'coefficient' => 2],
                ['subject' => 'تاريخ وجغرافيا', 'coefficient' => 2],
                ['subject' => 'لغة فرنسية', 'coefficient' => 2],
                ['subject' => 'لغة إنجليزية', 'coefficient' => 2],
                ['subject' => 'فلسفة', 'coefficient' => 2],
                ['subject' => 'علوم إسلامية', 'coefficient' => 2],
                ['subject' => 'تربية بدنية', 'coefficient' => 1],
            ],
            'آداب وفلسفة' => [
                ['subject' => 'ل.عربية وآدابها', 'coefficient' => 6],
                ['subject' => 'فلسفة', 'coefficient' => 6],
                ['subject' => 'تاريخ وجغرافيا', 'coefficient' => 4],
                ['subject' => 'لغة فرنسية', 'coefficient' => 3],
                ['subject' => 'لغة إنجليزية', 'coefficient' => 3],
                ['subject' => 'رياضيات', 'coefficient' => 2],
                ['subject' => 'علوم إسلامية', 'coefficient' => 2],
                ['subject' => 'تربية بدنية', 'coefficient' => 1],
            ],
        ];
        return $map[$branchName] ?? [];
    }

    // Update prototypeDownload to generate columns for the selected stream
    public function prototypeDownload(Request $request)
    {
        // Establishment
        $user = Auth::user();
        $establishment = $user && $user->establishment_id ? \App\Models\Establishment::find($user->establishment_id) : null;
        $establishmentName = $establishment ? $establishment->name : 'غير محدد';

        // Academic year: use from request if set, else active
        $academicYearId = $request->input('academic_year_id');
        if ($academicYearId) {
            $academicYear = \App\Models\AcademicYear::find($academicYearId);
        } else {
            $academicYear = \App\Models\AcademicYear::where('status', true)->first();
        }
        $academicYearName = $academicYear ? $academicYear->name : 'غير محدد';

        // Exam session: use from request if set, else current
        $examSessionId = $request->input('exam_session_id');
        if ($examSessionId) {
            $examSession = \App\Models\ExamSession::find($examSessionId);
        } else {
            $examSession = $academicYear ? \App\Models\ExamSession::where('academic_year_id', $academicYear->id)->where('is_current', true)->first() : null;
        }
        $examSessionName = $examSession ? $examSession->name : 'غير محدد';

        // Only students from the selected/active academic year
        $query = Student::query();
        if ($academicYear) {
            $query->where('academic_year_id', $academicYear->id);
        } else {
            $students = collect();
        }
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
        $students = isset($students) ? $students : $query->orderBy('full_name')->get();

        // Branches to generate sheets for
        $branches = [
            'علوم تجريبية' => [
                'headers' => [
                    'student_id',
                    'student_name',
                    'ع.الطبيعة والحياة',
                    'علوم فيزيائية',
                    'رياضيات',
                    'ل.عربية وآدابها',
                    'لغة فرنسية',
                    'لغة إنجليزية',
                    'فلسفة',
                    'تاريخ وجغرافيا',
                    'علوم إسلامية',
                    'تربية بدنية',
                    'مجموع النقاط',
                    'مجموع المعاملات'
                ],
                'remark' => 'في علوم تجريبية: =F46+G45+H45+I43+J42+K42+L42+M42+N42+O41'
            ],
            'رياضيات' => [
                'headers' => [
                    'student_id',
                    'student_name',
                    'رياضيات',
                    'علوم فيزيائية',
                    'ل.عربية وآدابها',
                    'ع.الطبيعة والحياة',
                    'تاريخ وجغرافيا',
                    'لغة فرنسية',
                    'لغة إنجليزية',
                    'فلسفة',
                    'علوم إسلامية',
                    'تربية بدنية',
                    'مجموع النقاط',
                    'مجموع المعاملات'
                ],
                'remark' => 'في رياضيات: =F67+G66+H63+I62+J62+K62+L62+M62+N62+O61'
            ],
            'آداب وفلسفة' => [
                'headers' => [
                    'student_id',
                    'student_name',
                    'ل.عربية وآدابها',
                    'فلسفة',
                    'تاريخ وجغرافيا',
                    'لغة فرنسية',
                    'لغة إنجليزية',
                    'رياضيات',
                    'علوم إسلامية',
                    'تربية بدنية',
                    'مجموع النقاط',
                    'مجموع المعاملات'
                ],
                'remark' => 'في آداب وفلسفة: =F46+G46+H44+I43+J43+K42+L42+M41'
            ],
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        foreach ($branches as $branchName => $branchInfo) {
            $sheet = $spreadsheet->createSheet();
            $sheet->setTitle(mb_substr($branchName, 0, 31)); // Excel sheet name limit

            // --- Add header rows for establishment, academic year, exam session in Arabic ---
            $sheet->setCellValue('A1', 'المؤسسة:');
            $sheet->setCellValue('B1', $establishmentName);
            $sheet->setCellValue('A2', 'السنة الدراسية:');
            $sheet->setCellValue('B2', $academicYearName);
            $sheet->setCellValue('A3', 'جلسة الامتحان:');
            $sheet->setCellValue('B3', $examSessionName);

            // Write headers (start at row 5)
            foreach ($branchInfo['headers'] as $col => $header) {
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
                $sheet->setCellValue($columnLetter . '5', $header);
            }

            // Filter students for this branch
            $branchStudents = $students->filter(function ($student) use ($branchName) {
                return $student->branch && $student->branch->name === $branchName;
            })->values();

            $rowNum = 6; // Start after header rows
            foreach ($branchStudents as $student) {
                $colNum = 0;
                // Student ID
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(++$colNum);
                $sheet->setCellValue($columnLetter . $rowNum, $student->id);
                // Student Name
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(++$colNum);
                $sheet->setCellValue($columnLetter . $rowNum, $student->full_name);

                // Subject columns (empty)
                $subjectCount = count($branchInfo['headers']) - 4; // minus id, name, points, coeff
                for ($i = 2; $i < 2 + $subjectCount; $i++) {
                    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(++$colNum);
                    $sheet->setCellValue($columnLetter . $rowNum, '');
                }

                // مجموع النقاط (auto formula)
                $pointsCol = ++$colNum;
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($pointsCol);

                // Set the formula and total coefficients for each branch
                if ($branchName === 'رياضيات') {
                    // =C2*7+D2*6+E2*3+F2*2+G2*2+H2*2+I2*2+J2*2+K2*2+L2*1
                    $formula = "=C{$rowNum}*7+D{$rowNum}*6+E{$rowNum}*3+F{$rowNum}*2+G{$rowNum}*2+H{$rowNum}*2+I{$rowNum}*2+J{$rowNum}*2+K{$rowNum}*2+L{$rowNum}*1";
                    $totalCoeff = 29;
                } elseif ($branchName === 'علوم تجريبية') {
                    $formula = "=C{$rowNum}*6+D{$rowNum}*5+E{$rowNum}*5+F{$rowNum}*3+G{$rowNum}*2+H{$rowNum}*2+I{$rowNum}*2+J{$rowNum}*2+K{$rowNum}*2+L{$rowNum}*1";
                    $totalCoeff = 30;
                } elseif ($branchName === 'آداب وفلسفة') {
                    $formula = "=C{$rowNum}*6+D{$rowNum}*6+E{$rowNum}*4+F{$rowNum}*3+G{$rowNum}*3+H{$rowNum}*2+I{$rowNum}*2+J{$rowNum}*1";
                    $totalCoeff = 27;
                } else {
                    $formula = '';
                    $totalCoeff = '';
                }
                $sheet->setCellValue($columnLetter . $rowNum, $formula);

                // مجموع المعاملات (auto, constant value)
                $coeffCol = ++$colNum;
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($coeffCol);
                $sheet->setCellValue($columnLetter . $rowNum, $totalCoeff);

                $rowNum++;
            }

            // Add the remark at the bottom (row after last student)
            $remarkRow = $rowNum + 1;
            $sheet->setCellValue('A' . $remarkRow, $branchInfo['remark']);
        }

        // Remove the default sheet if empty
        if ($spreadsheet->getSheetCount() > 1) {
            $spreadsheet->removeSheetByIndex(0);
        }

        // Build filename with establishment, academic year, and exam session
        $filename = 'exam_results_prototype_' .
            preg_replace('/\s+/', '_', $establishmentName) . '_' .
            preg_replace('/\s+/', '_', $academicYearName) . '_' .
            preg_replace('/\s+/', '_', $examSessionName) . '.xlsx';

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return response($excelOutput)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    // Update importResults to parse subject grades and save to subject_grades table
    public function importResults(Request $request)
    {
        $request->validate([
            'results_file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('results_file');
        $spreadsheet = IOFactory::load($file->getRealPath());

        $imported = 0;
        $skipped = [];
        $currentSession = ExamSession::where('is_current', true)->first();

        $studentsById = Student::pluck('id', 'id');
        $studentsByName = Student::pluck('id', 'full_name');
        $branches = Branch::all(['id', 'name']);
        $branchesByName = [];
        foreach ($branches as $branch) {
            $branchesByName[trim($branch->name)] = $branch->id;
            $branchesByName[mb_strtolower(str_replace(' ', '', $branch->name))] = $branch->id;
        }

        foreach ($spreadsheet->getAllSheets() as $sheet) {
            $rows = $sheet->toArray(null, true, true, true);

            // Find header row (first row with 'student_id' or 'student_name')
            $headerRow = 1;
            $headers = array_map('trim', $rows[$headerRow]);
            if (!in_array('student_id', $headers) && !in_array('student_name', $headers)) {
                foreach ($rows as $i => $row) {
                    if (is_array($row) && (in_array('student_id', $row) || in_array('student_name', $row))) {
                        $headerRow = $i;
                        $headers = array_map('trim', $row);
                        break;
                    }
                }
            }

            // Map header names to column letters
            $headerMap = [];
            foreach ($headers as $col => $header) {
                if ($header) $headerMap[$header] = $col;
            }

            $studentIdCol = $headerMap['student_id'] ?? null;
            $studentNameCol = $headerMap['student_name'] ?? null;
            $sheetBranchName = trim($sheet->getTitle());
            $branchId = null;
            if ($sheetBranchName && isset($branchesByName[$sheetBranchName])) {
                $branchId = $branchesByName[$sheetBranchName];
            } else {
                $normalized = mb_strtolower(str_replace(' ', '', $sheetBranchName));
                if (isset($branchesByName[$normalized])) {
                    $branchId = $branchesByName[$normalized];
                }
            }
            if (!$branchId) {
                $skipped[] = "صفحة {$sheet->getTitle()}: اسم الشعبة غير صحيح";
                continue;
            }

            // Identify subject columns (skip id, name, مجموع النقاط, مجموع المعاملات, etc.)
            $subjectCols = [];
            $subjectNames = [];
            foreach ($headerMap as $header => $col) {
                if (!in_array($header, [
                    'student_id',
                    'student_name',
                    'مجموع النقاط',
                    'overall_score',
                    'مجموع المعاملات',
                    'success_status',
                    'الحالة'
                ])) {
                    $subjectCols[] = $col;
                    $subjectNames[$col] = $header;
                }
            }
            // Get subject coefficients from DB
            $subjects = \App\Models\Subject::where('branch_id', $branchId)->get()->keyBy('name');

            // مجموع النقاط ومجموع المعاملات columns
            $pointsCol = $headerMap['مجموع النقاط'] ?? $headerMap['overall_score'] ?? null;
            $coeffCol = $headerMap['مجموع المعاملات'] ?? null;

            // Start from the row after header
            for ($i = $headerRow + 1; $i <= count($rows); $i++) {
                $row = $rows[$i] ?? [];
                if (!$row) continue;

                // Robust student ID/name extraction
                $studentId = null;
                $studentName = null;
                if ($studentIdCol && isset($row[$studentIdCol]) && is_numeric($row[$studentIdCol])) {
                    $studentId = $row[$studentIdCol];
                }
                if ($studentNameCol && isset($row[$studentNameCol]) && trim($row[$studentNameCol]) !== '') {
                    $studentName = trim($row[$studentNameCol]);
                }

                // Try to resolve student ID if missing but name exists
                if (!$studentId && $studentName) {
                    $studentId = $studentsByName[$studentName] ?? null;
                }
                // Try to resolve student name if missing but ID exists
                if (!$studentName && $studentId) {
                    $studentName = Student::find($studentId)?->full_name;
                }

                // If both are missing, skip
                if (!$studentId && !$studentName) {
                    $skipped[] = "صفحة {$sheet->getTitle()}، سطر $i: بيانات الطالب ناقصة";
                    continue;
                }

                // Now, try to get studentDbId
                if ($studentId && isset($studentsById[$studentId])) {
                    $studentDbId = $studentId;
                } elseif ($studentName && isset($studentsByName[$studentName])) {
                    $studentDbId = $studentsByName[$studentName];
                } else {
                    $skipped[] = "صفحة {$sheet->getTitle()}، سطر $i: الطالب غير موجود";
                    continue;
                }

                // Save subject grades for this student
                $totalScore = 0;
                $totalCoeff = 0;
                foreach ($subjectCols as $col) {
                    $subjectName = $subjectNames[$col];
                    $grade = isset($row[$col]) && is_numeric($row[$col]) ? floatval($row[$col]) : null;
                    $subjectObj = $subjects[$subjectName] ?? null;
                    $coefficient = $subjectObj ? $subjectObj->coefficient : 1;
                    $subjectId = $subjectObj ? $subjectObj->id : null;

                    // Only insert if both studentDbId and subjectId are present and student exists
                    if ($grade !== null && $subjectId && $studentDbId && isset($studentsById[$studentDbId])) {
                        \App\Models\SubjectGrade::updateOrCreate(
                            [
                                'student_id' => $studentDbId,
                                'subject_id' => $subjectId,
                            ],
                            [
                                'grade' => $grade,
                                'coefficient' => $coefficient,
                            ]
                        );
                        $totalScore += $grade * $coefficient;
                        $totalCoeff += $coefficient;
                    }
                }

                // مجموع النقاط ومجموع المعاملات (if present in file, use them, else calculate)
                $sumPoints = $pointsCol && isset($row[$pointsCol]) && is_numeric($row[$pointsCol]) ? floatval($row[$pointsCol]) : $totalScore;
                $sumCoeff = $coeffCol && isset($row[$coeffCol]) && is_numeric($row[$coeffCol]) ? floatval($row[$coeffCol]) : $totalCoeff;

                // Calculate overall_score
                $overallScore = ($sumCoeff > 0) ? round($sumPoints / $sumCoeff, 2) : 0;
                $successStatus = $overallScore >= 10 ? 'passed' : 'failed';

                try {
                    \App\Models\ExamResult::updateOrCreate(
                        [
                            'student_id' => $studentDbId,
                            'exam_session_id' => $currentSession ? $currentSession->id : null,
                            'branch_id' => $branchId,
                        ],
                        [
                            'overall_score' => $overallScore,
                            'success_status' => $successStatus,
                        ]
                    );
                    $imported++;
                } catch (\Exception $e) {
                    $skipped[] = "صفحة {$sheet->getTitle()}، سطر $i: خطأ في الحفظ";
                }
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

    // Add these methods for subject/session selection and subject result upload

    public function selectSessionSubject(Request $request)
    {
        // Step 1: Select Academic Year and Exam Session
        $academicYears = \App\Models\AcademicYear::orderByDesc('end_date')->get();
        $sessions = [];
        $subjects = [];
        $selectedYear = $request->input('academic_year_id');
        $selectedSession = $request->input('exam_session_id');
        $selectedSubject = $request->input('subject_id');

        if ($selectedYear) {
            $sessions = \App\Models\ExamSession::where('academic_year_id', $selectedYear)->get();
        }
        if ($selectedSession) {
            $subjects = \App\Models\Subject::where('exam_session_id', $selectedSession)->get();
        }

        return view('exam_results.select_session_subject', compact(
            'academicYears',
            'sessions',
            'subjects',
            'selectedYear',
            'selectedSession',
            'selectedSubject'
        ));
    }

    public function subjectResultsUploadForm(Request $request)
    {
        // Step 2: Show upload form for selected session/subject
        $sessionId = $request->input('exam_session_id');
        $subjectId = $request->input('subject_id');
        $session = \App\Models\ExamSession::findOrFail($sessionId);
        $subject = \App\Models\Subject::findOrFail($subjectId);

        // Get students enrolled in this academic year/session
        $students = \App\Models\Student::whereHas('academicYears', function ($q) use ($session) {
            $q->where('academic_year_id', $session->academic_year_id);
        })->get();

        return view('exam_results.upload_subject_results', compact('session', 'subject', 'students'));
    }

    public function uploadSubjectResults(Request $request)
    {
        // Step 3: Handle upload and calculation
        $request->validate([
            'exam_session_id' => 'required|exists:exam_sessions,id',
            'subject_id' => 'required|exists:subjects,id',
            'results_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $session = \App\Models\ExamSession::findOrFail($request->exam_session_id);
        $subject = \App\Models\Subject::findOrFail($request->subject_id);

        $file = $request->file('results_file');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // Assume headers: student_id, score
        $headers = array_map('trim', $rows[1]);
        $studentIdIndex = array_search('student_id', $headers);
        $scoreIndex = array_search('score', $headers);

        // Get coefficient for this subject
        $coefficient = $subject->coefficient;

        $imported = 0;
        $skipped = [];

        // For overall_score calculation
        $studentScores = [];
        $studentCoeffs = [];

        for ($i = 2; $i <= count($rows); $i++) {
            $row = $rows[$i];
            $studentId = $row[$studentIdIndex] ?? null;
            $score = $row[$scoreIndex] ?? null;
            if (!$studentId || !is_numeric($score)) {
                $skipped[] = "سطر $i: بيانات ناقصة";
                continue;
            }

            try {
                // Save subject grade
                $subjectGrade = \App\Models\SubjectGrade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'exam_result_id' => null, // Will be linked after ExamResult is created/updated
                        'subject' => $subject->name,
                    ],
                    [
                        'grade' => $score,
                        'coefficient' => $coefficient,
                    ]
                );

                // Accumulate for overall_score calculation
                if (!isset($studentScores[$studentId])) {
                    $studentScores[$studentId] = 0;
                    $studentCoeffs[$studentId] = 0;
                }
                $studentScores[$studentId] += $score * $coefficient;
                $studentCoeffs[$studentId] += $coefficient;

                $imported++;
            } catch (\Exception $e) {
                $skipped[] = "سطر $i: خطأ في الحفظ";
            }
        }

        // After all subject grades, update ExamResult and link subject grades
        foreach ($studentScores as $studentId => $totalScore) {
            $totalCoeff = $studentCoeffs[$studentId] ?: 1;
            $overallScore = $totalScore / $totalCoeff;

            // Find or create ExamResult for this student/session/subject
            $examResult = \App\Models\ExamResult::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'exam_session_id' => $session->id,
                    'branch_id' => $subject->branch_id ?? null,
                ],
                [
                    'overall_score' => $overallScore,
                    'success_status' => $overallScore >= 10 ? 'passed' : 'failed',
                ]
            );

            // Update subject grades to link to this ExamResult
            \App\Models\SubjectGrade::where('student_id', $studentId)
                ->where('subject', $subject->name)
                ->whereNull('exam_result_id')
                ->update(['exam_result_id' => $examResult->id]);
        }

        $msg = "تم استيراد $imported نتيجة بنجاح.";
        if ($skipped) {
            $msg .= "<br>لم يتم استيراد بعض الصفوف:<br>" . implode('<br>', $skipped);
        }

        return redirect()->back()->with('success', $msg);
    }

    public function dashboard(Request $request)
    {
        // Streams
        $streams = [
            'علوم تجريبية' => 'Experimental Sciences',
            'رياضيات' => 'Mathematics',
            'آداب وفلسفة' => 'Literature & Philosophy',
        ];

        // 1. Comprehensive Numbers
        $totalParticipants = \App\Models\ExamResult::count();
        $passedCount = \App\Models\ExamResult::where('success_status', 'passed')->count();
        $failedCount = \App\Models\ExamResult::where('success_status', 'failed')->count();
        $overallAverage = \App\Models\ExamResult::avg('overall_score');

        // 2. Grade Distributions by stream
        $gradeRanges = [
            '0-6' => [0, 6],
            '7-8' => [7, 8],
            '9-10' => [9, 10],
            '11-12' => [11, 12],
            '13-14' => [13, 14],
            '15-16' => [15, 16],
            '17-18' => [17, 18],
            '19-20' => [19, 20],
        ];
        $gradeDistributions = [];
        foreach ($streams as $ar => $en) {
            $branch = \App\Models\Branch::where('name', $ar)->first();
            if (!$branch) continue;
            $results = \App\Models\ExamResult::where('branch_id', $branch->id)->pluck('overall_score');
            foreach ($gradeRanges as $label => [$min, $max]) {
                $gradeDistributions[$ar][$label] = $results->filter(function ($score) use ($min, $max) {
                    return $score >= $min && $score <= $max;
                })->count();
            }
        }

        // 3. Categories by Stream
        $streamStats = [];
        foreach ($streams as $ar => $en) {
            $branch = \App\Models\Branch::where('name', $ar)->first();
            if (!$branch) continue;
            $results = \App\Models\ExamResult::where('branch_id', $branch->id);
            $streamStats[$ar] = [
                'participants' => $results->count(),
                'passed' => $results->where('success_status', 'passed')->count(),
                'failed' => $results->where('success_status', 'failed')->count(),
                'average' => $results->avg('overall_score'),
            ];
            // Subject averages
            $subjectAverages = \App\Models\Subject::where('branch_id', $branch->id)
                ->get()
                ->mapWithKeys(function ($subject) use ($branch) {
                    $avg = \App\Models\SubjectGrade::where('subject_id', $subject->id)->avg('grade');
                    return [$subject->name => $avg];
                });
            $streamStats[$ar]['subject_averages'] = $subjectAverages;
        }

        // 4. Highest Scores per subject per stream
        $highestScores = [];
        foreach ($streams as $ar => $en) {
            $branch = \App\Models\Branch::where('name', $ar)->first();
            if (!$branch) continue;
            $subjects = \App\Models\Subject::where('branch_id', $branch->id)->get();
            foreach ($subjects as $subject) {
                $topGrade = \App\Models\SubjectGrade::where('subject_id', $subject->id)
                    ->orderByDesc('grade')->first();
                if ($topGrade) {
                    $student = \App\Models\Student::find($topGrade->student_id);
                    $highestScores[$ar][$subject->name] = [
                        'student' => $student ? $student->full_name : '-',
                        'grade' => $topGrade->grade,
                    ];
                }
            }
        }

        // 5. Positive/Negative Impact (non-core subjects)
        $positiveImpact = [];
        $negativeImpact = [];
        foreach ($streams as $ar => $en) {
            $branch = \App\Models\Branch::where('name', $ar)->first();
            if (!$branch) continue;
            $coreSubjects = \App\Models\Subject::where('branch_id', $branch->id)->where('is_core_subject', true)->pluck('id')->toArray();
            $nonCoreSubjects = \App\Models\Subject::where('branch_id', $branch->id)->where('is_core_subject', false)->pluck('id')->toArray();

            // Positive: passed overall, failed core, but passed due to non-core
            $positiveImpact[$ar] = \App\Models\ExamResult::where('branch_id', $branch->id)
                ->where('success_status', 'passed')
                ->get()
                ->filter(function ($result) use ($coreSubjects, $nonCoreSubjects) {
                    $coreAvg = \App\Models\SubjectGrade::where('student_id', $result->student_id)
                        ->whereIn('subject_id', $coreSubjects)->avg('grade');
                    $nonCoreAvg = \App\Models\SubjectGrade::where('student_id', $result->student_id)
                        ->whereIn('subject_id', $nonCoreSubjects)->avg('grade');
                    return $coreAvg < 10 && $nonCoreAvg >= 10;
                })->count();

            // Negative: failed overall, passed core, but failed due to non-core
            $negativeImpact[$ar] = \App\Models\ExamResult::where('branch_id', $branch->id)
                ->where('success_status', 'failed')
                ->get()
                ->filter(function ($result) use ($coreSubjects, $nonCoreSubjects) {
                    $coreAvg = \App\Models\SubjectGrade::where('student_id', $result->student_id)
                        ->whereIn('subject_id', $coreSubjects)->avg('grade');
                    $nonCoreAvg = \App\Models\SubjectGrade::where('student_id', $result->student_id)
                        ->whereIn('subject_id', $nonCoreSubjects)->avg('grade');
                    return $coreAvg >= 10 && $nonCoreAvg < 10;
                })->count();
        }

        // 6. Paginated student list with subject grades and results
        $students = \App\Models\Student::with([
            'branch',
            'subjectGrades.subject',
            'examResults.examSession'
        ])->paginate(25);

        return view('exam_results.dashboard', compact(
            'totalParticipants',
            'passedCount',
            'failedCount',
            'overallAverage',
            'gradeDistributions',
            'streamStats',
            'highestScores',
            'positiveImpact',
            'negativeImpact',
            'students',
            'streams'
        ));
    }

    // Show prototype upload form filtered by establishment and academic year
    public function adminPrototypeForm($establishment_id, $academic_year_id)
    {
        $levels = \App\Models\Level::where('establishment_id', $establishment_id)
            ->where('academic_year_id', $academic_year_id)
            ->get(['id', 'name']);
        $branches = \App\Models\Branch::where('establishment_id', $establishment_id)->get(['id', 'name']);
        $students = \App\Models\Student::where('establishment_id', $establishment_id)
            ->where('academic_year_id', $academic_year_id)
            ->orderBy('full_name')->get(['id', 'full_name', 'branch_id', 'initial_classroom']);
        $currentSession = \App\Models\ExamSession::where('academic_year_id', $academic_year_id)
            ->where('is_current', true)->first();
        $currentSemester = $currentSession ? $currentSession->semester : null;

        // Add: Pass academic year and session id
        $activeAcademicYearId = $academic_year_id;
        $currentExamSessionId = $currentSession ? $currentSession->id : null;

        return view('exam_results.prototype', compact(
            'levels',
            'branches',
            'students',
            'currentSemester',
            'activeAcademicYearId',
            'currentExamSessionId'
        ));
    }

    // Show dashboard filtered by establishment, academic year, and session
    public function adminDashboard($establishment_id, $academic_year_id, $exam_session_id)
    {
        // Filter all queries by establishment_id, academic_year_id, and exam_session_id
        $streams = [
            'علوم تجريبية' => 'Experimental Sciences',
            'رياضيات' => 'Mathematics',
            'آداب وفلسفة' => 'Literature & Philosophy',
        ];

        $totalParticipants = \App\Models\ExamResult::whereHas('student', function ($q) use ($establishment_id, $academic_year_id) {
            $q->where('establishment_id', $establishment_id)
                ->where('academic_year_id', $academic_year_id);
        })
            ->where('exam_session_id', $exam_session_id)
            ->count();

        $passedCount = \App\Models\ExamResult::whereHas('student', function ($q) use ($establishment_id, $academic_year_id) {
            $q->where('establishment_id', $establishment_id)
                ->where('academic_year_id', $academic_year_id);
        })
            ->where('exam_session_id', $exam_session_id)
            ->where('success_status', 'passed')->count();

        $failedCount = \App\Models\ExamResult::whereHas('student', function ($q) use ($establishment_id, $academic_year_id) {
            $q->where('establishment_id', $establishment_id)
                ->where('academic_year_id', $academic_year_id);
        })
            ->where('exam_session_id', $exam_session_id)
            ->where('success_status', 'failed')->count();

        $overallAverage = \App\Models\ExamResult::whereHas('student', function ($q) use ($establishment_id, $academic_year_id) {
            $q->where('establishment_id', $establishment_id)
                ->where('academic_year_id', $academic_year_id);
        })
            ->where('exam_session_id', $exam_session_id)
            ->avg('overall_score');

        // 2. Grade Distributions by stream
        $gradeRanges = [
            '0-6' => [0, 6],
            '7-8' => [7, 8],
            '9-10' => [9, 10],
            '11-12' => [11, 12],
            '13-14' => [13, 14],
            '15-16' => [15, 16],
            '17-18' => [17, 18],
            '19-20' => [19, 20],
        ];
        $gradeDistributions = [];
        foreach ($streams as $ar => $en) {
            $branch = \App\Models\Branch::where('name', $ar)->first();
            if (!$branch) continue;
            $results = \App\Models\ExamResult::where('branch_id', $branch->id)->pluck('overall_score');
            foreach ($gradeRanges as $label => [$min, $max]) {
                $gradeDistributions[$ar][$label] = $results->filter(function ($score) use ($min, $max) {
                    return $score >= $min && $score <= $max;
                })->count();
            }
        }

        // 3. Categories by Stream
        $streamStats = [];
        foreach ($streams as $ar => $en) {
            $branch = \App\Models\Branch::where('name', $ar)->first();
            if (!$branch) continue;
            $results = \App\Models\ExamResult::where('branch_id', $branch->id);
            $streamStats[$ar] = [
                'participants' => $results->count(),
                'passed' => $results->where('success_status', 'passed')->count(),
                'failed' => $results->where('success_status', 'failed')->count(),
                'average' => $results->avg('overall_score'),
            ];
            // Subject averages
            $subjectAverages = \App\Models\Subject::where('branch_id', $branch->id)
                ->get()
                ->mapWithKeys(function ($subject) use ($branch) {
                    $avg = \App\Models\SubjectGrade::where('subject_id', $subject->id)->avg('grade');
                    return [$subject->name => $avg];
                });
            $streamStats[$ar]['subject_averages'] = $subjectAverages;
        }

        // 4. Highest Scores per subject per stream
        $highestScores = [];
        foreach ($streams as $ar => $en) {
            $branch = \App\Models\Branch::where('name', $ar)->first();
            if (!$branch) continue;
            $subjects = \App\Models\Subject::where('branch_id', $branch->id)->get();
            foreach ($subjects as $subject) {
                $topGrade = \App\Models\SubjectGrade::where('subject_id', $subject->id)
                    ->orderByDesc('grade')->first();
                if ($topGrade) {
                    $student = \App\Models\Student::find($topGrade->student_id);
                    $highestScores[$ar][$subject->name] = [
                        'student' => $student ? $student->full_name : '-',
                        'grade' => $topGrade->grade,
                    ];
                }
            }
        }

        // 5. Positive/Negative Impact (non-core subjects)
        $positiveImpact = [];
        $negativeImpact = [];
        foreach ($streams as $ar => $en) {
            $branch = \App\Models\Branch::where('name', $ar)->first();
            if (!$branch) continue;
            $coreSubjects = \App\Models\Subject::where('branch_id', $branch->id)->where('is_core_subject', true)->pluck('id')->toArray();
            $nonCoreSubjects = \App\Models\Subject::where('branch_id', $branch->id)->where('is_core_subject', false)->pluck('id')->toArray();

            // Positive: passed overall, failed core, but passed due to non-core
            $positiveImpact[$ar] = \App\Models\ExamResult::where('branch_id', $branch->id)
                ->where('success_status', 'passed')
                ->get()
                ->filter(function ($result) use ($coreSubjects, $nonCoreSubjects) {
                    $coreAvg = \App\Models\SubjectGrade::where('student_id', $result->student_id)
                        ->whereIn('subject_id', $coreSubjects)->avg('grade');
                    $nonCoreAvg = \App\Models\SubjectGrade::where('student_id', $result->student_id)
                        ->whereIn('subject_id', $nonCoreSubjects)->avg('grade');
                    return $coreAvg < 10 && $nonCoreAvg >= 10;
                })->count();

            // Negative: failed overall, passed core, but failed due to non-core
            $negativeImpact[$ar] = \App\Models\ExamResult::where('branch_id', $branch->id)
                ->where('success_status', 'failed')
                ->get()
                ->filter(function ($result) use ($coreSubjects, $nonCoreSubjects) {
                    $coreAvg = \App\Models\SubjectGrade::where('student_id', $result->student_id)
                        ->whereIn('subject_id', $coreSubjects)->avg('grade');
                    $nonCoreAvg = \App\Models\SubjectGrade::where('student_id', $result->student_id)
                        ->whereIn('subject_id', $nonCoreSubjects)->avg('grade');
                    return $coreAvg >= 10 && $nonCoreAvg < 10;
                })->count();
        }

        // 6. Paginated student list with subject grades and results
        $students = \App\Models\Student::with([
            'branch',
            'subjectGrades.subject',
            'examResults' => function ($q) use ($exam_session_id) {
                $q->where('exam_session_id', $exam_session_id);
            },
        ])
            ->where('establishment_id', $establishment_id)
            ->where('academic_year_id', $academic_year_id)
            ->paginate(25);

        return view('exam_results.dashboard', compact(
            'totalParticipants',
            'passedCount',
            'failedCount',
            'overallAverage',
            'gradeDistributions',
            'streamStats',
            'highestScores',
            'positiveImpact',
            'negativeImpact',
            'students',
            'streams'
        ));
    }

    // Set only one active exam session per establishment
    public function activateExamSession(\App\Models\ExamSession $exam_session)
    {
        // Deactivate all sessions for this establishment's academic year
        \App\Models\ExamSession::where('academic_year_id', $exam_session->academic_year_id)
            ->update(['is_current' => false]);
        // Activate the selected session
        $exam_session->is_current = true;
        $exam_session->save();

        return redirect()->back()->with('success', 'تم تعيين الجلسة كجلسة امتحان نشطة بنجاح.');
    }
}
