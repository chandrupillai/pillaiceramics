<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;
use App\Models\User;
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
        // 1. Validate Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            // 2. Check if user exists first to provide accurate feedback
            $user = User::where('email', $credentials['email'])->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }

            // 3. Check if account is active
            if (!$user->is_active) {
                throw ValidationException::withMessages([
                    'email' => 'Your account is inactive. Please contact support.',
                ]);
            }

            // 4. Attempt authentication
            if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $request->boolean('remember'))) {
                throw ValidationException::withMessages([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }

            // 5. Verify administrative roles
            $allowedRoles = ['super_admin', 'admin', 'staff'];
            if (!in_array(Auth::user()->role, $allowedRoles)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'email' => 'Access denied. Authorized personnel only.',
                ]);
            }

            // 6. Regenerate session upon successful login
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        } catch (ValidationException $e) {
            throw $e; // Re-throw validation errors so Laravel handles redirect back automatically
        } catch (Exception $e) {
            // Catch any unexpected system or database exceptions
            return back()->withErrors([
                'email' => 'An error occurred during authentication: ' . $e->getMessage(),
            ])->onlyInput('email');
        }
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
