<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Atau model data banjir Anda

class PetaBanjirController extends Controller
{
    public function indexRW()
    {
        // Pastikan hanya role 'rw' yang bisa akses
        if (auth()->user()->role !== 'rw') {
            return redirect('/peta-banjir');
        }

        // Contoh data dummy (Nanti bisa diambil dari Database)
        $rwData = $this->getFloodData();

        return view('peta', compact('rwData'));
    }

    public function indexWarga()
    {
        $rwData = $this->getFloodData();
        return view('warga.peta', compact('rwData'));
    }

    private function getFloodData()
    {
        return [
            ['id' => '07', 'nama' => 'Cipagalo', 'status' => 'PARAH', 'kk' => 120, 'tinggi' => 180, 'color' => 'red'],
            ['id' => '12', 'nama' => 'Lengkong', 'status' => 'PARAH', 'kk' => 120, 'tinggi' => 130, 'color' => 'red'],
            ['id' => '13', 'nama' => 'Bojongsari', 'status' => 'SEDANG', 'kk' => 120, 'tinggi' => 80, 'color' => 'orange'],
        ];
    }
}