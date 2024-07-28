<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = auth()->user();

        return view('profile.profile-index', compact('profile'));
    }


    public function editprofile(Request $request)
    {
        $profile = User::find(Auth::id());

        $profile->name = $request->name;
        $profile->alamat = $request->alamat;
        $profile->email = $request->email;
        $profile->no_telp = $request->no_telp;

        if ($request->filled('password')) {
            $profile->password = $request->password; // Ini akan di-hash oleh mutator di model
        }

        $profile->save();

        return redirect()->back()->with('success', 'Profil berhasil diubah.');
    }
}
