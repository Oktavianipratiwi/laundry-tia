<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    // Nama tabel yang sesuai dengan model
    protected $table = 'otp';

    // Kolom yang dapat diisi
    protected $fillable = ['email', 'otp'];
}
