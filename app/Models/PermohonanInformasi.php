<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanInformasi extends Model
{
    use HasFactory;

    protected $table = 'permohonan_informasi';

    protected $fillable = [
        'nomor_tiket',
        'kategori_pemohon',
        'nama_pemohon',
        'nik',
        'file_ktp',
        'email',
        'no_telepon',
        'pekerjaan',
        'instansi',
        'alamat',
        'rincian_informasi',
        'tujuan_penggunaan',
        'cara_memperoleh',
        'cara_penyerahan',
        'file_pendukung',
        'status',
        'tanggapan',
        'file_lampiran_jawaban',
        'tanggal_respon',
        'respon_oleh',
        'email_notifikasi_terkirim',
        'tanggal_email_terakhir',
    ];

    protected $casts = [
        'tanggal_respon' => 'datetime',
        'tanggal_email_terakhir' => 'datetime',
        'email_notifikasi_terkirim' => 'boolean',
    ];

    public function responder()
    {
        return $this->belongsTo(User::class, 'respon_oleh');
    }

    public static function generateNomorTiket()
    {
        $prefix = 'INF-' . date('Ym') . '-';
        do {
            $random = strtoupper(substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 5));
            $tiket = $prefix . $random;
        } while (self::where('nomor_tiket', $tiket)->exists());

        return $tiket;
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'diproses' => 'Sedang Diproses',
            'selesai' => 'Diterima / Selesai',
            'ditolak' => 'Ditolak / Keberatan',
            default => 'Menunggu Verifikasi',
        };
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'pending' => '<span class="badge badge-warning text-dark font-weight-bold px-2 py-1"><i class="fa fa-clock-o mr-1"></i> Menunggu Verifikasi</span>',
            'diproses' => '<span class="badge badge-info text-white font-weight-bold px-2 py-1"><i class="fa fa-cogs mr-1"></i> Sedang Diproses</span>',
            'selesai' => '<span class="badge badge-success text-white font-weight-bold px-2 py-1"><i class="fa fa-check mr-1"></i> Diterima / Selesai</span>',
            'ditolak' => '<span class="badge badge-danger text-white font-weight-bold px-2 py-1"><i class="fa fa-times mr-1"></i> Ditolak</span>',
            default => '<span class="badge badge-secondary px-2 py-1">Menunggu</span>',
        };
    }

    public function getStatusColorClass()
    {
        return match ($this->status) {
            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-300', 'icon' => 'fa-clock'],
            'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-300', 'icon' => 'fa-spinner fa-spin'],
            'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'border' => 'border-emerald-300', 'icon' => 'fa-check-circle'],
            'ditolak' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-800', 'border' => 'border-rose-300', 'icon' => 'fa-times-circle'],
            default => ['bg' => 'bg-slate-100', 'text' => 'text-slate-800', 'border' => 'border-slate-300', 'icon' => 'fa-clock'],
        };
    }
}

