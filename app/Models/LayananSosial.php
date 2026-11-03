<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LayananSosial extends Model
{
    protected $table = 'layanan_sosial';

    protected $fillable = [
        'kode', 'nama', 'singkatan', 'jenis', 'deskripsi',
        'persyaratan', 'icon', 'warna', 'file_brosur', 'aktif', 'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(PendaftaranLayanan::class, 'layanan_sosial_id');
    }

    /** Label jenis untuk display */
    public function getJenisLabelAttribute(): string
    {
        return $this->jenis === 'uptd' ? 'UPTD' : 'Bidang';
    }
}
