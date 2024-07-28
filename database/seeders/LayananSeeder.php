<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contoh data layanan
        $layanan = [
            ['jenis_layanan' => 'Cuci', 'harga' => '4000', 'jenis_satuan' => 'kiloan'],
            ['jenis_layanan' => 'Cuci Setrika', 'harga' => '6000', 'jenis_satuan' => 'kiloan'],
            ['jenis_layanan' => 'Setrika', 'harga' => '4000', 'jenis_satuan' => 'kiloan'],
            ['jenis_layanan' => 'Cuci Ekspress', 'harga' => '8000', 'jenis_satuan' => 'kiloan'],
            ['jenis_layanan' => 'Selimut', 'harga' => '8000', 'jenis_satuan' => 'satuan'],
            ['jenis_layanan' => 'Sprei', 'harga' => '10000', 'jenis_satuan' => 'satuan'],
            ['jenis_layanan' => 'Handuk', 'harga' => '5000', 'jenis_satuan' => 'satuan'],
        ];
        // Masukkan data layanan ke dalam tabel
        foreach ($layanan as $p) {
            Layanan::create($p);
        }
    }
}
