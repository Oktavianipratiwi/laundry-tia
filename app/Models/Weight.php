<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory;

    // Specify the table name if it's not the default 'weights'
    protected $table = 'weight_data';

    // Define any fillable fields if you're using mass assignment
    protected $fillable = ['weight'];
}
