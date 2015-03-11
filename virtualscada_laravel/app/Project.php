<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'owner_id'];

	public function scopeOfUser($query, $user_id) 
	{
		return $query->whereOwnerId($user_id);
	}
}
