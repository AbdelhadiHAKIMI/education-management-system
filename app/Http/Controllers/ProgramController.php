<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    // Display a listing of the programs
    public function index()
    {
        $programs = Program::all();
        return response()->json($programs);
    }

    // Store a newly created program in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'academic_year_id' => 'required|exists:academic_years,id',
            'registration_fees' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'created_by_id' => 'required|exists:users,id',
        ]);

        $program = Program::create($validated);
        return response()->json($program, 201);
    }

    // Display the specified program
    public function show(Program $program)
    {
        return response()->json($program);
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
}