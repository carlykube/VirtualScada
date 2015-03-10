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
	protected $fillable = ['owner_id', 'name'];
/*
	public function get($id) {
		if (empty($id)) {
			return DB::table('projects')->where('owner_id', Auth::id())->get();
		} else {
			return DB::table('projects')->find($id);
		}
	} */
}
