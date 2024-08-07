<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'id_user',
        'tgl_pemesanan',
        'tgl_penjemputan',
        'jam_jemput',
        'jam_antar',
        'tgl_pengantaran',
        'tgl_pemesanan',
        'alamat',
        'status_pemesanan',
    ];


        public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
