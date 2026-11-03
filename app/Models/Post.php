<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\CacheInvalidator;

class Post extends Model
{
    use CacheInvalidator;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['post_category_id', 'title', 'seotitle', 'content', 'tag', 'picture', 'headline', 'active', 'created_by', 'updated_by'];

	public function postCategory()
	{
		return $this->belongsTo('App\Models\PostCategory');
	}

    public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}

	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}

    /**
     * Get the destination details associated with the post.
     */
    public function destination()
    {
        return $this->hasOne(PostDestination::class, 'post_id', 'id');
    }

    /**
     * Get the reviews for the post.
     */
    public function reviews()
    {
        return $this->hasMany(PostReview::class, 'post_id', 'id');
    }

    /**
     * Get only approved reviews.
     */
    public function approvedReviews()
    {
        return $this->hasMany(PostReview::class, 'post_id', 'id')->where('status', 'approved');
    }

    public function accommodation()
    {
        return $this->hasOne(PostAccommodation::class, 'post_id', 'id');
    }

    public function culinary()
    {
        return $this->hasOne(PostCulinary::class, 'post_id', 'id');
    }

    public function transport()
    {
        return $this->hasOne(PostTransport::class, 'post_id', 'id');
    }

    /**
     * Get all related posts (many-to-many).
     */
    public function relatedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_related', 'post_id', 'related_post_id')->withTimestamps();
    }

    /**
     * Get all posts that are related to this post (reverse of relatedPosts).
     */
    public function mappedToPosts()
    {
        return $this->belongsToMany(Post::class, 'post_related', 'related_post_id', 'post_id')->withTimestamps();
    }
}
