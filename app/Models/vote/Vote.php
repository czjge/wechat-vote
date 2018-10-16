<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\vote;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'start_time', 'end_time', 'appid', 'appsecret',
        'info_share_title', 'info_share_desc',
        'other_share_logo', 'other_share_title', 'other_share_desc',
        'audit_status', 'rank_num', 'photo_size', 'photo_num',
        'index_sort_type', 'clicks', 'status', 'cdn_status',
        'vote_start_time', 'vote_end_time', 'subscribe_vote_status',
    ];

    /**
     * Get the candidates for the vote.
     */
    public function candidates()
    {
        return $this->hasMany('App\Models\vote\Candidate', 'vote_id');
    }
}