<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{
    protected $table = 'flyers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'picture',
        'url',
        'description',
        'active',
        'created_by',
        'updated_by',
    ];
}
