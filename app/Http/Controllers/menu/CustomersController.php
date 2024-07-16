<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{
    public function index()
    {
        $pelangganDaftar = User::where('role', 'pelanggan')->get();

        return view('customers.customers-index', compact('pelangganDaftar'));
    }

    public function tambahpelanggan(Request $request)
    {
        User::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->password),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp'),
            'email' => $request->input('email'),
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('customers-index')->with('success', 'Data Pelanggan berhasil ditambahkan.');
    }

    public function editpelanggan(Request $request, $id)
    {
        $pelanggan = User::find($id);

        $pelanggan->update($request->all());

        return redirect()->route('customers-index')->with('success', 'Data Pelanggan berhasil diubah.');
    }

    public function hapuspelanggan($id)
    {
        $pelanggan = User::find($id);

        $pelanggan->delete();

        return redirect()->route('customers-index')->with('success', 'Data Pelanggan berhasil dihapus.');
    }
}
