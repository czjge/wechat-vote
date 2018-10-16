<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 11:07
 */
namespace App\Repositories\vote\v20;

use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Extensions\Common;
use App\Extensions\captcha\Verify;

class VoteRepository extends Repository
{
    use Common;

    public function model() {
        return 'App\Models\vote\Vote';
    }

    /**
     * wxuser do ajax vote.
     * @param int $id
     * @param int $cid
     * @param int $wid
     * @param string $captcha
     * @return array
     * @author wangjiang <1159617259@qq.com>
     * @date 2016-11-23 11:00
     * @copyright 2016-2017 CDSB.com Inc. All Rights Reserved
     */
    public function ajaxVote ($id, $cid, $wid, $captcha=null) {
        $openid = Session::get('openid_'.$id, '');
        $wxuserid = Session::get('wxuserid_'.$id, '');
        $todayTime = strtotime(date('Y-m-d'));

        $retArr = ['code' => '', 'msg' => '', 'vote_num' => ''];

        $codes = [
            201 => 'id对应实体不存在',
            2021 => '未开始',
            2022 => '已结束',
            203 => '选手状态异常',
            204 => '用户身份鉴定错误',

            205 => '今天已经送过花了',
            206 => '今天送花次数已用完',
            207 => '今天选手送花数已满',
            208 => '服务器忙，请稍后再试',
            209 => '请先点右下角关注',

            210 => 'session失效',

            211 => '验证码错误',

            212 => '该时间段不允许送花',

            200 => '送花成功',
        ];

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        $candidate = DB::table('candidate')->where('id', '=', $cid)->first();
        $wxuser = DB::table('vote_wxuser')->where('id', '=', $wid)->first();

        // check if captcha is on.
        if ($vote->captcha_status == 1) {
            $verify = new Verify();
            // verify captcha code
            if (! $verify->check($captcha)) {
                $retArr['code'] = 211;
                $retArr['msg'] = $codes[211];
                return $retArr;
            }
        }

        // check if session has expired.
        if ($openid == '' || $wxuserid == '') {
            $retArr['code'] = 210;
            $retArr['msg'] = 'session失效';
            return $retArr;
        }

        // check if these entities exist.
        if (! $vote || ! $candidate || ! $wxuser) {
            $retArr['code'] = 201;
            $retArr['msg'] = '投票错误';
            return $retArr;
        }

        // check if the vote is on.
        if (strtotime($vote->start_time)>time()) {
            $retArr['code'] = 2021;
            $retArr['msg'] = $codes[2021];
            return $retArr;
        }
        if (strtotime($vote->end_time)<time()) {
            $retArr['code'] = 2022;
            $retArr['msg'] = $codes[2022];
            return $retArr;
        }

        // check candidate's status.
        if ($candidate->status !== 0) {
            $retArr['code'] = 203;
            $retArr['msg'] = $codes[203];
            return $retArr;
        }

        // retrieve wxuser by openid and check if it matches.
        $wxuserByOpenid = DB::table('vote_wxuser')->where('openid', '=', $openid)->first();
        if (! $wxuserByOpenid || $wxuser->openid !== $openid) {
            $retArr['code'] = 204;
            $retArr['msg'] = '投票错误';
            return $retArr;
        }

        // check if wxuserid in the session matches the wid in the argument.
        if ($wxuserid !== $wid) {
            $retArr['code'] = 204;
            $retArr['msg'] = '投票错误';
            return $retArr;
        }

        // check if wxuser has subscribed.
        if ($vote->subscribe_vote_status==1) {
            if ($wxuser->subscribe !== 1) {
                $retArr['code'] = 209;
                $retArr['msg'] = $codes[209];
                return $retArr;
            }
        }

        // check if allow to vote during the period time
        if ($vote->vote_start_time!=''&&$vote->vote_end_time!='') {
            $day_time = date('H:i:s', time());
            if ($vote->vote_start_time>$day_time || $day_time>$vote->vote_end_time) {
                $retArr['code'] = 212;
                $retArr['msg'] = $codes[212];
                return $retArr;
            }
        }

        // check 'throttle_vote_speed' and 'throttle_white_list':if 'throttle_vote_speed'
        // is not set to 0, candidates who are not in 'throttle_white_list' will be throttled
        // when voting.
        if ($vote->throttle_vote_speed!=0) {
            $throttle_check_flag = false;
            if (unserialize($vote->throttle_white_list)===false || ! in_array($cid, unserialize($vote->throttle_white_list))) {
                // all candidates will be throttled
                $throttle_check_flag = true;
            }
            if ($throttle_check_flag) {
                $lastVote = $this->getLastVoteByCid($id, $cid);
                // caution: $lastVote may be null
                if ($lastVote&&((time() - $lastVote->log_time) <= $vote->throttle_vote_speed)) {
                    $retArr['code'] = 208;
                    $retArr['msg'] = $codes[208];
                    return $retArr;
                }
            }
        }

        // check 'single_vote_status':one wxuser can only give one vote to a candidate per day.
        if ($vote->single_vote_status==1) {
            $todayVoteRecord = $this->getTodayVoteRecord($id, $cid, $wid);
            if ($todayVoteRecord) {
                $retArr['code'] = 205;
                $retArr['msg'] = $codes[205];
                return $retArr;
            }
        }

        // check 'daily_user_votes':the votes that a wxuser can give.
        $todayVoteCount = $this->getTodayVoteNumByWid($id, $wid);
        if ($todayVoteCount>=$vote->daily_user_votes) {
            $retArr['code'] = 206;
            $retArr['msg'] = $codes[206];
            return $retArr;
        }

        // check 'daily_max_votes':the votes that a candidate can receive per day.
        // further more, we can set 'daily_max_votes' for each candidate,
        // if a candidate's 'daily_max_votes' is not set, we just use the
        // default value.
        // TODO 'five_mins_limit' 'start_limit_votes' etc.
        if ($this->getTodayVoteNumByCid($id, $cid) > ($candidate->daily_max_votes != 0 ? : $vote->daily_max_votes)) {
            $retArr['code'] = 207;
            $retArr['msg'] = $codes[207];
            return $retArr;
        }

        // check 'start_limit_votes' and 'five_mins_limit':if 'start_limit_votes' is set to 0,
        // the 'five_mins_limit' constrain will always work, otherwise it should only work when
        // the number of votes exceed 'start_limit_votes' constrain.
        if ($vote->start_limit_votes==0) {
            if ($this->getVoteNumByTime($id, $cid, 5) > $vote->five_mins_limit) {
                DB::table('candidate')->where('id', '=', $cid)->update(['status'=>2]);
            }
        }
        if ($vote->start_limit_votes!=0 && $this->getTodayVoteNumByCid($id, $cid) > $vote->start_limit_votes) {
            if ($this->getVoteNumByTime($id, $cid, 5) > $vote->five_mins_limit) {
                DB::table('candidate')->where('id', '=', $cid)->update(['status'=>2]);
            }
        }


        // voting is successful.
        DB::beginTransaction();
        $data = [
            'vote_id' => $id,
            'item_id' => $cid,
            'user_id' => $wid,
            'time_key' => $todayTime,
            'log_time' => time(),
            'ip' => ip2long($this->getClientIp()),
        ];
        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
            $vote_log_table_name = 'vote_log_' . $vote_log_table_suffix;
            $vote_log_insert_result = DB::table($vote_log_table_name)->insert($data);
        } else {
            $vote_log_insert_result = DB::table('vote_log')->insert($data);
        }
        if ($vote_log_insert_result) {
            if (DB::table('candidate')->where('id', '=', $cid)->increment('num', 1)) {
                DB::commit();
            } else {
                DB::rollBack();
                $retArr['code'] = 208;
                $retArr['msg'] = $codes[208];
                return $retArr;
            }
        } else {
            DB::rollBack();
            $retArr['code'] = 208;
            $retArr['msg'] = $codes[208];
            return $retArr;
        }

