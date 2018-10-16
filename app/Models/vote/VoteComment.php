<?php
/**
 * Created by PhpStorm.
 * User: zhoujie
 * Date: 2017/07/11
 * Time: 10:54
 */
namespace App\Models\vote;

use Illuminate\Database\Eloquent\Model;

class VoteComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote_comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vote_id', 'item_id', 'user_id',
        'comment', 'comment_time', 'status'
    ];

    /**
     * Get the wxuser that owns the vote_log.
     */
//    public function wxuser()
//    {
//        return $this->belongsTo('App\Models\vote\Wxuser', 'user_id');
//    }

    /**
     * Get the candidate that publish the comment.
     */
    public function candidate () {
        return $this->belongsTo('App\Models\vote\Candidate', 'item_id');
    }
}