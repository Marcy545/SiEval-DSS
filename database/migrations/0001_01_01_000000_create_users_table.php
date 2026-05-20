<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // Kolom nama (berisi Nama RW atau Nama Instansi Kecamatan)
            $table->string('name');
            
            // Role menggunakan nama asli agar tidak bingung (default ke 'rw')
            $table->enum('role', ['rw', 'kecamatan'])->default('rw');
            
            // Wajib untuk RW, kosong untuk Kecamatan
            $table->string('rw_desa')->nullable();

            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};