        // return the message.
        $candidate = DB::table('candidate')->where('id', '=', $cid)->first();
        //DB::table('vote_15_brand')->where('id', '=', $candidate->rank)->increment('num', 1);
        $retArr['code'] = 200;
        $retArr['msg'] = $codes[200];
        $retArr['vote_num'] = $candidate->num;
        return $retArr;
    }

    /**
     * try to get the number of votes of a candidate of today.
     * @param int $id
     * @param int $cid
     * @return int
     * @author wangjiang <1159617259@qq.com>
     * @date 2016-11-23 14:05
     * @copyright 2016-2017 CDSB.com Inc. All Rights Reserved
     */
    protected function getTodayVoteNumByCid ($id, $cid) {
        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $vote = DB::table('vote')->where('id', '=', $id)->first();
            $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
            $vote_log_table_name = 'vote_log_' . $vote_log_table_suffix;
            return DB::table($vote_log_table_name)
                ->where('vote_id', '=', $id)
                ->where('item_id', '=', $cid)
                ->where('time_key', '=', strtotime(date('Y-m-d')))
                ->count();
        } else {
            return DB::table('vote_log')
                ->where('vote_id', '=', $id)
                ->where('item_id', '=', $cid)
                ->where('time_key', '=', strtotime(date('Y-m-d')))
                ->count();
        }
    }

    /**
     * try to get the number of votes of a candidate in last X mins.
     * @param int $id
     * @param int $cid
     * @param int $min
     * @return int
     * @author wangjiang <1159617259@qq.com>
     * @date 2016-11-23 14:41
     * @copyright 2016-2017 CDSB.com Inc. All Rights Reserved
     */
    /*
     *  1                 2        2           3         3
     *  1                 1,2      2           2,3       3
     *
     * |------------------|--------------------|-------------------|
     *  _|                _|       _|          _|        _|
     *
     *
     *
     */
    protected function getVoteNumByTime ($id, $cid, $min) {
        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $vote = DB::table('vote')->where('id', '=', $id)->first();
            $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
            $vote_log_table_name = 'vote_log_' . $vote_log_table_suffix;

            $a = time()-60*$min;
            $b = strtotime($vote->start_time)+($vote_log_table_suffix-1)*86400;
            if ($vote_log_table_suffix==1) {
                return DB::table($vote_log_table_name)
                    ->where('vote_id', '=', $id)
                    ->where('item_id', '=', $cid)
                    ->where('log_time', '>', (time()-60*$min))
                    ->count();
            } else {
                if ($a>=$b) {
                    return DB::table($vote_log_table_name)
                        ->where('vote_id', '=', $id)
                        ->where('item_id', '=', $cid)
                        ->where('log_time', '>', (time()-60*$min))
                        ->count();
                } else {
                    $vote_log_table_name_prev = 'vote_log_' . ($vote_log_table_suffix-1);
                    $count1 = DB::table($vote_log_table_name)
                        ->where('vote_id', '=', $id)
                        ->where('item_id', '=', $cid)
                        ->where('log_time', '>', $b)
                        ->where('log_time', '<', time())
                        ->count();
                    $count2 = DB::table($vote_log_table_name_prev)
                        ->where('vote_id', '=', $id)
                        ->where('item_id', '=', $cid)
                        ->where('log_time', '>', $a)
                        ->where('log_time', '<', $b)
                        ->count();
                    return ($count1+$count2);
                }
            }
        } else {
            return DB::table('vote_log')
                ->where('vote_id', '=', $id)
                ->where('item_id', '=', $cid)
                ->where('log_time', '>', (time()-60*$min))
                ->count();
        }
    }

    /**
     * try to get the last vote of a candidate.
     * @param int $id
     * @param int $cid
     * @return mixed
     * @author wangjiang <1159617259@qq.com>
     * @date 2016-11-23 15:00
     * @copyright 2016-2017 CDSB.com Inc. All Rights Reserved
     */
    protected function getLastVoteByCid ($id, $cid) {
        if (env('VOTE_LOG_SPLIT_TABLE')) {
            // 先查当天的投票记录，如果查到了就返回；
            // 反之则查询前一天的投票记录表并返回。
            // 注意：如果前一天仍没投票记录（小概率），则返回null，同样不会被限速。
            $vote = DB::table('vote')->where('id', '=', $id)->first();
            $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
            $vote_log_table_name = 'vote_log_' . $vote_log_table_suffix;

            $a = DB::table($vote_log_table_name)
                    ->where('vote_id', '=', $id)
                    ->where('item_id', '=', $cid)
                    //->where('time_key', '=', strtotime(date('Y-m-d')))
                    ->orderBy('id', 'desc')
                    ->first();
            if ($a) {
                return $a;
            } else {
                $vote_log_table_name_prev = 'vote_log_' . ($vote_log_table_suffix-1);
                return DB::table($vote_log_table_name_prev)
                            ->where('vote_id', '=', $id)
                            ->where('item_id', '=', $cid)
                            //->where('time_key', '=', strtotime(date('Y-m-d')))
                            ->orderBy('id', 'desc')
                            ->first();
            }
        } else {
            return DB::table('vote_log')
                ->where('vote_id', '=', $id)
                ->where('item_id', '=', $cid)
                //->where('time_key', '=', strtotime(date('Y-m-d')))
                ->orderBy('id', 'desc')
                ->first();
        }
    }

    public function getTodayVoteRecord ($id, $cid, $wid) {
        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $vote = DB::table('vote')->where('id', '=', $id)->first();
            $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
            $vote_log_table_name = 'vote_log_' . $vote_log_table_suffix;

            return DB::table($vote_log_table_name)
                        ->where('vote_id', '=', $id)
                        ->where('item_id', '=', $cid)
                        ->where('time_key', '=', strtotime(date('Y-m-d')))
                        ->where('user_id', '=', $wid)
                        ->first();
        } else {
            return DB::table('vote_log')
                            ->where('vote_id', '=', $id)
                            ->where('item_id', '=', $cid)
                            ->where('time_key', '=', strtotime(date('Y-m-d')))
                            ->where('user_id', '=', $wid)
                            ->first();
        }
    }

    public function getTodayVoteNumByWid ($id, $wid) {
        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $vote = DB::table('vote')->where('id', '=', $id)->first();
            $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
            $vote_log_table_name = 'vote_log_' . $vote_log_table_suffix;

            return DB::table($vote_log_table_name)
                        ->where('vote_id', '=', $id)
                        ->where('user_id', '=', $wid)
                        ->where('time_key', '=', strtotime(date('Y-m-d')))
                        ->count();
        } else {
            return DB::table('vote_log')
                        ->where('vote_id', '=', $id)
                        ->where('user_id', '=', $wid)
                        ->where('time_key', '=', strtotime(date('Y-m-d')))
                        ->count();
        }
    }

}