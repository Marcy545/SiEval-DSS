<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Menyuntikkan akun default untuk Kecamatan / Camat
        User::create([
            'name'     => 'Admin Kecamatan Bojongsoang',
            'role'     => 'kecamatan',
            'rw_desa'  => null,
            'email'    => 'camat@bojongsoang.com', // Sesuaikan dengan email resmi
            'password' => Hash::make('123456'),      // Password default 6 digit
        ]);
    }
}