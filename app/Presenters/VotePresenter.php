<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-11
 * Time: 11:31
 */

namespace App\Presenters;

use App\Models\vote\Vote;

class VotePresenter
{
    public function showStatus (Vote $vote)
    {
        if (time() < strtotime($vote->start_time)) {
            return '<span class="label label-info">未开始</span>';
        } elseif (time() < strtotime($vote->end_time)) {
            return '<span class="label label-success">进行中</span>';
        } else {
            return '<span class="label label-warning">已结束</span>';
        }
    }
}