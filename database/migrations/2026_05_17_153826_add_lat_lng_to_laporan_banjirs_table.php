<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('laporan_banjirs', function (Blueprint $table) {
            // Menggunakan decimal tipe data standar koordinat peta (presisi tinggi)
            $table->decimal('latitude', 10, 8)->nullable()->after('rw_kelurahan');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
        });
    }

    public function down()
    {
        Schema::table('laporan_banjirs', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};