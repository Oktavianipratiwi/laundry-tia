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
        $kurirDaftar = User::where('role', 'pegawai')->get();

        return view('courier.courier-index', compact('kurirDaftar'));
    }

    public function tambahkurir(Request $request)
    {
        User::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->password),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp'),
            'email' => $request->input('email'),
            'role' => 'pegawai',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('courier-index')->with('successEdit', 'Data Pakaian berhasil ditambahkan.');
    }

    public function editkurir(Request $request, $id)
    {
        $kurir = User::find($id);

        $kurir->update($request->all());

        return redirect()->route('courier-index')->with('successEdit', 'Data Kurir berhasil diubah.');
    }

    public function hapuskurir($id)
    {
        $kurir = User::find($id);

        $kurir->delete();

        return redirect()->route('courier-index')->with('successDelete', 'Data Kurir berhasil dihapus.');
    }
}
