<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DownloadCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'download_categorys';

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
    protected $fillable = ['title', 'seotitle', 'active', 'is_perencanaan', 'created_by', 'updated_by'];

    protected $casts = [
        'is_perencanaan' => 'boolean',
    ];

    public function downloads()
    {
        return $this->hasMany('App\Models\Download', 'download_category_id');
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
