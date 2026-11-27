<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturOrganisasi extends Model
{
    protected $table = 'struktur_organisasis';

    protected $fillable = [
        'parent_id',
        'jabatan',
        'nama',
        'nip',
        'pangkat',
        'tmt_pangkat',
        'tmt_jabatan',
        'foto',
        'tipe_node',
        'urutan',
        'deskripsi',
        'active',
        'created_by',
        'updated_by',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('urutan', 'asc')->orderBy('id', 'asc');
    }

    public function activeChildren()
    {
        return $this->hasMany(self::class, 'parent_id')
            ->where('active', 'Y')
            ->orderBy('urutan', 'asc')
            ->orderBy('id', 'asc');
    }
}
