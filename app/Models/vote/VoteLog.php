<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\vote;

use Illuminate\Database\Eloquent\Model;

class VoteLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vote_id', 'item_id', 'user_id',
        'time_key', 'log_time', 'ip'
    ];

    /**
     * Get the wxuser that owns the vote_log.
     */
    public function wxuser()
    {
        return $this->belongsTo('App\Models\vote\Wxuser', 'user_id');
    }
}