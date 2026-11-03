<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheInvalidator;

class Setting extends Model
{
    use CacheInvalidator;
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

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
    protected $fillable = ['key', 'value', 'created_by', 'updated_by'];

	public function createdBy()
	{
		return $this->belongsTo('App\Models\User', 'created_by');
	}

	public function updatedBy()
	{
		return $this->belongsTo('App\Models\User', 'updated_by');
	}
}
