<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Writer;
use SplTempFileObject;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Student;
use App\Models\Branch;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class CsvProcessorController extends Controller
{
    public function index()
    {
        $branches = Branch::all(['id', 'name']);
        return view('csv-processor', compact('branches'));
    }

    public function upload(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt,xlsx|max:2048']);

        $file = $request->file('csv_file');
        $extension = strtolower($file->getClientOriginalExtension());
        $records = [];

        $headerMap = [
            'الاسم الكامل' => 'full_name',
            'تاريخ الميلاد' => 'birth_date',
            'المدرسة الأصلية' => 'origin_school',
            'الحالة الصحية' => 'health_conditions',
            'رقم هاتف الولي' => 'parent_phone',
            'رقم هاتف الطالب' => 'student_phone',
            'مستوى حفظ القرآن' => 'quran_level',
            'مستوى حفظ القرآن (مستظهر أو خاتم فقط)' => 'quran_level',
            'الشعبة' => 'branch_id',
            'الشعبة (اكتب اسم الشعبة وليس رقمها)' => 'branch_id'
        ];

        $branchesList = Branch::all(['id', 'name'])->keyBy('name');

        if ($extension === 'xlsx') {
            // Convert XLSX to CSV in-memory
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $writer->setDelimiter(';');
            $writer->setEnclosure('"');
            $writer->setSheetIndex(0);
            $csvContent = '';
            ob_start();
            $writer->save('php://output');
            $csvContent = ob_get_clean();

            // Now parse as CSV
            $csv = Reader::createFromString($csvContent);
            $csv->setDelimiter(';');
            $csv->setHeaderOffset(0);

            foreach ($csv->getRecords() as $row) {
                $assoc = [];
                foreach ($headerMap as $arHeader => $dbField) {
                    if (isset($row[$arHeader])) {
                        $assoc[$dbField] = mb_trim((string)$row[$arHeader]);
                    }
                }
                if (!empty($assoc['full_name']) && array_filter($assoc)) {
                    $records[] = $assoc;
                }
            }
        } else {
            $content = file_get_contents($file->getRealPath());
            if (!mb_check_encoding($content, 'UTF-8')) {
                $content = mb_convert_encoding($content, 'UTF-8', 'auto');
            }

            $csv = Reader::createFromString($content);
            $csv->setDelimiter(';');
            $csv->setHeaderOffset(0);

            foreach ($csv->getRecords() as $row) {
                $assoc = [];
                foreach ($headerMap as $arHeader => $dbField) {
                    if (isset($row[$arHeader])) {
                        $assoc[$dbField] = mb_trim((string)$row[$arHeader]);
                    }
                }
                if (!empty($assoc['full_name']) && array_filter($assoc)) {
                    $records[] = $assoc;
                }
            }
        }

        $successfulInserts = 0;
        $skippedRows = [];

        foreach ($records as $index => $studentData) {
            if (!empty($studentData['birth_date'])) {
                try {
                    $date = Carbon::createFromFormat('Y-m-d', $studentData['birth_date']);
                    $studentData['birth_date'] = $date->format('Y-m-d');
                } catch (\Exception $e) {
                    try {
                        $date = Carbon::parse($studentData['birth_date']);
                        $studentData['birth_date'] = $date->format('Y-m-d');
                    } catch (\Exception $e) {
                        $skippedRows[] = "سطر رقم " . ($index + 2) . ": تاريخ الميلاد غير صالح";
                        continue;
                    }
                }
            }

            if (!empty($studentData['branch_id'])) {
                $branchName = $studentData['branch_id'];
                if (!$branchesList->has($branchName)) {
                    $skippedRows[] = "سطر رقم " . ($index + 2) . ": اسم الشعبة غير صحيح";
                    continue;
                }
                $studentData['branch_id'] = $branchesList[$branchName]->id;
            }

            if (empty($studentData['full_name']) || empty($studentData['birth_date']) || empty($studentData['branch_id'])) {
                $skippedRows[] = "سطر رقم " . ($index + 2) . ": بيانات ناقصة";
                continue;
            }

            try {
                Student::create($studentData);
                $successfulInserts++;
            } catch (\Exception $e) {
                $skippedRows[] = "سطر رقم " . ($index + 2) . ": خطأ في الحفظ";
            }
        }

        $message = 'تم رفع الملف بنجاح! عدد الطلاب المضافين: ' . $successfulInserts;
        if (count($skippedRows) > 0) {
            $message .= '<br><br>لم يتم إضافة بعض الطلاب للأسباب التالية:<br>' . implode('<br>', $skippedRows);
        }

        return redirect()->route('csv.show')
            ->with($successfulInserts > 0 ? 'success' : 'error', $message)
            ->with('csv_data', $records);
    }

    public function filter(Request $request)
    {
        $data = session('csv_data', []);
        $filterType = $request->input('filter_type');
        $filterValue = $request->input('filter_value');

        if ($filterType && $filterValue) {
            $filteredData = array_filter($data, function ($row) use ($filterType, $filterValue) {
                if ($filterType === 'name' && isset($row['full_name'])) {
                    return mb_stripos($row['full_name'], $filterValue, 0, 'UTF-8') !== false;
                } elseif ($filterType === 'branch' && isset($row['branch_id'])) {
                    return $row['branch_id'] == $filterValue;
                }
                return true;
            });

            session(['filtered_data' => $filteredData]);
        }

        return redirect()->route('csv.show');
    }

    public function generate(Request $request)
    {
        // Add your report generation logic here
        return back()->with('success', 'تم توليد التقرير بنجاح');
    }

    public function download()
    {
        $data = session('csv_data', []);
        $headers = [
            'الاسم الكامل',
            'تاريخ الميلاد',
            'المدرسة الأصلية',
            'الحالة الصحية',
            'رقم هاتف الولي',
            'رقم هاتف الطالب',
            'مستوى حفظ القرآن',
            'الشعبة'
        ];

        $filename = 'students_export_' . date('Y-m-d') . '.csv';
        $csv = Writer::createFromString();
        $csv->setDelimiter(';');
        $csv->setOutputBOM(Writer::BOM_UTF8);
        $csv->insertOne($headers);
        $csv->insertAll($data);

        return response($csv->getContent())
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function show(Request $request)
    {
        $data = session('filtered_data', session('csv_data', []));
        $headers = [
            'الاسم الكامل',
            'تاريخ الميلاد',
            'المدرسة الأصلية',
            'الحالة الصحية',
            'رقم هاتف الولي',
            'رقم هاتف الطالب',
            'مستوى حفظ القرآن',
            'الشعبة'
        ];

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $currentItems = array_slice($data, ($currentPage - 1) * $perPage, $perPage);

        $paginatedData = new LengthAwarePaginator(
            $currentItems,
            count($data),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('csv-processor', [
            'data' => $paginatedData,
            'headers' => $headers,
            'branches' => Branch::all(['id', 'name'])
        ]);
    }

    public function prototype()
    {
        $headers = [
            'الاسم الكامل',
            'تاريخ الميلاد',
            'المدرسة الأصلية',
            'الحالة الصحية',
            'رقم هاتف الولي',
            'رقم هاتف الطالب',
            'مستوى حفظ القرآن (مستظهر أو خاتم فقط)',
            'الشعبة (اكتب اسم الشعبة وليس رقمها)'
        ];

        $quranLevels = ['مستظهر', 'خاتم'];
        $branches = Branch::all(['id', 'name']);
        $branchList = $branches->pluck('name')->implode(' | ');

        $commentRow = [
            '---',
            'YYYY-MM-DD',
            '---',
            '---',
            '---',
            '---',
            'اختر من: ' . implode(' أو ', $quranLevels),
            'اختر من: ' . $branchList
        ];

        $filename = 'students_prototype.csv';
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->setDelimiter(';');
        $csv->setOutputBOM(Writer::BOM_UTF8);
        $csv->insertOne($headers);
        $csv->insertOne($commentRow);
        $csv->insertOne([
            'مثال: أحمد محمد',
            '2002-05-12',
            'مدرسة النجاح',
            'سليم',
            '0612345678',
            '0698765432',
            'مستظهر',
            $branches->first() ? $branches->first()->name : ''
        ]);

        return response($csv->getContent())
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function prototypeXlsx()
    {
        $headers = [
            'الاسم الكامل',
            'تاريخ الميلاد',
            'المدرسة الأصلية',
            'الحالة الصحية',
            'رقم هاتف الولي',
            'رقم هاتف الطالب',
            'مستوى حفظ القرآن',
            'الشعبة'
        ];

        $quranLevels = ['مستظهر', 'خاتم'];
        $branches = Branch::all(['id', 'name']);
        $branchNames = $branches->pluck('name')->toArray();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($headers as $col => $header) {
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($col + 1);
            $sheet->setCellValue($columnLetter . '1', $header);
        }

        $sheet->setCellValue('A2', 'مثال: أحمد محمد');
        $sheet->setCellValue('B2', '2002-05-12');
        $sheet->setCellValue('C2', 'مدرسة النجاح');
        $sheet->setCellValue('D2', 'سليم');
        $sheet->setCellValue('E2', '0612345678');
        $sheet->setCellValue('F2', '0698765432');
        $sheet->setCellValue('G2', $quranLevels[0]);
        $sheet->setCellValue('H2', $branches->first() ? $branches->first()->name : '');

        $validationQuran = $sheet->getCell('G2')->getDataValidation();
        $validationQuran->setType(DataValidation::TYPE_LIST);
        $validationQuran->setErrorStyle(DataValidation::STYLE_STOP);
        $validationQuran->setAllowBlank(true);
        $validationQuran->setShowInputMessage(true);
        $validationQuran->setShowErrorMessage(true);
        $validationQuran->setShowDropDown(true);
        $validationQuran->setFormula1('"' . implode(',', $quranLevels) . '"');

        $validationBranch = $sheet->getCell('H2')->getDataValidation();
        $validationBranch->setType(DataValidation::TYPE_LIST);
        $validationBranch->setErrorStyle(DataValidation::STYLE_STOP);
        $validationBranch->setAllowBlank(true);
        $validationBranch->setShowInputMessage(true);
        $validationBranch->setShowErrorMessage(true);
        $validationBranch->setShowDropDown(true);
        $validationBranch->setFormula1('"' . implode(',', $branchNames) . '"');

        $branchSheet = $spreadsheet->createSheet();
        $branchSheet->setTitle('الشعب');
        $branchSheet->setCellValue('A1', 'رقم الشعبة');
        $branchSheet->setCellValue('B1', 'اسم الشعبة');
        foreach ($branches as $i => $branch) {
            $branchSheet->setCellValue('A' . ($i + 2), $branch->id);
            $branchSheet->setCellValue('B' . ($i + 2), $branch->name);
        }

        $filename = 'students_prototype.xlsx';
        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return response($excelOutput)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}

if (!function_exists('mb_trim')) {
    function mb_trim($string)
    {
        return preg_replace('/^[\s\x{200E}\x{200F}]+|[\s\x{200E}\x{200F}]+$/u', '', $string);
    }
}
