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
            ['jenis_layanan' => 'Cuci 2 Hari', 'harga' => '4000', 'jenis_satuan' => 'kiloan','durasi_layanan' => '2 hari'],
            ['jenis_layanan' => 'Cuci Setrika 2 Hari', 'harga' => '6000', 'jenis_satuan' => 'kiloan','durasi_layanan' => '2 hari'],
            ['jenis_layanan' => 'Setrika 2 Hari', 'harga' => '4000', 'jenis_satuan' => 'kiloan','durasi_layanan' => '2 hari'],
            ['jenis_layanan' => 'Cuci Ekspress 12 Jam', 'harga' => '8000', 'jenis_satuan' => 'kiloan','durasi_layanan' => '12 jam'],
            ['jenis_layanan' => 'Selimut 2 Hari', 'harga' => '8000', 'jenis_satuan' => 'satuan','durasi_layanan' => '2 hari'],
            ['jenis_layanan' => 'Sprei 2 Hari', 'harga' => '10000', 'jenis_satuan' => 'satuan','durasi_layanan' => '2 hari'],
            ['jenis_layanan' => 'Handuk 2 Hari', 'harga' => '5000', 'jenis_satuan' => 'satuan','durasi_layanan' => '2 hari'],
        ];
        // Masukkan data layanan ke dalam tabel
        foreach ($layanan as $p) {
            Layanan::create($p);
        }
    }
}
