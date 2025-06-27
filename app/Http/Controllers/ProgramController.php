<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramInvitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    // Display a listing of the programs
    public function index()
    {
        $user = Auth::user();
        $establishmentId = $user ? $user->establishment_id : null;
        $activeAcademicYear = null;
        if ($establishmentId) {
            $activeAcademicYear = \App\Models\AcademicYear::where('establishment_id', $establishmentId)
                ->where('status', true)
                ->first();
        }

        $programs = collect();
        if ($activeAcademicYear) {
            $programs = \App\Models\Program::where('academic_year_id', $activeAcademicYear->id)
                ->get();
        }

        return view('admin.programs.index', compact('programs'));
    }

    // Show the form for creating a new program
    public function create()
    {
        $academicYears = \App\Models\AcademicYear::all();
        $levels = \App\Models\Level::all();

        $user = Auth::user();
        $establishmentId = $user ? $user->establishment_id : null;
        $activeAcademicYear = null;
        if ($establishmentId) {
            $activeAcademicYear = \App\Models\AcademicYear::where('establishment_id', $establishmentId)
                ->where('status', true)
                ->first();
        }
        $students = $activeAcademicYear
            ? \App\Models\Student::with('branch')->where('academic_year_id', $activeAcademicYear->id)->get()
            : collect();

        $staff = \App\Models\Staff::all();
        $branches = \App\Models\Branch::all();

        return view('admin.programs.create', compact('academicYears', 'levels', 'students', 'staff', 'branches'));
    }

    // Store a newly created program in storage
    public function store(Request $request)
    {
        // Debug: check what is being sent
        // Remove this after debugging
        // dd($request->all());

        // Validate required fields for the program
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'academic_year_id' => 'required|exists:academic_years,id',
            'level_id' => 'required|exists:levels,id',
            'registration_fees' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
            'created_by_id' => 'required|exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            // Create the program
            $program = \App\Models\Program::create($validated);

            // Create invitations for selected students (bulk insert)
            $studentIds = $request->input('student_ids', []);
            if (!empty($studentIds) && is_array($studentIds)) {
                $now = now();
                $invitations = [];
                foreach ($studentIds as $studentId) {
                    $invitations[] = [
                        'student_id' => $studentId,
                        'program_id' => $program->id,
                        'status' => 'accepted',
                        'is_exempt' => false,
                        'invited_at' => $now,
                        'responded_at' => null,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
                \App\Models\ProgramInvitation::insert($invitations);
            }

            DB::commit();
            // Redirect to create page instead of edit page
            return redirect()->route('admin.programs.index')
                ->with('success', 'تم إنشاء البرنامج بنجاح. يمكنك الآن إضافة برنامج جديد.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Program creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'حدث خطأ أثناء حفظ البرنامج: ' . $e->getMessage()]);
        }
    }

    // Display the specified program
    public function show(Request $request, Program $program)
    {
        $academicYears = \App\Models\AcademicYear::all();
        $levels = \App\Models\Level::all();
        $invitations = $program->invitations ?? collect();
        return view('admin.programs.show', compact('program', 'academicYears', 'levels', 'invitations'));
    }

    // Show the form for editing the specified program
    public function edit(Program $program)
    {
        $academicYears = \App\Models\AcademicYear::all();
        $levels = \App\Models\Level::all();
        $invitations = $program->invitations ?? collect();
        return view('admin.programs.edit', compact('program', 'academicYears', 'levels', 'invitations'));
    }

    // Update the specified program in storage
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'description' => 'nullable|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'academic_year_id' => 'sometimes|required|exists:academic_years,id',
            'registration_fees' => 'sometimes|required|numeric|min:0',
            'is_active' => 'boolean',
            'created_by_id' => 'sometimes|required|exists:users,id',
        ]);

        $program->update($validated);
        return response()->json($program);
    }

    // Remove the specified program from storage
    public function destroy(Program $program)
    {
        $program->delete();
        return response()->json(null, 204);
    }

    // Step 1: Initial Data
    public function wizardStep1()
    {
        $academicYears = \App\Models\AcademicYear::all();
        $levels = \App\Models\Level::all();
        return view('admin.programs.wizard.step1', compact('academicYears', 'levels'));
    }
    public function wizardStep1Post(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'academic_year_id' => 'required|exists:academic_years,id',
            'registration_fees' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'level_id' => 'required|exists:levels,id',
        ]);
        session(['program_wizard.step1' => $validated]);
        return redirect()->route('admin.programs.wizard.step2');
    }

    // Step 2: Select Students
    public function wizardStep2()
    {
        $students = \App\Models\Student::all();
        return view('admin.programs.wizard.step2', compact('students'));
    }
    public function wizardStep2Post(Request $request)
    {
        $validated = $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);
        session(['program_wizard.step2' => $validated]);
        return redirect()->route('admin.programs.wizard.step3');
    }

    // Step 3: Assign Staff
    public function wizardStep3()
    {
        $staff = \App\Models\Staff::all();
        return view('admin.programs.wizard.step3', compact('staff'));
    }
    public function wizardStep3Post(Request $request)
    {
        $validated = $request->validate([
            'supervisor_ids' => 'nullable|array',
            'supervisor_ids.*' => 'exists:staff,id',
            'teacher_ids' => 'nullable|array',
            'teacher_ids.*' => 'exists:staff,id',
            'admin_ids' => 'nullable|array',
            'admin_ids.*' => 'exists:staff,id',
        ]);
        session(['program_wizard.step3' => $validated]);
        return redirect()->route('admin.programs.wizard.step4');
    }

    // Step 4: Finalize and Save
    public function wizardStep4()
    {
        $data = [
            'step1' => session('program_wizard.step1'),
            'step2' => session('program_wizard.step2'),
            'step3' => session('program_wizard.step3'),
        ];
        return view('admin.programs.wizard.step4', $data);
    }
    public function wizardStep4Post(Request $request)
    {
        $step1 = session('program_wizard.step1');
        $step2 = session('program_wizard.step2');
        $step3 = session('program_wizard.step3');
        $establishmentId = session('establishment')->id ?? (Auth::user()->establishment_id ?? null);

        $program = Program::create(array_merge($step1, [
            'created_by_id' => Auth::id(),
            'establishment_id' => $establishmentId,
        ]));

        // Attach students and staff as needed (pseudo-code, adjust as per your relations)
        // $program->students()->sync($step2['student_ids']);
        // $program->staff()->sync([...$step3['supervisor_ids'], ...$step3['teacher_ids'], ...$step3['admin_ids']]);

        // --- Add this block to fill program_invitations ---
        if (!empty($step2['student_ids'])) {
            $now = now();
            foreach ($step2['student_ids'] as $studentId) {
                ProgramInvitation::create([
                    'student_id' => $studentId,
                    'program_id' => $program->id,
                    'status' => 'invited',
                    'is_exempt' => false,
                    'invited_at' => $now,
                    'responded_at' => null,
                ]);
            }
        }
        // ---------------------------------------------------

        // Clear wizard session
        session()->forget('program_wizard');

        return redirect()->route('admin.programs.edit', $program->id)
            ->with('success', 'تم إنشاء البرنامج بنجاح.');
    }

    // Update invitation status for a student in a program
    public function updateInvitationStatus(Request $request, $invitationId)
    {
        $request->validate([
            'status' => 'required|in:invited,accepted,rejected'
        ]);
        $invitation = \App\Models\ProgramInvitation::findOrFail($invitationId);
        $invitation->status = $request->input('status');
        $invitation->responded_at = now();
        $invitation->save();

        return response()->json(['success' => true, 'status' => $invitation->status]);
    }

    // AJAX: Search/filter students in a program by name or branch
    public function filterInvitedStudents(Request $request, $programId)
    {
        $query = \App\Models\ProgramInvitation::with('student.branch')
            ->where('program_id', $programId);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('full_name', 'like', "%$search%");
            });
        }
        if ($request->filled('branch_id')) {
            $branchId = $request->input('branch_id');
            $query->whereHas('student', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        $invitations = $query->get();

        // Build a simple HTML table string (example)
        $html = '<table><tr><th>#</th><th>اسم الطالب</th><th>الشعبة</th></tr>';
        foreach ($invitations as $i => $inv) {
            $html .= '<tr>';
            $html .= '<td>' . ($i+1) . '</td>';
            $html .= '<td>' . ($inv->student->full_name ?? '-') . '</td>';
            $html .= '<td>' . ($inv->student->branch->name ?? '-') . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';

        return response()->json([
            'html' => $html
        ]);
    }

}