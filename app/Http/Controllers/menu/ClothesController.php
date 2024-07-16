<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\Pakaian;
use Illuminate\Http\Request;

class ClothesController extends Controller
{
    public function index()
    {
        $pakaianDaftar = Pakaian::all();

        return view('clothes.clothes-index', compact('pakaianDaftar'));
    }

    public function tambahpakaian(Request $request)
    {
        Pakaian::create([
            'jenis_pakaian' => $request->input('jenis_pakaian'),
            'harga' => $request->input('harga'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('clothes-index')->with('success', 'Data Pakaian berhasil ditambahkan.');
    }

    public function editpakaian(Request $request, $id)
    {
        $pakaian = Pakaian::find($id);

        $pakaian->update($request->all());

        return redirect()->route('clothes-index')->with('success', 'Data Pakaian berhasil diubah.');
    }

    public function hapuspakaian($id)
    {
        $pakaian = Pakaian::find($id);

        $pakaian->delete();

        return redirect()->route('clothes-index')->with('success', 'Data Pakaian berhasil dihapus.');
    }
}
