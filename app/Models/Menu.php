<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CacheInvalidator;

class Menu extends Model
{
    use CacheInvalidator;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';

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
    protected $fillable = ['parent_id', 'group_id', 'name', 'url', 'target', 'position', 'create_user', 'update_user'];

	public function parent() {
		return $this->hasOne('App\Models\Menu', 'id', 'parent_id')->orderBy('position');
	}

	public function children() {
		return $this->hasMany('App\Models\Menu', 'parent_id', 'id')->orderBy('position');
	}

	public static function tree() {
		return static::with(implode('.', array_fill(0, 100, 'children')))->where('parent_id', '=', '0')->orderBy('position')->get();
	}
}
