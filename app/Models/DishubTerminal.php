<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishubTerminal extends Model
{
    protected $table = 'dishub_terminals';

    protected $fillable = [
        'group_no',
        'kabupaten_kota',
        'nama_terminal',
        'tipe',
        'status_operasional',
        'koordinat_label',
        'koordinat_url',
        'data_updated_at',
        'sort_order',
    ];

    protected $casts = [
        'data_updated_at' => 'date',
    ];

    public function getOperationalLabelAttribute(): string
    {
        $status = strtolower((string) $this->status_operasional);

        if (str_contains($status, 'aktif') || str_contains($status, 'kawasan informal')) {
            return 'Beroperasi';
        }

        return 'Tidak Beroperasi';
    }

    public function getOperationalBadgeAttribute(): string
    {
        return $this->operational_label === 'Beroperasi' ? 'success' : 'danger';
    }
}
