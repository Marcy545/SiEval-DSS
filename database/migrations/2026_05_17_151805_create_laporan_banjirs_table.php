<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan_banjirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Hubungan ke akun RW jika login
            $table->string('rw_kelurahan');
            $table->string('status_banjir');
            $table->integer('ketinggian_air');
            $table->string('durasi_banjir');
            $table->string('penyebab');
            $table->integer('jumlah_kk');
            $table->integer('jumlah_jiwa');
            $table->string('butuh_evakuasi')->default('Tidak');
            $table->integer('jumlah_lansia')->default(0)->nullable();
            $table->integer('jumlah_bayi_bumil')->default(0)->nullable();
            $table->integer('rumah_tergenang');
            $table->string('tingkat_keparahan');
            $table->integer('toko_terdampak')->default(0)->nullable();
            $table->string('fasum_terdampak')->nullable();
            $table->json('dokumentasi')->nullable(); // Menyimpan nama 3 foto dalam bentuk Array/JSON
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_banjirs');
    }
};