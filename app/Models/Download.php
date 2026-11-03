<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'downloads';

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
    protected $fillable = ['download_category_id', 'title', 'seotitle', 'content', 'file', 'active', 'created_by', 'updated_by'];

	public function downloadCategory()
	{
		return $this->belongsTo('App\Models\DownloadCategory');
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
