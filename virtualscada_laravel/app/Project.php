<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * Class Project
 *
 * @package App
 */
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
	protected $fillable = ['name', 'user_id'];

    /**
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeOfUser($query, $user_id)
	{
		return $query->whereUserId($user_id);
	}

    /**
     * Establishes a belongTo relationship between Projects and User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * Establishes a hasMany relationship between Projects and Module
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modules(){
        return $this->hasMany('App\Module');
    }

    /**
     * Establishes a hasMany relationship between Project and Permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany('App\Permission');
    }
}
