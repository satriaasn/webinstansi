<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostAccommodation extends Model
{
    protected $table = 'post_accommodations';
    protected $fillable = [
        'post_id', 
        'accommodation_type', 
        'price_range', 
        'facilities', 
        'star_rating', 
        'latitude', 
        'longitude'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
