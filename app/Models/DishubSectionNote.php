<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishubSectionNote extends Model
{
    protected $table = 'dishub_section_notes';

    protected $fillable = [
        'section',
        'note',
        'data_updated_at',
        'sort_order',
    ];

    protected $casts = [
        'data_updated_at' => 'date',
    ];
}
