<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    // Display Admin Login Page
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    // Handle Login Request
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => true], $request->remember)) {
            $user = Auth::user();

            // Restrict login to administrative roles only
            if (in_array($user->role, ['super_admin', 'admin', 'staff'])) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            // Reject customers/dealers from admin panel login
            Auth::logout();
            return back()->withErrors(['email' => 'Access denied. Authorized personnel only.']);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or account is inactive.',
        ])->onlyInput('email');
    }

    // Handle Admin Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}