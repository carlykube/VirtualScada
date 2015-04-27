<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['project_id', 'name', 'file_loc', 'screen_loc', 'type'];

    public function project(){
        return $this->belongsTo('App\Project');
    }

}
