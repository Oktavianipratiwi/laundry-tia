<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tambahkan data admin
        DB::table('users')->insert([
            'name' => 'administrator',
            'alamat' => 'Padang',
            'no_telp' => '081212121212',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan data pelanggan
        DB::table('users')->insert([
            'name' => 'pelanggan',
            'alamat' => 'Limau Manis',
            'no_telp' => '081234556789',
            'email' => 'pelanggan@gmail.com',
            'password' => Hash::make('pelanggan'),
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan data kurir
        DB::table('users')->insert([
            'name' => 'kurir',
            'alamat' => 'Pariaman',
            'no_telp' => '081345678909',
            'email' => 'kurir@gmail.com',
            'password' => Hash::make('kurir'),
            'role' => 'kurir',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
