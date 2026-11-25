<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikMakro extends Model
{
    protected $table = 'statistik_makro';

    protected $fillable = [
        'api_id',
        'judul',
        'deskripsi',
        'sektor_nama',
        'kategori_nama',
        'jenis_grafik',
        'jenis_indikator',
        'is_indikator_utama',
        'satuan',
        'periode',
        'sumber_data',
        'nilai_terbaru',
        'nilai_formatted',
        'delta_formatted',
        'arah_perubahan',
        'periode_terbaru',
        'periode_pembanding',
        'data_series',
        'show_on_home',
        'urutan',
        'synced_at',
    ];

    protected $casts = [
        'is_indikator_utama' => 'boolean',
        'show_on_home' => 'boolean',
        'data_series' => 'array',
        'synced_at' => 'datetime',
    ];
}
