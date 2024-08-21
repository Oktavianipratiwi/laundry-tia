<?php

namespace App\Http\Controllers\menu;

use App\Http\Controllers\Controller;
use App\Mail\AntarPesanan;
use App\Mail\JemputPesanan;
use App\Mail\ProsesPesanan;
use App\Mail\TolakPesanan;
use App\Models\Layanan;
use App\Models\Pemesanan;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Weight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $pemesanan->tgl_penjemputan = $request->tgl_penjemputan;
        $pemesanan->jam_jemput = $request->jam_jemput;
        $pemesanan->no_telp = $request->no_telp;
        $pemesanan->id_layanan = $request->id_layanan;
        $pemesanan->status_pemesanan = 'pesanan belum diproses';
        $pemesanan->id_kurir = null;
        $pemesanan->save();

        return redirect()->route('order-index')->with('successful', 'Pemesanan berhasil disimpan.');
    }

    // UNTUK KURIR
    public function konfirmasiwhatsapp($id)
    {
    $pesanan = Pemesanan::findOrFail($id);
    $user = User::findOrFail($pesanan->id_user);
    $kurir = auth()->user();

    // Format nomor telepon
    $phoneNumber = preg_replace('/^0/', '62', $user->no_telp);
    // Hapus karakter non-digit
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
    
    $whatsappMessage = urlencode("Halo {$user->name}, saya {$kurir->name} dari layanan antar jemput Tia Laundry. Apakah Anda ada di rumah dan siap untuk penjemputan/pengantaran pesanan? Mohon konfirmasi ketersediaan Anda. Terima kasih!");
    $whatsappLink = "https://api.whatsapp.com/send?phone={$phoneNumber}&text=" . ($whatsappMessage);
    
    session()->flash('successful', 'Pesanan untuk konfirmasi ke WA pelanggan berhasil dikirim.');

    return redirect()->away($whatsappLink);
    }

    // UNTUK KURIR
    public function konfirmasipesananditolak(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        $user = User::findOrFail($pemesanan->id_user);

        Mail::to($user->email)->send(new TolakPesanan($user, $pemesanan));

        $pemesanan->status_pemesanan = 'pesanan ditolak';
        $pemesanan->alasan_penolakan = $request->input('alasan_penolakan');
        $pemesanan->save();

        return redirect()->route('order-index')->with('successful', 'Pesanan berhasil ditolak.');
    }

    // UNTUK KURIR
    public function konfirmasipesananjemput($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $user = User::findOrFail($pesanan->id_user);

        $kurir = auth()->user();
        Mail::to($user->email)->send(new JemputPesanan($user->name, $kurir->name, $kurir->no_telp));

        $pesanan->status_pemesanan = 'kurir jemput pesanan';
        $pesanan->jam_jemput = Carbon::now()->format('H:i:s');
        $pesanan->id_kurir = $kurir->id; // Simpan ID kurir yang sedang login
        $pesanan->save();


        return redirect()->route('order-index')->with('successful', 'Pesanan berhasil dikonfirmasi untuk penjemputan.');
    }

    // UNTUK KURIR
    public function konfirmasipesananantar($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $user = User::findOrFail($pesanan->id_user);

        $kurir = auth()->user();
        Mail::to($user->email)->send(new AntarPesanan($user->name, $kurir->name, $kurir->no_telp));

        $pesanan->status_pemesanan = 'kurir antar pesanan';
        $pesanan->jam_antar = Carbon::now()->format('H:i:s');
        $pesanan->save();

        return redirect()->route('order-index')->with('successful', 'Pesanan berhasil dikonfirmasi untuk pengantaran.');
    }

    // UTK KURIR
    public function pesananselesai($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $transaksi = Transaksi::where('pemesanan_id', $pesanan->id)->first();

        if ($transaksi) {
            // Jika transaksi ditemukan, ubah status pengantaran
            $transaksi->status_pengantaran = 'sudah diantar';
            $transaksi->save();
        }

        $pesanan->status_pemesanan = 'pesanan selesai';
        $pesanan->save();

        return redirect()->route('order-index')->with('successful', 'Pesanan selesai.');
    }

    // UTK KURIR
    public function tambahtransaksisatuan(Request $request, $id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $layanan = Layanan::findOrFail($request->input('layanan_id'));
        $harga = $layanan->harga;

        $jumlah = $request->input('jumlah');
        $total_bayar = $jumlah * $harga;

        $total_bayar_setelah_diskon = $total_bayar;

        $status_pembayaran = $request->input('status_pembayaran');
        $tanggal_pembayaran = null;

        if ($status_pembayaran === 'lunas') {
            $tanggal_pembayaran = Carbon::now()->format('Y-m-d H:i:s');
        }

        // Validasi input
        $request->validate([
            'foto_pakaian' => 'required|image|mimes:jpeg,jpg,png,heic|max:2048', // Validasi gambar
        ]);

        // Handle upload foto pakaian
        if ($request->hasFile('foto_pakaian')) {
            $file = $request->file('foto_pakaian');
            $filename = 'assets/pakaian/' . $file->getClientOriginalName();
            $file->move(public_path('assets/pakaian'), $filename);
        } else {
            $filename = null; // Default value if no image is uploaded
        }

        Transaksi::create([
            'user_id' => $request->input('user_id'),
            'layanan_id' => $request->input('layanan_id'),
            'pemesanan_id' => $pesanan->id, // Menggunakan $pesanan->id dari variabel $id yang sudah ada
            'tgl_ditimbang' => $request->input('tgl_ditimbang'),
            'jumlah' => $jumlah,
            'total_berat' => null,
            'helai_pakaian' => null,
            'foto_pakaian' => $filename, // Simpan nama file di database
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
        if ($layanan->jenis_satuan == 'satuan' && $layanan->durasi_layanan == '2 hari') {
            $tgl_pengantaran->addDays(2);
            $jam_antar = $jam_jemput->copy();
        } elseif ($layanan->jenis_satuan == 'satuan' && $layanan->durasi_layanan == '12 jam') {
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


        $pesanan->status_pemesanan = 'pesanan sedang diproses';
        $pesanan->save();

        return redirect()->route('order-index')->with('successful', 'Transaksi berhasil.')
        ->with('infosatuan', [
            'layanan' => $layanan->jenis_layanan, // Ganti 'nama_layanan' sesuai dengan kolom yang ada
            'jumlah' => $jumlah,
            'harga' => $total_bayar_setelah_diskon
        ]);
    }

    // UNTUK KURIR
    public function editpesanan(Request $request, $id)
    {
        $pesanan = Pemesanan::find($id);

        $pesanan->update($request->all());

        return redirect()->route('order-index')->with('successful', 'Pesanan berhasil diubah.');
    }

    // UNTUK KURIR
    public function hapuspesanan($id)
    {
        $pesanan = Pemesanan::find($id);

        $pesanan->delete();

        return redirect()->route('order-index')->with('successful', 'Pesanan berhasil dihapus.');
    }
}
