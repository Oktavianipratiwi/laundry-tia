<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\Weight;

class BeratLiveController extends Controller
{
    public function index()
    {
        $berat = Weight::latest()->first(); // Ini akan memberikan model tunggal
        return view('beratlive.berat-live', compact('berat'));
    }

    public function getLatestWeight()
    {
        $berat = Weight::latest()->first();
        return response()->json(['weight' => $berat ? $berat->weight : null]);
    }
}
