<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            switch ($role) {
                case 'webmaster':
                    return redirect()->intended('webmaster/dashboard');
                case 'super_admin':
                    return redirect()->intended('admin/dashboard');
                case 'admin':
                    return redirect()->intended('admin/dashboard');
                case 'teacher':
                    return redirect()->intended('teacher/dashboard');
                default:
                    Auth::logout();
                    return redirect('/')->withErrors(['role' => 'Unauthorized role.']);
            }
        }
        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     return redirect()->intended('webmaster/dashboard');
        // }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    // Show register form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Handle registration request
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:webmaster,super_admin,admin,teacher',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}