<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishubTollRate extends Model
{
    protected $table = 'dishub_toll_rates';

    protected $fillable = [
        'asal_tujuan',
        'golongan_i',
        'golongan_ii_iii',
        'golongan_iv_v',
        'source',
        'data_updated_at',
        'sort_order',
    ];

    protected $casts = [
        'data_updated_at' => 'date',
    ];
}
