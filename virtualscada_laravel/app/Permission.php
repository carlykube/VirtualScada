<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'user_id', 'open', 'edit', 'share'];

}
