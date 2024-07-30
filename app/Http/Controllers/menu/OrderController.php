<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Mail\AntarPesanan;
use App\Mail\JemputPesanan;
use App\Mail\ProsesPesanan;
use App\Models\Layanan;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $weight_data = Weight::latest()->first();


        if ($user->role === 'pelanggan') {
            // Jika role pelanggan, tampilkan hanya pesanan milik user yang login
            $pesananDaftar = Pemesanan::where('id_user', $user->id)->get();
        } else {
            // Jika role bukan pelanggan (misalnya admin atau staff), tampilkan semua pesanan
            $pesananDaftar = Pemesanan::all();
        }

        $layananDaftar = Layanan::all();

        return view('order.order-index', compact('pesananDaftar', 'weight_data', 'layananDaftar'));
    }

    // UNTUK PELANGGAN
    public function tambahpesanan(Request $request)
    {
        $pemesanan = new Pemesanan;
        $pemesanan->id_user = Auth::user()->id;
        $pemesanan->tgl_pemesanan = $request->tgl_pemesanan;
        $pemesanan->alamat = $request->alamat;
        $pemesanan->no_telp = $request->no_telp;
        $pemesanan->status_pemesanan = 'belum diproses';
        $pemesanan->save();

        // $pemesanan = Pemesanan::find($request->pemesanan_id);
        // $pemesanan->status_pemesanan = 'sudah diproses';
        // $pemesanan->save();

        // if (Auth::user()->role == 'pegawai') {
        //     return redirect()->route('order-index')->with('success', 'Transaksi berhasil ditambahkan.');
        // } elseif (Auth::user()->role == 'admin') {
        //     return redirect()->route('order-index')->with('success', 'Transaksi berhasil ditambahkan.');
        // } else {
        //     return redirect()->route('order-index')->with('success', 'Pemesanan berhasil disimpan.');
        // }

        return redirect()->route('order-index')->with('success', 'Pemesanan berhasil disimpan.');
    }

    // UNTUK KURIR
    public function konfirmasipesananjemput($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $user = User::findOrFail($pesanan->id_user);

        $kurir = auth()->user();
        Mail::to($user->email)->send(new JemputPesanan($user->name, $kurir->name, $kurir->no_telp));

        $pesanan->status_pemesanan = 'pegawai menuju lokasi';
        $pesanan->save();


        return redirect()->route('order-index')->with('success', 'Pesanan berhasil dikonfirmasi untuk penjemputan.');
    }

    // UNTUK KURIR
    public function konfirmasipesananantar($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $user = User::findOrFail($pesanan->id_user);

        $kurir = auth()->user();
        Mail::to($user->email)->send(new AntarPesanan($user->name, $kurir->name, $kurir->no_telp));

        $pesanan->status_pemesanan = 'antar pesanan';
        $pesanan->save();

        return redirect()->route('order-index')->with('success', 'Pesanan berhasil dikonfirmasi untuk pengantaran.');
    }

    public function pesananselesai($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $transaksi = Transaksi::where('pemesanan_id', $pesanan->id)->first();

        if ($transaksi) {
            // Jika transaksi ditemukan, ubah status pengantaran
            $transaksi->status_pengantaran = 'sudah diantar';
            $transaksi->save();
        }

        $pesanan->status_pemesanan = 'sudah diperiksa';
        $pesanan->save();

        return redirect()->route('order-index')->with('success', 'Pesanan selesai.');
    }

    // UTK KURIR
    public function tambahtransaksikiloan(Request $request, $id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $layanan = Layanan::findOrFail($request->input('layanan_id'));
        $harga = $layanan->harga;

        $total_berat = $request->input('total_berat');
        $total_bayar = $total_berat * $harga;

        $diskon = $request->input('diskon', 0);
        $total_bayar_setelah_diskon = $total_bayar - $diskon;

        Transaksi::create([
            'user_id' => $request->input('user_id'),
            'layanan_id' => $request->input('layanan_id'),
            'pemesanan_id' => $pesanan->id, // Menggunakan $pesanan->id dari variabel $id yang sudah ada
            'tgl_ditimbang' => $request->input('tgl_ditimbang'),
            'total_berat' => $total_berat,
            'jumlah' => null,
            'diskon' => $diskon,
            'status_pembayaran' => $request->input('status_pembayaran'),
            'total_bayar' => $total_bayar_setelah_diskon,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user = User::findOrFail($pesanan->id_user);
        $transaksi = Transaksi::latest()->first();

        Mail::to($user->email)->send(new ProsesPesanan($user->name, $transaksi->total_berat, $transaksi->jumlah, $transaksi->total_bayar, $transaksi->status_pembayaran));

        $pesanan->status_pemesanan = 'sudah diproses';
        $pesanan->save();

        return redirect()->route('order-index')->with('success', 'Transaksi berhasil.');
    }

    // UTK KURIR
    public function tambahtransaksisatuan(Request $request, $id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $layanan = Layanan::findOrFail($request->input('layanan_id'));
        $harga = $layanan->harga;

        $jumlah = $request->input('jumlah');
        $total_bayar = $jumlah * $harga;

        $diskon = $request->input('diskon', 0);
        $total_bayar_setelah_diskon = $total_bayar - $diskon;

        Transaksi::create([
            'user_id' => $request->input('user_id'),
            'layanan_id' => $request->input('layanan_id'),
            'pemesanan_id' => $pesanan->id, // Menggunakan $pesanan->id dari variabel $id yang sudah ada
            'tgl_ditimbang' => $request->input('tgl_ditimbang'),
            'jumlah' => $jumlah,
            'total_berat' => null,
            'diskon' => $diskon,
            'status_pembayaran' => $request->input('status_pembayaran'),
            'total_bayar' => $total_bayar_setelah_diskon,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user = User::findOrFail($pesanan->id_user);
        $transaksi = Transaksi::latest()->first();

        Mail::to($user->email)->send(new ProsesPesanan($user->name, $transaksi->total_berat, $transaksi->jumlah, $transaksi->total_bayar, $transaksi->status_pembayaran));


        $pesanan->status_pemesanan = 'sudah diproses';
        $pesanan->save();

        return redirect()->route('order-index')->with('success', 'Transaksi berhasil.');
    }


    public function editpesanan(Request $request, $id)
    {
        $pesanan = Pemesanan::find($id);

        $pesanan->update($request->all());

        return redirect()->route('order-index')->with('success', 'Pesanan berhasil diubah.');
    }

    public function hapuspesanan($id)
    {
        $pesanan = Pemesanan::find($id);

        $pesanan->delete();

        return redirect()->route('order-index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
