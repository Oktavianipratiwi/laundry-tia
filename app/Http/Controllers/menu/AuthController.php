<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Mail\KirimOtpValidasiEmail;
use App\Models\Otp;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function register()
    {
        return view('auth.auth-register');
    }

    // public function daftaraksi(Request $request)
    // {
    //     // Perform validation to ensure data integrity
    //     $this->validate($request, [
    //         'name' => 'required|string|max:255',
    //         'alamat' => 'required|string',
    //         'no_telp' => 'required|string',
    //         'email' => 'required|email|unique:users,email', // Check for unique email
    //         'password' => 'required|min:8|confirmed', // Enforce password strength and confirmation
    //     ]);

    //     try {
    //         // Create a new user instance
    //         $user = new User([
    //             'name' => $request->input('name'),
    //             'alamat' => $request->input('alamat'),
    //             'no_telp' => $request->input('no_telp'),
    //             'email' => $request->input('email'),
    //             'password' => $request->input('password'),
    //             'role' => 'pelanggan', // Set role as 'pelanggan'
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         ]);

    //         // Attempt to save the user to the database
    //         $user->save();

    //         // If successful, authenticate the user and redirect to intended destination
    //         // Auth::login($user);
    //         // return redirect()->intended('')->with('success', 'Registrasi berhasil! Silahkan masuk'); // Redirect to intended route after login (e.g., home)
    //         return view('auth.auth-validasiemail');
    //     } catch (Exception $e) {
    //         // Handle potential database errors gracefully (e.g., unique constraint violation)
    //         return redirect()->back()->withErrors([
    //             'error' => 'Registration failed. Please try again.',
    //         ])->withInput($request->input()); // Retain form data for re-submission
    //     }
    // }

    // DAFTAR AKUN SEKALIGUS DIRECT KE HALAMAN VALIDASI OTP
    public function daftaraksi(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            // Generate a 4-digit OTP
            $otp = sprintf('%04d', rand(0, 9999));

            // Store user data in session
            $request->session()->put('temp_user_data', [
                'name' => $request->input('name'),
                'alamat' => $request->input('alamat'),
                'no_telp' => $request->input('no_telp'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role' => 'pelanggan',
            ]);

            // Store OTP in the database
            Otp::updateOrCreate(
                ['email' => $request->input('email')],
                ['otp' => $otp]
            );

            // Send OTP to user's email
            Mail::to($request->input('email'))->send(new KirimOtpValidasiEmail($otp));

            // dd($request->session()->get('temp_user_data'));

            // Redirect to OTP verification page
            return redirect()->route('validasiotp')->with('email', $request->input('email'));
        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Registration failed. Please try again.',
            ])->withInput($request->except('password'));
        }
    }

    public function validasiotp()
    {
        return view('auth.auth-validasiotp');
    }

    public function validasiotpaksi(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required|string|size:4',
        ]);

        // Ambil data user sementara dari session
        $tempUserData = $request->session()->get('temp_user_data');

        // Jika data tidak ada, kembalikan ke halaman registrasi
        if (!$tempUserData) {
            return redirect()->route('register')->withErrors('Session expired. Please register again.');
        }

        // Ambil email dari data user sementara
        $email = $tempUserData['email'];

        $inputOtp = (int) $request->input('otp');

        $otpData = Otp::where('email', $email)->first();

        // dd([
        //     'tempUserData' => $tempUserData,
        //     'email' => $email,
        //     'inputOtp' => $inputOtp,
        //     'otpData' => $otpData,
        //     'storedOtp' => $otpData ? $otpData->otp : null,
        // ]);

        if ($otpData && $inputOtp === (int)$otpData->otp) {
            // OTP is correct, create the user
            $user = User::create($tempUserData);

            // Clear temporary session data and OTP record
            $request->session()->forget('temp_user_data');
            $otpData->delete();

            // Log the user in
            Auth::login($user);

            return redirect()->intended('')->with('success', 'Registration successful!');
        } else {
            // dd($tempUserData, $inputOtp, $otpData);
            return back()->withErrors('Invalid OTP. Please try again.');
        }
    }


    public function logoutaksi()
    {
        Auth::logout();

        return redirect('/');
    }
}
