<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'pelanggan') {
            // Jika role pelanggan, tampilkan hanya transaksi milik user yang login
            $transaksiDaftar = Transaksi::where('user_id', $user->id)->get();
        } elseif ($user->role === 'pegawai') {
            // Jika role pegawai, tampilkan semua transaksi
            $transaksiDaftar = Transaksi::all();
        } else {
            // Contoh default untuk role selain pelanggan dan pegawai, bisa disesuaikan dengan role lainnya
            $transaksiDaftar = Transaksi::all();
        }

        return view('transactions.transactions-index', compact('transaksiDaftar'));
    }

    public function konfirmasitransaksi($id)
    {
        $transaksi = Transaksi::find($id);

        $transaksi->status_pembayaran = 'lunas';

        // $transaksi->pemesanan->status_pemesanan = 'sudah diperiksa';
        $transaksi->save();

        return redirect()->route('transactions-index')->with('success', 'Data Transaksi berhasil dikonfirmasi.');
    }

    public function hapustransaksi($id)
    {
        $transaksi = Transaksi::find($id);

        $transaksi->delete();

        return redirect()->route('transactions-index')->with('success', 'Data Transaksi berhasil dihapus.');
    }

    public function detailtransaksi($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $pemesanan = $transaksi->pemesanan;
        return view('transactions.transactions-detail', compact('transaksi', 'pemesanan'));
    }

    public function bayartransaksi(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $transaksi = Transaksi::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->move(public_path('assets/bukti'), $request->file('bukti_pembayaran')->getClientOriginalName());
            $transaksi->bukti_pembayaran = 'assets/bukti/' . $request->file('bukti_pembayaran')->getClientOriginalName();
        }


        $transaksi->status_pembayaran = 'lunas';
        $transaksi->save();

        return redirect()->route('transactions-index')->with('success', 'Transaksi berhasil.');
    }
}
