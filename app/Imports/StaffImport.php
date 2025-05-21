<?php

namespace App\Imports;

use App\Models\Staff;
use App\Models\Branch;
use App\Models\AcademicYear;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StaffImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $branch = Branch::where('name', $row['branch'])->first();
        $academicYear = AcademicYear::where('name', $row['academic_year'])->first();

        return new Staff([
            'full_name' => $row['full_name'],
            'birth_date' => $row['birth_date'],
            'phone' => $row['phone'],
            'bac_year' => $row['bac_year'],
            'branch_id' => $branch->id ?? null,
            'quran_level' => $row['quran_level'],
            'univ_specialty' => $row['univ_specialty'],
            'academic_year_id' => $academicYear->id ?? null,
            'is_active' => strtolower($row['status']) == 'نشط',
        ]);
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string',
            'birth_date' => 'required|date',
            'branch' => 'required|exists:branches,name',
            'academic_year' => 'required|exists:academic_years,name',
            'status' => 'required|in:نشط,غير نشط',
        ];
    }
}