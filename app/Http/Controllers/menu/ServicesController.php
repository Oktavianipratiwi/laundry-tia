<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $layananDaftar = Layanan::all();

        return view('services.services-index', compact('layananDaftar'));
    }

    public function tambahlayanan(Request $request)
    {
        Layanan::create([
            'jenis_layanan' => $request->input('jenis_layanan'),
            'harga' => $request->input('harga'),
            'jenis_satuan' => $request->input('jenis_satuan'),
            'durasi_layanan' => $request->input('durasi_layanan'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('services-index')->with('success', 'Data Layanan berhasil ditambahkan.');
    }

    public function editlayanan(Request $request, $id)
    {
        $layanan = Layanan::find($id);

        $layanan->update($request->all());

        return redirect()->route('services-index')->with('success', 'Data Layanan berhasil diubah.');
    }

    public function hapuslayanan($id)
    {
        $layanan = Layanan::find($id);

        $layanan->delete();

        return redirect()->route('services-index')->with('success', 'Data Layanan berhasil dihapus.');
    }
}
