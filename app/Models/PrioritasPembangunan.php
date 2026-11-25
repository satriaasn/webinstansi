<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrioritasPembangunan extends Model
{
    protected $table = 'prioritas_pembangunans';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'description',
        'icon',
        'urutan',
        'active',
        'created_by',
        'updated_by',
    ];
}
