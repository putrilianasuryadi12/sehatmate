<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        // If already logged in, redirect appropriately
        if (Auth::check()) {
            // Redirect all authenticated users to foods management
            return redirect()->route('superadmin.foods.index');
        }
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function store(Request $request)
    {
        // Debugging login API requests
        Log::debug('Login API Debug', [
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'payload' => $request->all(),
            'expectsJson' => $request->expectsJson(),
            'database_connection' => DB::connection()->getDatabaseName(),
        ]);

        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // --- Start Manual Password Verification Debug ---
        $user = User::where('email', $credentials['email'])->first();

        if ($user && $user->status !== 'approved') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account is pending approval or has been rejected.',
                ], 403);
            }
            return back()->withErrors([
                'email' => 'Your account is pending approval or has been rejected.',
            ])->onlyInput('email');
        }

        if ($user) {
            Log::debug('Manual Check: User found.', ['email' => $user->email]);
            Log::debug('Manual Check: Stored Hash.', ['hash' => $user->password]);
            $isPasswordCorrect = Hash::check($credentials['password'], $user->password);
            Log::debug('Manual Check: Hash::check result.', ['correct' => $isPasswordCorrect]);
        } else {
            Log::debug('Manual Check: User not found.', ['email' => $credentials['email']]);
        }
        // --- End Manual Password Verification Debug ---

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            // Debug: print full user model data
            try {
                Log::debug('DB User Data', $user->toArray());
            } catch (\Exception $e) {
                Log::error('Failed to log user data', ['error' => $e->getMessage()]);
            }
            Log::info('User authentication successful', ['id' => $user->id, 'email' => $user->email]);

            // Debug: log response payload for AJAX
            if ($request->expectsJson()) {
                $payload = [
                    'success' => true,
                    'message' => 'Login berhasil',
                    'user' => $user,
                    'role' => $user->role,
                ];
                Log::debug('Login API Response', $payload);
                return response()->json($payload);
            }
            // Normal request redirects based on role
            // Redirect all authenticated users to foods management
            return redirect()->route('superadmin.foods.index');
        }

        Log::warning('Login failed', ['email' => $request->email]);

        // Debug: log failed login response for AJAX
        if ($request->expectsJson()) {
            $errorPayload = [
                'success' => false,
                'message' => 'Email atau kata sandi yang diberikan tidak cocok.',
            ];
            // include status in debug context
            $errorPayload['status'] = 401;
            Log::debug('Login API Error Response', $errorPayload);
            return response()->json($errorPayload, 401);
        }
        // Normal redirect back with error message
        return redirect()->back()
            ->withErrors(['email' => 'Email atau kata sandi yang diberikan tidak cocok.'])
            ->withInput();
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Remove role cookie
        $forget = Cookie::forget('role');
        return redirect('/')->withCookie($forget);
    }
}
