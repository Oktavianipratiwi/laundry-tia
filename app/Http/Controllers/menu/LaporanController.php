<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Transaksi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        $laporanPerBulan = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $transaksiPerBulan = Transaksi::where('status_pembayaran', 'lunas')
                ->whereMonth('tanggal_pembayaran', $bulan)
                ->whereYear('tanggal_pembayaran', date('Y'))
                ->orderBy('tanggal_pembayaran')
                ->get()
                ->groupBy(function ($item) {
                    return Carbon::parse($item->tanggal_pembayaran)->format('Y-m-d');
                });

            $laporanPerHari = [];
            foreach ($transaksiPerBulan as $tanggal => $transaksi) {
                $laporanPerHari[] = [
                    'tanggal' => Carbon::parse($tanggal),
                    'total' => $transaksi->sum('total_bayar'),
                    'transaksi_ids' => $transaksi->pluck('id')->toArray(),
                ];
            }

            $laporanPerBulan[$bulan] = $laporanPerHari;
        }

        return view('laporan.laporan-index', compact('laporanPerBulan'));
    }

    public function detail($tanggal)
    {
        $transaksi = Transaksi::whereDate('tanggal_pembayaran', $tanggal)
            ->where('status_pembayaran', 'lunas')
            ->with(['user', 'layanan'])
            ->get();

        return view('laporan.laporan-detail', compact('transaksi', 'tanggal'));
    }

}
