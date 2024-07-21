<?php

namespace Database\Seeders;

use Database\Seeders\TransaksiSeeder as SeedersTransaksiSeeder;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil seeder


        $this->call(UserSeeder::class);
        $this->call(LayananSeeder::class);
        $this->call(PemesananSeeder::class);
        $this->call(TransaksiSeeder::class);
    }
}
