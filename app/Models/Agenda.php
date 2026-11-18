<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheInvalidator;

class Agenda extends Model
{
    use CacheInvalidator;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agendas';

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
    protected $fillable = [
        'api_id',
        'title',
        'seotitle',
        'start',
        'end',
        'allday',
        'content',
        'location',
        'pakaian',
        'penyelenggara',
        'sumber_agenda',
        'status_waktu',
        'metadata',
        'color',
        'active',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    /**
     * Helper to get clean display location
     */
    public function getDisplayLocationAttribute(): string
    {
        if (!empty($this->location)) {
            return $this->location;
        }

        $stripped = trim(strip_tags($this->content ?? ''));
        return !empty($stripped) ? $stripped : 'Kantor Bappeda Provinsi Lampung';
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
