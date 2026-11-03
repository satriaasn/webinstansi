<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendaftaranLayanan extends Model
{
    protected $table = 'pendaftaran_layanan';

    protected $fillable = [
        'nomor_registrasi', 'layanan_sosial_id',
        'nama_lengkap', 'nik', 'jenis_kelamin', 'tanggal_lahir', 'tempat_lahir',
        'agama', 'status_perkawinan', 'pendidikan_terakhir',
        'alamat_lengkap', 'kelurahan_desa', 'kecamatan', 'kabupaten_kota',
        'no_telepon', 'email',
        'nama_wali', 'hubungan_wali', 'no_telepon_wali', 'alamat_wali',
        'data_tambahan',
        'file_ktp', 'file_kk', 'file_surat_keterangan', 'file_dokumen_pendukung', 'file_foto',
        'status', 'catatan_petugas',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'data_tambahan'  => 'array',
        'tanggal_daftar' => 'datetime',
    ];

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(LayananSosial::class, 'layanan_sosial_id');
    }

    /** Generate nomor registrasi unik */
    public static function generateNomorRegistrasi(string $kodeLayanan): string
    {
        $prefix   = 'REG/' . $kodeLayanan . '/' . date('Ymd');
        $last     = self::where('nomor_registrasi', 'like', $prefix . '%')->count();
        $sequence = str_pad($last + 1, 4, '0', STR_PAD_LEFT);
        return $prefix . '/' . $sequence;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'  => 'Menunggu Verifikasi',
            'diproses'  => 'Sedang Diproses',
            'diterima'  => 'Diterima',
            'ditolak'   => 'Ditolak',
            'selesai'   => 'Selesai',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'menunggu'  => 'warning',
            'diproses'  => 'info',
            'diterima'  => 'success',
            'ditolak'   => 'danger',
            'selesai'   => 'secondary',
            default     => 'light',
        };
    }
}
