<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\CacheInvalidator;

class Video extends Model
{
    use CacheInvalidator;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'videos';

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
    protected $fillable = ['title', 'youtube_url', 'youtube_id', 'picture', 'active', 'created_by', 'updated_by'];

    public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}

	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
}
