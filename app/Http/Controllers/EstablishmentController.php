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

    public function show(Establishment $establishment)
    {
        return response()->json(['data' => $establishment->load('creator')]);
    }

    public function update(Request $request, Establishment $establishment)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'location' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'registration_code' => 'required|string|max:50|unique:establishments,registration_code,' . $establishment->id,
            'is_active' => 'boolean'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            if ($establishment->logo) {
                Storage::disk('public')->delete($establishment->logo);
            }

            $file = $request->file('logo');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('establishments/logos', $filename, 'public');
            $data['logo'] = $path;
        }

        $establishment->update($data);
        return response()->json(['data' => $establishment]);
    }

    public function destroy(Establishment $establishment)
    {
        if ($establishment->logo) {
            Storage::disk('public')->delete($establishment->logo);
        }

        $establishment->delete();
        return response()->json(null, 204);
    }
}
