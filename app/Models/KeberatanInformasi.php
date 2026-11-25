<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeberatanInformasi extends Model
{
    protected $table = 'keberatan_informasi';

    protected $fillable = [
        'nomor_registrasi_keberatan',
        'informasi_pengaju_keberatan',
        'nomor_permohonan_informasi',
        'tujuan_penggunaan_informasi',
        'nama',
        'alamat_lengkap',
        'pekerjaan',
        'nomor_telepon',
        'alasan_keberatan',
        'kasus_posisi',
        'status',
        'tanggapan',
        'tanggal_respon',
        'respon_oleh',
    ];

    protected $casts = [
        'tanggal_respon' => 'datetime',
    ];

    public static function generateNomorRegistrasi(): string
    {
        $prefix = 'KBR-' . date('Y') . '-';
        $last = self::where('nomor_registrasi_keberatan', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;
        if ($last) {
            $parts = explode('-', $last->nomor_registrasi_keberatan);
            $lastNum = intval(end($parts));
            $nextNumber = $lastNum + 1;
        }

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): array
    {
        return match ($this->status) {
            'diproses' => ['label' => 'Sedang Diproses', 'bg' => '#DBEAFE', 'color' => '#1D4ED8', 'border' => '#BFDBFE'],
            'selesai'  => ['label' => 'Selesai / Ditindaklanjuti', 'bg' => '#DCFCE7', 'color' => '#15803D', 'border' => '#BBF7D0'],
            'ditolak'  => ['label' => 'Ditolak', 'bg' => '#FEE2E2', 'color' => '#B91C1C', 'border' => '#FECACA'],
            default    => ['label' => 'Menunggu Verifikasi', 'bg' => '#FEF3C7', 'color' => '#B45309', 'border' => '#FDE68A'],
        };
    }

    public function responden()
    {
        return $this->belongsTo(User::class, 'respon_oleh');
    }
}
