<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pakaian extends Model
{
    use HasFactory;

    protected $table = 'pakaian'; // Menyatakan bahwa model ini terhubung dengan tabel 'pakaian'

    protected $fillable = [
        'jenis_pakaian',
        'harga',
    ];
}
