<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCulinary extends Model
{
    protected $table = 'post_culinaries';
    protected $fillable = [
        'post_id', 
        'cuisine_type', 
        'signature_dish', 
        'price_range', 
        'latitude', 
        'longitude'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
