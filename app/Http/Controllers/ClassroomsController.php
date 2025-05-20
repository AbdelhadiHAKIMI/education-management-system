<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Models\Branch;
use App\Models\ExamResult;
use App\Models\Establishment;
use App\Models\Program;

class ClassroomsController extends Controller
{
    public function generate(Request $request)
    {
        // Use the same filter logic as in index()
        $groupSize = $request->input('group_size', 15);
        $manual = $request->input('manual', false);
        $internshipType = $request->input('internship_type', 'preparatory');
        $classesPerBranch = $request->input('classes_per_branch', []);
        $orderByInitialClassroom = $request->boolean('order_by_initial_classroom', false);

        if ($groupSize < 1) $groupSize = 1;
        foreach ($classesPerBranch as $k => $v) {
            if ($v < 1) unset($classesPerBranch[$k]);
        }

        $studentIds = DB::table('program_invitations')
            ->where('status', 'accepted')
            ->pluck('student_id');

        $students = DB::table('students')
            ->whereIn('students.id', $studentIds)
            ->join('exam_results', 'students.id', '=', 'exam_results.student_id')
            ->select(
                'students.id',
                'students.full_name',
                'students.branch_id',
                'students.initial_classroom',
                'exam_results.overall_score'
            )
            ->get();

        $branches = \App\Models\Branch::all(['id', 'name'])->keyBy('id');

        $classrooms = [];

        if ($orderByInitialClassroom) {
            $groupedByInitial = $students->groupBy('initial_classroom');
            foreach ($groupedByInitial as $initClass => $studentsInInit) {
                $groupedByBranch = $studentsInInit->groupBy('branch_id');
                foreach ($groupedByBranch as $branchId => $studentsInBranch) {
                    $branchName = $branches[$branchId]->name ?? $branchId;
                    $studentsSorted = $studentsInBranch->sortByDesc('overall_score')->values();

                    $numClasses = isset($classesPerBranch[$branchId]) && intval($classesPerBranch[$branchId]) > 0
                        ? intval($classesPerBranch[$branchId])
                        : ceil($studentsSorted->count() / $groupSize);

                    $firstClassCount = ceil($studentsSorted->count() / $numClasses);
                    $firstClass = $studentsSorted->slice(0, $firstClassCount)->values();

                    $remaining = $studentsSorted->slice($firstClassCount)->values();
                    $otherClasses = array_fill(0, $numClasses - 1, []);
                    foreach ($remaining as $idx => $student) {
                        $otherClasses[$idx % max(1, $numClasses - 1)][] = $student;
                    }

                    $allClasses = array_merge([$firstClass], $otherClasses);
                    foreach ($allClasses as $i => $chunk) {
                        $orderedStudents = [];
                        foreach ($chunk as $order => $student) {
                            $studentObj = clone $student;
                            $studentObj->order_number = $order + 1;
                            $orderedStudents[] = $studentObj;
                        }
                        $classrooms[] = [
                            'branch' => $branchName,
                            'initial_classroom' => $initClass,
                            'classroom_number' => $branchName . ' - ' . $initClass . ' - ' . ($i + 1),
                            'students' => $orderedStudents
                        ];
                    }
                }
            }
        } else {
            $grouped = $students->groupBy('branch_id');
            foreach ($grouped as $branchId => $studentsInBranch) {
                $branchName = $branches[$branchId]->name ?? $branchId;
                $studentsSorted = $studentsInBranch->sortByDesc('overall_score')->values();

                $numClasses = isset($classesPerBranch[$branchId]) && intval($classesPerBranch[$branchId]) > 0
                    ? intval($classesPerBranch[$branchId])
                    : ceil($studentsSorted->count() / $groupSize);

                $firstClassCount = ceil($studentsSorted->count() / $numClasses);
                $firstClass = $studentsSorted->slice(0, $firstClassCount)->values();

                $remaining = $studentsSorted->slice($firstClassCount)->values();
                $otherClasses = array_fill(0, $numClasses - 1, []);
                foreach ($remaining as $idx => $student) {
                    $otherClasses[$idx % max(1, $numClasses - 1)][] = $student;
                }

                $allClasses = array_merge([$firstClass], $otherClasses);
                foreach ($allClasses as $i => $chunk) {
                    $orderedStudents = [];
                    foreach ($chunk as $order => $student) {
                        $studentObj = clone $student;
                        $studentObj->order_number = $order + 1;
                        $orderedStudents[] = $studentObj;
                    }
                    $classrooms[] = [
                        'branch' => $branchName,
                        'initial_classroom' => null,
                        'classroom_number' => $branchName . ' - ' . ($i + 1),
                        'students' => $orderedStudents
                    ];
                }
            }
        }

        // Get establishment, program, and logo
        $establishment = Establishment::first();
        $program = Program::first();
        $logoPath = public_path('logo.png'); // adjust if needed

        // Table style with borders
        $tableStyle = [
            'borderSize' => 12,
            'borderColor' => '000000',
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'cellMargin' => 80,
        ];
        $firstRowStyle = ['bgColor' => 'D9D9D9'];

        $phpWord = new PhpWord();
        $phpWord->addTableStyle('ClassTable', $tableStyle, $firstRowStyle);

        foreach ($classrooms as $classroom) {
            $section = $phpWord->addSection();

            // Header row: Establishment (right), Logo (center), Program (left)
            $headerTable = $section->addTable(['alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'width' => 100 * 50]);
            $headerTable->addRow();

            $headerTable->addCell(3000)->addText($establishment ? $establishment->name : '', ['bold' => true, 'rtl' => true], ['alignment' => 'right', 'rtl' => true]);

            $logoCell = $headerTable->addCell(3000, ['alignment' => 'center']);
            // Fix: Use addImage with correct path and options, and suppress error if file not found
            if (is_file($logoPath)) {
                try {
                    $logoCell->addImage($logoPath, [
                        'width' => 80,
                        'height' => 80,
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
                        'wrappingStyle' => 'inline'
                    ]);
                } catch (\Exception $e) {
                    // If image fails, just skip
                }
            } else {
                $logoCell->addText(''); // keep cell empty if no logo
            }

            $headerTable->addCell(3000)->addText($program ? $program->name : '', ['bold' => true, 'rtl' => true], ['alignment' => 'left', 'rtl' => true]);

            // Class title centered
            $section->addText(
                "القسم: {$classroom['classroom_number']}",
                ['bold' => true, 'size' => 16, 'rtl' => true],
                ['alignment' => 'center', 'spaceAfter' => 200, 'rtl' => true]
            );

            // Table with borders, centered, RTL for Arabic
            $table = $section->addTable('ClassTable');
            $table->addRow();
            $table->addCell(4000)->addText('الاسم', ['bold' => true, 'rtl' => true], ['alignment' => 'right', 'rtl' => true]);
            $table->addCell(2000)->addText('الترتيب', ['bold' => true, 'rtl' => true], ['alignment' => 'right', 'rtl' => true]);
            foreach ($classroom['students'] as $student) {
                $table->addRow();
                $table->addCell(4000)->addText($student->full_name, ['rtl' => true], ['alignment' => 'right', 'rtl' => true]);
                $table->addCell(2000)->addText($student->order_number, ['rtl' => true], ['alignment' => 'right', 'rtl' => true]);
            }
            $section->addTextBreak(2);
        }

        $fileName = 'classrooms.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function index(Request $request)
    {
        $groupSize = $request->input('group_size', 15);
        $numSections = $request->input('num_sections');
        $manual = $request->input('manual', false);
        $internshipType = $request->input('internship_type', 'preparatory');
        $classesPerBranch = $request->input('classes_per_branch', []);
        $orderByInitialClassroom = $request->boolean('order_by_initial_classroom', false);

        // Control system: Validate user choices
        if ($groupSize < 1) $groupSize = 1;
        if ($numSections !== null && $numSections < 1) $numSections = null;
        foreach ($classesPerBranch as $k => $v) {
            if ($v < 1) unset($classesPerBranch[$k]);
        }

        $studentIds = DB::table('program_invitations')
            ->where('status', 'accepted')
            ->pluck('student_id');

        $students = DB::table('students')
            ->whereIn('students.id', $studentIds)
            ->join('exam_results', 'students.id', '=', 'exam_results.student_id')
            ->select(
                'students.id',
                'students.full_name',
                'students.branch_id',
                'students.initial_classroom',
                'exam_results.overall_score'
            )
            ->get();

        $branches = \App\Models\Branch::all(['id', 'name'])->keyBy('id');

        $classrooms = [];

        if ($orderByInitialClassroom) {
            // Divide into initial_classroom sections, then by branch, then by average
            $groupedByInitial = $students->groupBy('initial_classroom');
            foreach ($groupedByInitial as $initClass => $studentsInInit) {
                $groupedByBranch = $studentsInInit->groupBy('branch_id');
                foreach ($groupedByBranch as $branchId => $studentsInBranch) {
                    $branchName = $branches[$branchId]->name ?? $branchId;
                    $studentsSorted = $studentsInBranch->sortByDesc('overall_score')->values();

                    $numClasses = isset($classesPerBranch[$branchId]) && intval($classesPerBranch[$branchId]) > 0
                        ? intval($classesPerBranch[$branchId])
                        : ceil($studentsSorted->count() / $groupSize);

                    // First class: highest averages
                    $firstClassCount = ceil($studentsSorted->count() / $numClasses);
                    $firstClass = $studentsSorted->slice(0, $firstClassCount)->values();

                    // Remaining students for balance
                    $remaining = $studentsSorted->slice($firstClassCount)->values();
                    $otherClasses = array_fill(0, $numClasses - 1, []);
                    foreach ($remaining as $idx => $student) {
                        $otherClasses[$idx % max(1, $numClasses - 1)][] = $student;
                    }

                    // Add classrooms with ordering numbers
                    $allClasses = array_merge([$firstClass], $otherClasses);
                    foreach ($allClasses as $i => $chunk) {
                        $orderedStudents = [];
                        foreach ($chunk as $order => $student) {
                            $studentObj = clone $student;
                            $studentObj->order_number = $order + 1;
                            $orderedStudents[] = $studentObj;
                        }
                        $classrooms[] = [
                            'branch' => $branchName,
                            'initial_classroom' => $initClass,
                            'classroom_number' => $branchName . ' - ' . $initClass . ' - ' . ($i + 1),
                            'students' => $orderedStudents
                        ];
                    }
                }
            }
        } else {
            // Only by branch, not by initial_classroom
            $grouped = $students->groupBy('branch_id');
            foreach ($grouped as $branchId => $studentsInBranch) {
                $branchName = $branches[$branchId]->name ?? $branchId;
                $studentsSorted = $studentsInBranch->sortByDesc('overall_score')->values();

                $numClasses = isset($classesPerBranch[$branchId]) && intval($classesPerBranch[$branchId]) > 0
                    ? intval($classesPerBranch[$branchId])
                    : ceil($studentsSorted->count() / $groupSize);

                $firstClassCount = ceil($studentsSorted->count() / $numClasses);
                $firstClass = $studentsSorted->slice(0, $firstClassCount)->values();

                $remaining = $studentsSorted->slice($firstClassCount)->values();
                $otherClasses = array_fill(0, $numClasses - 1, []);
                foreach ($remaining as $idx => $student) {
                    $otherClasses[$idx % max(1, $numClasses - 1)][] = $student;
                }

                $allClasses = array_merge([$firstClass], $otherClasses);
                foreach ($allClasses as $i => $chunk) {
                    $orderedStudents = [];
                    foreach ($chunk as $order => $student) {
                        $studentObj = clone $student;
                        $studentObj->order_number = $order + 1;
                        $orderedStudents[] = $studentObj;
                    }
                    $classrooms[] = [
                        'branch' => $branchName,
                        'initial_classroom' => null,
                        'classroom_number' => $branchName . ' - ' . ($i + 1),
                        'students' => $orderedStudents
                    ];
                }
            }
        }

        $recommendations = [
            'يمكنك اختيار تقسيم الأقسام حسب القسم الأولي أو فقط حسب الشعبة.',
            'القسم الأول يحصل على أعلى المعدلات، والباقي موزع بالتساوي.',
            'اسم القسم يتضمن اسم الشعبة والقسم الأولي إذا اخترت ذلك.',
            'يتم إعطاء رقم ترتيب لكل طالب في القسم.',
            'يفضل أن يكون عدد الطلاب في كل قسم صغيراً (مثلاً 10-15 طالباً).'
        ];

        return view('admin.students.classrooms', [
            'classrooms' => $classrooms,
            'recommendations' => $recommendations,
            'groupSize' => $groupSize,
            'numSections' => $numSections,
            'manual' => $manual,
            'internshipType' => $internshipType,
            'branches' => $branches,
            'classesPerBranch' => $classesPerBranch,
            'orderByInitialClassroom' => $orderByInitialClassroom,
        ]);
    }
}
