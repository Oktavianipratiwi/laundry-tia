<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'layanan_id',
        'pakaian_id',
        'pemesanan_id',
        'total_berat',
        'jumlah',
        'helai_pakaian',
        'diskon',
        'tgl_ditimbang',
        'tgl_diambil',
        'total_bayar',
        'status_pembayaran',
        'bukti_pembayaran',
        'status_pengantaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }
}
