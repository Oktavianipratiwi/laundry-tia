<?php

namespace Database\Seeders;

use App\Models\Pakaian;
use Illuminate\Database\Seeder;

class PakaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contoh data pakaian
        $pakaian = [
            ['jenis_pakaian' => 'Kemeja', 'harga' => '7000'],
            ['jenis_pakaian' => 'Celana Jeans', 'harga' => '8000'],
            ['jenis_pakaian' => 'T-Shirt', 'harga' => '5000'],
            ['jenis_pakaian' => 'Jaket', 'harga' => '9000'],
            ['jenis_pakaian' => 'Celana Pendek', 'harga' => '6000'],
            ['jenis_pakaian' => 'Gaun', 'harga' => '10000'],
            ['jenis_pakaian' => 'Blazer', 'harga' => '11000'],
            ['jenis_pakaian' => 'Rok', 'harga' => '7000'],
            ['jenis_pakaian' => 'Sweater', 'harga' => '8000'],
            ['jenis_pakaian' => 'Hoodie', 'harga' => '9000'],
            ['jenis_pakaian' => 'Kaos Dalam', 'harga' => '3000'],
            ['jenis_pakaian' => 'Kain Sarung', 'harga' => '5000'],
            ['jenis_pakaian' => 'Baju Kurung', 'harga' => '8000'],
            ['jenis_pakaian' => 'Piyama', 'harga' => '7000'],
            ['jenis_pakaian' => 'Jas', 'harga' => '15000'],
            ['jenis_pakaian' => 'Cardigan', 'harga' => '6000'],
            ['jenis_pakaian' => 'Celana Kargo', 'harga' => '7000'],
            ['jenis_pakaian' => 'Daster', 'harga' => '5000'],
            ['jenis_pakaian' => 'Syal', 'harga' => '3000'],
            ['jenis_pakaian' => 'Sarung Tangan', 'harga' => '2000'],
            ['jenis_pakaian' => 'Topi', 'harga' => '4000'],
            ['jenis_pakaian' => 'Jas Hujan', 'harga' => '12000'],
            ['jenis_pakaian' => 'Rompi', 'harga' => '5000'],
            ['jenis_pakaian' => 'Baju Olahraga', 'harga' => '6000'],
            ['jenis_pakaian' => 'Baju Renang', 'harga' => '7000'],
            ['jenis_pakaian' => 'Setelan Jas', 'harga' => '20000'],
            ['jenis_pakaian' => 'Dress', 'harga' => '12000'],
            ['jenis_pakaian' => 'Mantel', 'harga' => '13000'],
            ['jenis_pakaian' => 'Celana Pendek', 'harga' => '6000'],
            ['jenis_pakaian' => 'Baju Tidur', 'harga' => '7000'],
            ['jenis_pakaian' => 'Kemeja Batik', 'harga' => '10000'],
            ['jenis_pakaian' => 'Blus', 'harga' => '6000'],
            ['jenis_pakaian' => 'Legging', 'harga' => '5000'],
            ['jenis_pakaian' => 'Baju Anak', 'harga' => '4000'],
            ['jenis_pakaian' => 'Jubah', 'harga' => '9000'],
            ['jenis_pakaian' => 'Kimono', 'harga' => '11000'],
            ['jenis_pakaian' => 'Parka', 'harga' => '12000'],
        ];
                // Masukkan data pakaian ke dalam tabel
        foreach ($pakaian as $p) {
            Pakaian::create($p);
        }
    }
}
