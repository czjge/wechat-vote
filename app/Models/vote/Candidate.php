<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\vote;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'candidate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vote_id', 'no', 'name', 'sex', 'tel', 'desc',
        'pic_url', 'num', 'clicks', 'sort', 'status', 'daily_max_votes',
        'type', 'hos', 'dep', 'tit',
    ];

    /**
     * Get the vote that owns the candidate.
     */
    public function vote () {
        return $this->belongsTo('App\Models\vote\Vote', 'vote_id');
    }
}