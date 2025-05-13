<?php

namespace App\Http\Controllers;

use App\Models\Establishment;

class DashboardController extends Controller
{
    public function index()
    {
        $establishments = Establishment::with('manager')->paginate(10);
        return view('webmaster.dashboard', compact('establishments'));
    }
}
