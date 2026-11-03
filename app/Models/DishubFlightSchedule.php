<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishubFlightSchedule extends Model
{
    protected $table = 'dishub_flight_schedules';

    protected $fillable = [
        'category',
        'airline',
        'route',
        'estimated_time',
        'operational_days',
        'notes',
        'source',
        'data_updated_at',
        'sort_order',
    ];

    protected $casts = [
        'data_updated_at' => 'date',
    ];
}
