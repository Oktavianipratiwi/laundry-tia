<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CourierController extends Controller
{
    public function index()
    {
        $kurirDaftar = User::where('role', 'kurir')->get();

        return view('courier.courier-index', compact('kurirDaftar'));
    }

    public function tambahkurir(Request $request)
    {
        User::create([
            'name' => $request->input('name'),
            'password' => $request->input('password'),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp'),
            'email' => $request->input('email'),
            'role' => 'kurir',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('courier-index')->with('successful', 'Data Kurir berhasil ditambahkan.');
    }

    public function editkurir(Request $request, $id)
    {
        $kurir = User::find($id);

        $kurir->update($request->all());

        return redirect()->route('courier-index')->with('successful', 'Data Kurir berhasil diubah.');
    }

    public function hapuskurir($id)
    {
        $kurir = User::find($id);

        $kurir->delete();

        return redirect()->route('courier-index')->with('successful', 'Data Kurir berhasil dihapus.');
    }
}
