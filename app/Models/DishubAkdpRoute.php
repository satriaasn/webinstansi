<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishubAkdpRoute extends Model
{
    protected $table = 'dishub_akdp_routes';

    protected $fillable = [
        'wilayah_tujuan',
        'detail_trayek',
        'keterangan',
        'kategori',
        'label_aplikasi',
        'source',
        'data_updated_at',
        'sort_order',
    ];

    protected $casts = [
        'data_updated_at' => 'date',
    ];
}
