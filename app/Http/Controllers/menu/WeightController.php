<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Http\Controllers\menu\TransactionsController;
use Illuminate\Http\Request;
use App\Models\Weight;

class WeightController extends Controller
{
    public function index()
    {
        // Retrieve the latest weight data
        $latest_weight = Weight::latest()->first();

        // Redirect to the create method in TransaksiController and pass the latest weight data
        return redirect()->action([TransactionsController::class, 'create'], ['weight_data' => $latest_weight]);
    }

    public function store(Request $request)
    {
        // Mengambil total berat dari input dengan name 'total_berat'
        $weight = $request->input('total_berat');

        // Menambahkan log untuk debug
        error_log("Received weight: " . $weight);

        try {
            // Membuat record baru dalam tabel weight_data dengan total berat yang diterima
            Weight::create(['weight' => $weight]);
            return response()->json(['message' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menyimpan data'], 500);
        }
    }
}
