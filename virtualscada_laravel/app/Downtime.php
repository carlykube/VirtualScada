<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Downtime extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'downtime';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'start_time', 'end_time'];

    public function scopeFuture($query)
    {
        $query->where('start_time', '>=', Carbon::now());
    }
}
