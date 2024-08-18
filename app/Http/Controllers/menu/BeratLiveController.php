<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Mail\ProsesPesanan;
use App\Models\Layanan;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Weight;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class BeratLiveController extends Controller
{
    public function index()
    {
        $berat = Weight::latest()->first(); // Ini akan memberikan model tunggal
        $pesananDaftar = Pemesanan::first();
        return view('beratlive.berat-live', compact('berat','pesananDaftar'));
    }

    public function getLatestWeight()
    {
        $berat = Weight::latest()->first();
        return response()->json(['weight' => $berat ? $berat->weight : null]);
    }

    // UTK KURIR
    public function tambahtransaksikiloan(Request $request, $id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $layanan = Layanan::findOrFail($request->input('layanan_id'));
        $harga = $layanan->harga;

        $total_berat = $request->input('total_berat');
        $total_bayar = $total_berat * $harga;

        $total_bayar_setelah_diskon = $total_bayar;
        $status_pembayaran = $request->input('status_pembayaran');
        $tanggal_pembayaran = null;

        if ($status_pembayaran === 'lunas') {
            $tanggal_pembayaran = Carbon::now()->format('Y-m-d H:i:s');
        }

        Transaksi::create([
            'user_id' => $request->input('user_id'),
            'layanan_id' => $request->input('layanan_id'),
            'pemesanan_id' => $pesanan->id, // Menggunakan $pesanan->id dari variabel $id yang sudah ada
            'tgl_ditimbang' => $request->input('tgl_ditimbang'),
            'total_berat' => $total_berat,
            'jumlah' => null,
            'helai_pakaian' => $request->input('helai_pakaian'),
            'status_pembayaran' => $status_pembayaran,
            'tanggal_pembayaran' => $tanggal_pembayaran,            
            'total_bayar' => $total_bayar_setelah_diskon,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update tgl_penjemputan dan tgl_pengantaran
        $tgl_penjemputan = Carbon::parse($pesanan->tgl_penjemputan);
        $jam_jemput = Carbon::parse($pesanan->jam_jemput);
        $tgl_pengantaran = $tgl_penjemputan->copy();
        $jam_antar = $jam_jemput->copy();

        // Cek jenis layanan dan tambahkan waktu sesuai
        if ($layanan->jenis_satuan == 'kiloan' && $layanan->durasi_layanan == '2 hari') {
            $tgl_pengantaran->addDays(2);
            $jam_antar = $jam_jemput->copy();
        } elseif ($layanan->jenis_satuan == 'kiloan' && $layanan->durasi_layanan == '12 jam') {
            if ($jam_jemput->hour >= 12 && $jam_jemput->hour < 24) {
                // Jika jam jemput antara 12:00 - 23:59
                $tgl_pengantaran->addDay();
                $jam_antar->addHours(12);
                if ($jam_antar->hour >= 24) {
                    $jam_antar->subHours(24);
                }
            } else {
                // Jika jam jemput antara 00:01 - 11:59
                $jam_antar->addHours(12);
                if ($jam_antar->hour >= 24) {
                    $tgl_pengantaran->addDay();
                    $jam_antar->subHours(24);
                }
            }
        }

        $tgl_pengantaran = $tgl_pengantaran->format('Y-m-d');
        $jam_antar = $jam_antar->format('H:i:s');

        $pesanan->update([
            'tgl_pengantaran' => $tgl_pengantaran,
            'jam_antar' => $jam_antar,
            'status_pemesanan' => 'pesanan sedang diproses'
        ]);        
        $pesanan->save();

        $user = User::findOrFail($pesanan->id_user);
        $transaksi = Transaksi::latest()->first();

        Mail::to($user->email)->send(new ProsesPesanan($transaksi, $user->name, $transaksi->total_berat, $transaksi->jumlah, $transaksi->total_bayar, $transaksi->status_pembayaran));

        return redirect()->route('order-index')
        ->with('success', 'Transaksi berhasil.')
        ->with('infokiloan', [
            'layanan' => $layanan->jenis_layanan, // Ganti 'nama_layanan' sesuai dengan kolom yang ada
            'total_berat' => $total_berat,
            'harga' => $total_bayar_setelah_diskon
        ]);;
    }
}
