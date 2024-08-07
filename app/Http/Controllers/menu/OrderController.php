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
use Carbon\Carbon;
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
        $pemesanan->tgl_penjemputan = $request->tgl_penjemputan;
        $pemesanan->jam_jemput = $request->jam_jemput;
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
    
    session()->flash('success', 'Pesanan untuk konfirmasi ke WA pelanggan berhasil dikirim.');

    return redirect()->away($whatsappLink);
    }

    // UNTUK KURIR
    public function konfirmasipesananjemput($id)
    {
        $pesanan = Pemesanan::findOrFail($id);

        $user = User::findOrFail($pesanan->id_user);

        $kurir = auth()->user();
        Mail::to($user->email)->send(new JemputPesanan($user->name, $kurir->name, $kurir->no_telp));

        $pesanan->status_pemesanan = 'pegawai menuju lokasi';
        $pesanan->jam_jemput = Carbon::now()->format('H:i:s');
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
        $pesanan->jam_antar = Carbon::now()->format('H:i:s');
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
            'helai_pakaian' => $request->input('helai_pakaian'),
            'diskon' => $diskon,
            'status_pembayaran' => $request->input('status_pembayaran'),
            'total_bayar' => $total_bayar_setelah_diskon,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update tgl_penjemputan dan tgl_pengantaran
        $tgl_penjemputan = Carbon::parse($pesanan->tgl_penjemputan);
        $jam_jemput = Carbon::parse($pesanan->jam_jemput); // Mengambil jam jemput dari tabel pemesanan
        $tgl_pengantaran = $tgl_penjemputan;
        $jam_antar = $jam_jemput;

        // Cek jenis layanan dan tambahkan waktu sesuai
        if ($layanan->jenis_satuan == 'kiloan' && $layanan->durasi_layanan == '2 hari') {
            $tgl_pengantaran = $tgl_pengantaran->addDays(2);
            $jam_antar = $jam_jemput; 
        }elseif ($layanan->jenis_satuan == 'kiloan' && $layanan->durasi_layanan == '12 jam') {
            $jam_antar = $jam_antar->addHours(12);

            if ($jam_antar->hour >= 24) {
                $tgl_pengantaran = $tgl_pengantaran->addDay();
                $jam_antar = $jam_antar->subHours(24); // Reset jam_antar ke format 24 jam
            }
        }

        $tgl_pengantaran = $tgl_pengantaran->format('Y-m-d');
        $jam_antar = $jam_antar->format('H:i:s');

        $pesanan->update([
            'tgl_pengantaran' => $tgl_pengantaran,
            'jam_antar' => $jam_antar,
            'status_pemesanan' => 'sudah diproses'
        ]);        
        $pesanan->save();

        $user = User::findOrFail($pesanan->id_user);
        $transaksi = Transaksi::latest()->first();

        Mail::to($user->email)->send(new ProsesPesanan($transaksi, $user->name, $transaksi->total_berat, $transaksi->jumlah, $transaksi->total_bayar, $transaksi->status_pembayaran));

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
            'helai_pakaian' => null,
            'diskon' => $diskon,
            'status_pembayaran' => $request->input('status_pembayaran'),
            'total_bayar' => $total_bayar_setelah_diskon,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update tgl_penjemputan dan tgl_pengantaran
        $tgl_penjemputan = Carbon::parse($pesanan->tgl_penjemputan);
        $jam_jemput = Carbon::parse($pesanan->jam_jemput); // Mengambil jam jemput dari tabel pemesanan
        $tgl_pengantaran = $tgl_penjemputan;
        $jam_antar = $jam_jemput;

        // Cek jenis layanan dan tambahkan waktu sesuai
        if ($layanan->jenis_satuan == 'satuan' && $layanan->durasi_layanan == '2 hari') {
            $tgl_pengantaran = $tgl_pengantaran->addDays(2);
            $jam_antar = $jam_jemput; 
        }elseif ($layanan->jenis_satuan == 'satuan' && $layanan->durasi_layanan == '12 jam') {
            $jam_antar = $jam_antar->addHours(12);

            if ($jam_antar->hour >= 24) {
                $tgl_pengantaran = $tgl_pengantaran->addDay();
                $jam_antar = $jam_antar->subHours(24); // Reset jam_antar ke format 24 jam
            }
        }

        $pesanan->update([
            'tgl_pengantaran' => $tgl_pengantaran,
            'jam_antar' => $jam_antar,
            'status_pemesanan' => 'sudah diproses'
        ]);        
        $pesanan->save();

        $user = User::findOrFail($pesanan->id_user);
        $transaksi = Transaksi::latest()->first();

        Mail::to($user->email)->send(new ProsesPesanan($transaksi, $user->name, $transaksi->total_berat, $transaksi->jumlah, $transaksi->total_bayar, $transaksi->status_pembayaran));


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
