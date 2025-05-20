<?php

namespace app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Branch;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
   public function index(Request $request)
   {
      // Get current user's establishment
      $establishmentId = Auth::user()->establishment_id;

      $query = Staff::with(['branch.level.academicYear'])
         ->where('establishment_id', $establishmentId)
         ->latest();

      // Search filter
      if ($request->has('search')) {
         $query->where('full_name', 'like', '%' . $request->search . '%')
            ->orWhere('phone', 'like', '%' . $request->search . '%');
      }

      // Branch filter
      if ($request->has('branch') && $request->branch != '') {
         $query->where('branch_id', $request->branch);
      }

      $staffs = $query->paginate(25);
      $branches = Branch::whereHas('level.academicYear', function ($q) use ($establishmentId) {
         $q->where('establishment_id', $establishmentId);
      })->get();

      return view('admin.staffs.index', compact('staffs', 'branches'));
   }

   public function create()
   {
      $establishmentId = Auth::user()->establishment_id;
      $branches = Branch::with('level.academicYear')
         ->whereHas('level.academicYear', function ($q) use ($establishmentId) {
            $q->where('establishment_id', $establishmentId);
         })->get();

      return view('admin.staffs.create', compact('branches'));
   }

   public function store(Request $request)
   {
      $validated = $request->validate([
         'full_name' => 'required|string|max:100',
         'birth_date' => 'required|date',
         'phone' => 'nullable|string|max:20',
         'bac_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
         'branch_id' => 'required|exists:branches,id',
         'univ_specialty' => 'nullable|string|max:50',
      ]);

      // Get academic year from branch
      $branch = Branch::with('level')->findOrFail($request->branch_id);

      Staff::create([
         'full_name' => $validated['full_name'],
         'birth_date' => $validated['birth_date'],
         'phone' => $validated['phone'],
         'bac_year' => $validated['bac_year'],
         'branch_id' => $validated['branch_id'],
         'univ_specialty' => $validated['univ_specialty'],
         'academic_year_id' => $branch->level->academic_year_id,
         'establishment_id' => Auth::user()->establishment_id
      ]);

      return redirect()->route('admin.staffs.index')->with('success', 'تمت إضافة المؤطر بنجاح');
   }

   public function show(Staff $staff)
   {
      // Authorization check
      if ($staff->establishment_id != Auth::user()->establishment_id) {
         abort(403);
      }

      return view('admin.staffs.show', compact('staff'));
   }

   public function edit(Staff $staff)
   {
      // Authorization check
      if ($staff->establishment_id != Auth::user()->establishment_id) {
         abort(403);
      }

      $establishmentId = Auth::user()->establishment_id;
      $branches = Branch::with('level.academicYear')
         ->whereHas('academicYear', function ($q) use ($establishmentId) {
            $q->where('establishment_id', $establishmentId);
         })->get();

      return view('admin.staffs.edit', compact('staff', 'branches'));
   }

   public function update(Request $request, Staff $staff)
   {
      // Authorization check
      if ($staff->establishment_id != Auth::user()->establishment_id) {
         abort(403);
      }

      $validated = $request->validate([
         'full_name' => 'required|string|max:100',
         'birth_date' => 'required|date',
         'phone' => 'nullable|string|max:20',
         'bac_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
         'branch_id' => 'required|exists:branches,id',
         'univ_specialty' => 'nullable|string|max:50',
      ]);

      // Get academic year from branch if changed
      if ($staff->branch_id != $request->branch_id) {
         $branch = Branch::with('level')->findOrFail($request->branch_id);
         $validated['academic_year_id'] = $branch->level->academic_year_id;
      }

      $staff->update($validated);

      return redirect()->route('admin.staffs.index')->with('success', 'تم تحديث بيانات المؤطر بنجاح');
   }

   public function destroy(Staff $staff)
   {
      // Authorization check
      if ($staff->establishment_id != Auth::user()->establishment_id) {
         abort(403);
      }

      $staff->delete();
      return redirect()->route('admin.staffs.index')->with('success', 'تم حذف المؤطر بنجاح');
   }
}
