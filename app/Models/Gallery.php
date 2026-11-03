<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\CacheInvalidator;

class Gallery extends Model
{
    use CacheInvalidator;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gallerys';

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
    protected $fillable = ['album_id', 'title', 'seotitle', 'picture', 'active', 'created_by', 'updated_by'];

	public function album()
	{
		return $this->belongsTo('App\Models\Album');
	}

    public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}

	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
}
