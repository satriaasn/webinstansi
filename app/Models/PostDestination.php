<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheInvalidator;

class PostDestination extends Model
{
    use CacheInvalidator;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_destinations';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'address',
        'city',
        'region',
        'latitude',
        'longitude',
        'opening_hours',
        'ticket_price',
        'contact_info'
    ];

    /**
     * Get the post that owns the destination data.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
