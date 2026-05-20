<?php

namespace App\Models;

use App\Models\User;
use App\Services\FloodScoringService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanBanjir extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'user_id', 'rw_kelurahan', 'status_banjir', 'ketinggian_air', 'durasi_banjir',
        'penyebab', 'jumlah_kk', 'jumlah_jiwa', 'butuh_evakuasi', 'jumlah_lansia',
        'jumlah_bayi_bumil', 'rumah_tergenang', 'tingkat_keparahan', 'toko_terdampak',
        'fasum_terdampak', 'dokumentasi', 'latitude', 'longitude'
    ];

    // Konversi otomatis data JSON dari DB menjadi Array PHP saat dipanggil
    protected $casts = [
        'dokumentasi' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $appends = ['priority_score', 'priority_label'];

    public function getPriorityScoreAttribute()
    {
        return FloodScoringService::calculateScore($this);
    }

    public function getPriorityLabelAttribute()
    {
        return FloodScoringService::getLabel($this->priority_score);
    }

}