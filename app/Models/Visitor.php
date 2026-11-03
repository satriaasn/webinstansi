<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Visitor extends Model
{
    protected $table = 'visitors';
    protected $primaryKey = 'id_visitor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_client', 'session_id', 'user_agent', 'date_time'
    ];


}
