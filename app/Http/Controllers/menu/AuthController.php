<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return view('auth.auth-login');
        }
    }

    public function register()
    {
        return view('auth.auth-register');
    }

    public function daftaraksi(Request $request)
    {
        // Perform validation to ensure data integrity
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'email' => 'required|email|unique:users,email', // Check for unique email
            'password' => 'required|min:8|confirmed', // Enforce password strength and confirmation
        ]);

        try {
            // Create a new user instance
            $user = new User([
                'name' => $request->input('name'),
                'alamat' => $request->input('alamat'),
                'no_telp' => $request->input('no_telp'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => 'pelanggan', // Set role as 'pelanggan'
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Attempt to save the user to the database
            $user->save();

            // If successful, authenticate the user and redirect to intended destination
            Auth::login($user);
            return redirect()->intended('')->with('success', 'Registrasi berhasil! Silahkan masuk'); // Redirect to intended route after login (e.g., home)

        } catch (Exception $e) {
            // Handle potential database errors gracefully (e.g., unique constraint violation)
            return redirect()->back()->withErrors([
                'error' => 'Registration failed. Please try again.',
            ])->withInput($request->input()); // Retain form data for re-submission
        }
    }

    public function loginaksi(Request $request)
    {
        // Validate email and password fields
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt authentication using Laravel's built-in method
        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            // Login successful, redirect to dashboard
            return redirect()->intended('dashboard');
        }

        // Login failed, flash appropriate error message
        return redirect()->back()
            ->withErrors([
                'error' => 'Email atau Password Salah',
            ]);
    }

    public function logoutaksi()
    {
        Auth::logout();

        return redirect('/');
    }
}
