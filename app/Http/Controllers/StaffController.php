<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\AcademicYear;
use App\Models\Subject;
use App\Models\Student; // Import Student model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $establishmentId = Auth::user()->establishment_id;

        // FIX: Remove dependency on students.establishment_id
        $query = Staff::with(['branch', 'subjects'])
            ->where('establishment_id', $establishmentId)
            ->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        if ($request->has('branch') && $request->branch != '') {
            $query->where('branch_id', $request->branch);
        }

        $staffs = $query->paginate(25);

        // FIX: Remove dependency on students.establishment_id for count
        $studentCount = \App\Models\Student::count();
        $staffCount = \App\Models\Staff::where('establishment_id', $establishmentId)->count();

        $branches = Branch::all();

        return view('admin.staffs.index', compact('staffs', 'branches', 'studentCount', 'staffCount'));
    }

    public function create()
    {
        $establishmentId = Auth::user()->establishment_id;
        // FIX: Remove dependency on students.establishment_id for count
        $branches = Branch::all();
        $subjects = \App\Models\Subject::all();

        $staff = new \App\Models\Staff();
        $staff->setRelation('subjects', collect());

        if (!old('type')) {
            $staff->type = 'إداري';
        }

        // Get counts for sidebar navigation
        $studentCount = \App\Models\Student::count();
        $staffCount = \App\Models\Staff::where('establishment_id', $establishmentId)->count();

        return view('admin.staffs.create', compact('branches', 'staff', 'subjects', 'studentCount', 'staffCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'birth_date' => 'required|date|before_or_equal:' . Carbon::now()->subYears(15)->format('Y-m-d') . '|before_or_equal:today',
            'phone' => 'nullable|string|max:20',
            'bac_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'type' => 'required|in:إداري,مؤطر دراسي,خدمات',
            'univ_specialty' => 'nullable|string|max:50',
            'branch_id' => 'nullable|exists:branches,id',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        if ($validated['type'] === 'مؤطر دراسي') {
            $request->validate([
                'branch_id' => 'required|exists:branches,id',
                'subjects' => 'nullable|array',
                'subjects.*' => 'exists:subjects,id'
            ]);
        }

        $academicYearId = null;
        if ($validated['type'] === 'مؤطر دراسي' && isset($validated['branch_id'])) {
            $branch = Branch::with('level')->find($validated['branch_id']);
            if ($branch && $branch->level) {
                $academicYearId = $branch->level->academic_year_id;
            }
        } else {
            $currentAcademicYear = AcademicYear::where('establishment_id', Auth::user()->establishment_id)
                ->where('is_current', true)
                ->first();
            $academicYearId = $currentAcademicYear ? $currentAcademicYear->id : null;
        }

        $staff = Staff::create([
            'full_name' => $validated['full_name'],
            'birth_date' => $validated['birth_date'],
            'phone' => $validated['phone'],
            'bac_year' => $validated['bac_year'],
            'type' => $validated['type'],
            'branch_id' => ($validated['type'] === 'مؤطر دراسي' && isset($validated['branch_id'])) ? $validated['branch_id'] : null,
            'univ_specialty' => $validated['univ_specialty'],
            'academic_year_id' => $academicYearId,
            'establishment_id' => Auth::user()->establishment_id
        ]);

        if ($validated['type'] === 'مؤطر دراسي' && isset($validated['subjects'])) {
            $staff->subjects()->sync($validated['subjects']);
        } else {
            $staff->subjects()->detach();
        }

        return redirect()->route('admin.staffs.index')->with('success', 'تمت إضافة المؤطر بنجاح');
    }

    public function show(Staff $staff)
    {
        if ($staff->establishment_id != Auth::user()->establishment_id) {
            abort(403);
        }
        $staff->load('subjects');

        // Get counts for sidebar navigation
        $establishmentId = Auth::user()->establishment_id;
        $studentCount = Student::where('establishment_id', $establishmentId)->count();
        $staffCount = Staff::where('establishment_id', $establishmentId)->count();

        return view('admin.staffs.show', compact('staff', 'studentCount', 'staffCount'));
    }

    public function edit(\App\Models\Staff $staff)
    {
        if ($staff->establishment_id != Auth::user()->establishment_id) {
            abort(403);
        }

        $establishmentId = Auth::user()->establishment_id;
        // FIX: Remove dependency on levels.academic_year_id for branches
        $branches = Branch::all();
        $subjects = \App\Models\Subject::all();

        $staff->load('subjects');

        // Get counts for sidebar navigation
        $studentCount = \App\Models\Student::where('establishment_id', $establishmentId)->count();
        $staffCount = \App\Models\Staff::where('establishment_id', $establishmentId)->count();

        return view('admin.staffs.edit', compact('staff', 'branches', 'subjects', 'studentCount', 'staffCount'));
    }

    public function update(Request $request, Staff $staff)
    {
        if ($staff->establishment_id != Auth::user()->establishment_id) {
            abort(403);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'birth_date' => 'required|date|before_or_equal:' . Carbon::now()->subYears(15)->format('Y-m-d') . '|before_or_equal:today',
            'phone' => 'nullable|string|max:20',
            'bac_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'type' => 'required|in:إداري,مؤطر دراسي,خدمات',
            'univ_specialty' => 'nullable|string|max:50',
            'branch_id' => 'nullable|exists:branches,id',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        if ($validated['type'] === 'مؤطر دراسي') {
            $request->validate([
                'branch_id' => 'required|exists:branches,id',
                'subjects' => 'nullable|array',
                'subjects.*' => 'exists:subjects,id'
            ]);
        }

        $academicYearId = $staff->academic_year_id;
        if ($validated['type'] === 'مؤطر دراسي' && isset($validated['branch_id'])) {
            $branch = Branch::with('level')->find($validated['branch_id']);
            if ($branch && $branch->level) {
                $academicYearId = $branch->level->academic_year_id;
            }
        } else {
            if (is_null($academicYearId)) {
                $currentAcademicYear = AcademicYear::where('establishment_id', Auth::user()->establishment_id)
                    ->where('is_current', true)
                    ->first();
                $academicYearId = $currentAcademicYear ? $currentAcademicYear->id : null;
            }
        }

        $staff->update([
            'full_name' => $validated['full_name'],
            'birth_date' => $validated['birth_date'],
            'phone' => $validated['phone'],
            'bac_year' => $validated['bac_year'],
            'univ_specialty' => $validated['univ_specialty'],
            'type' => $validated['type'],
            'branch_id' => ($validated['type'] === 'مؤطر دراسي' && isset($validated['branch_id'])) ? $validated['branch_id'] : null,
            'academic_year_id' => $academicYearId,
        ]);

        if ($validated['type'] === 'مؤطر دراسي') {
            $staff->subjects()->sync($validated['subjects'] ?? []);
        } else {
            $staff->subjects()->detach();
        }

        return redirect()->route('admin.staffs.index')->with('success', 'تم تحديث بيانات المؤطر بنجاح');
    }

    public function destroy(Staff $staff)
    {
        if ($staff->establishment_id != Auth::user()->establishment_id) {
            abort(403);
        }

        $staff->delete();
        return redirect()->route('admin.staffs.index')->with('success', 'تم حذف المؤطر بنجاح');
    }
}