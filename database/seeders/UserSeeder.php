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
            'no_telp' => '081374649623',
            'email' => 'infinitytech@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan data pelanggan
        DB::table('users')->insert([
            'name' => 'user',
            'alamat' => 'Pasar Baru',
            'no_telp' => '083174649623',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'role' => 'pelanggan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambahkan data pegawai
        DB::table('users')->insert([
            'name' => 'dini',
            'alamat' => 'Solok',
            'no_telp' => '081274649623',
            'email' => 'pegawai@gmail.com',
            'password' => Hash::make('pegawai'),
            'role' => 'pegawai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
