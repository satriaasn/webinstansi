<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTransport extends Model
{
    protected $table = 'post_transports';
    protected $fillable = [
        'post_id', 
        'transport_mode', 
        'route_origin', 
        'route_destination', 
        'route_description', 
        'origin_latitude', 
        'origin_longitude', 
        'destination_latitude', 
        'destination_longitude', 
        'estimated_price'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
