<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheInvalidator;

class PostReview extends Model
{
    use CacheInvalidator;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_reviews';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'guest_name',
        'guest_email',
        'rating',
        'comment',
        'status'
    ];

    /**
     * Get the post that owns the review.
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
