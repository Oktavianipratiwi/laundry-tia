<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan'; // Menyatakan bahwa model ini terhubung dengan tabel 'layanan'

    protected $fillable = [
        'jenis_layanan',
        'harga',
        'jenis_satuan',
        'durasi_layanan'
    ];
}
