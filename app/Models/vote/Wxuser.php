<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\vote;

use Illuminate\Database\Eloquent\Model;

class Wxuser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote_wxuser';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'openid', 'sex',
        'province', 'city', 'country', 'headimgurl',
        'ctime', 'subscribe', 'username'
    ];

    public $timestamps = false;

    /**
     * Get the vote_logs for the wxuser.
     */
    public function vote_logs()
    {
        return $this->hasMany('App\Models\vote\VoteLog', 'user_id');
    }
}