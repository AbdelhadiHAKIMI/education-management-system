<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;

class EstablishmentController extends Controller
{
    public function index()
    {
        $establishments = Establishment::with('creator')->get();
        return response()->json(['data' => $establishments]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name_ar' => 'required|string|max:100',
                'location' => 'required|string',
                'wilaya' => 'required|string|max:50',
                'phone' => 'nullable|string|max:30',
                'email' => 'nullable|email|max:100',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'is_active' => 'required',
                'admin_name' => 'required|string|max:255',
                'admin_email' => 'required|email|unique:users,email',
                'admin_password' => 'required|string|min:8'
            ]);

            DB::beginTransaction();

            $logo_path = null;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $logo_path = $file->storeAs('establishments/logos', $filename, 'public');
            }

            $userId = Auth::id() ?? 1;

            $establishment = Establishment::create([
                'name' => $request->name_ar,
                'location' => $request->location,
                'wilaya' => $request->wilaya,
                'phone' => $request->phone,
                'email' => $request->email,
                'logo' => $logo_path,
                'registration_code' => 'EST-' . strtoupper(Str::random(8)),
                'is_active' => $request->is_active === 'true' ? true : false,
                'created_by' => $userId
            ]);

            $user = User::create([
                'name' => $request->admin_name,
                'email' => $request->admin_email,
                'password' => Hash::make($request->admin_password),
                'role' => 'admin',
                'establishment_id' => $establishment->id
            ]);

            DB::commit();
            return redirect()->route('webmaster.dashboard')
                ->with('success', 'تم إنشاء المؤسسة بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Establishment store error: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    public function show(\App\Models\Establishment $establishment)
    {
        // Eager load manager if needed
        $establishment->load('manager');
        return view('webmaster.establishments.index', compact('establishment'));
    }

    public function edit(Establishment $establishment)
    {
        $establishment->load('manager');
        return view('webmaster.establishments.edit', compact('establishment'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'nullable|string',
            'wilaya' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'registration_code' => 'required|string|max:50|unique:establishments,registration_code,' . $establishment->id,
            'is_active' => 'boolean',
            // Manager fields (optional)
            'manager_name' => 'nullable|string|max:255',
            'manager_email' => 'nullable|email|max:100',
            'manager_phone' => 'nullable|string|max:30',
        ]);

        $data = $request->only([
            'name',
            'location',
            'wilaya',
            'phone',
            'email',
            'registration_code',
            'is_active'
        ]);

        if ($request->hasFile('logo')) {
            if ($establishment->logo) {
                Storage::disk('public')->delete($establishment->logo);
            }
            $file = $request->file('logo');
            $filename = \Illuminate\Support\Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('establishments/logos', $filename, 'public');
            $data['logo'] = $path;
        }

        $establishment->update($data);

        // Update manager info if provided
        if ($establishment->manager) {
            $managerData = [];
            if ($request->filled('manager_name')) {
                $managerData['name'] = $request->manager_name;
            }
            if ($request->filled('manager_email')) {
                $managerData['email'] = $request->manager_email;
            }
            if ($request->filled('manager_phone')) {
                $managerData['phone'] = $request->manager_phone;
            }
            if (!empty($managerData)) {
                $establishment->manager->update($managerData);
            }
        }

        return redirect()->route('webmaster.establishments.show', $establishment->id)
            ->with('success', 'تم تحديث بيانات المؤسسة بنجاح');
    }

    public function destroy(Establishment $establishment)
    {
        // Delete all users (admins/managers) linked to this establishment first
        $establishment->manager()->delete();

        if ($establishment->logo) {
            Storage::disk('public')->delete($establishment->logo);
        }

        $establishment->delete();
        // Redirect to dashboard and reload the page
        return redirect()->route('webmaster.dashboard')->with('success', 'تم حذف المؤسسة بنجاح');
    }

    public function removeAdmin(User $user)
    {
        // Only remove the user, not the establishment
        $establishmentId = $user->establishment_id;
        $user->delete();
        return Redirect::back()->with('success', 'تم حذف المدير بنجاح');
    }
}
