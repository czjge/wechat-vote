<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 11:07
 */
namespace App\Repositories\vote;

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
            202 => '投票未开始',
            203 => '选手状态异常',
            204 => '用户身份鉴定错误',

            205 => '今天已经投过票了',
            206 => '今天投票次数已用完',
            207 => '今天投票次数已用完,请明天再来',
            208 => '服务器忙，请稍后再试',
            209 => '请先关注四川名医微信公众号',

            210 => 'session失效',

            211 => '验证码错误',

            200 => '点赞成功',
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
        if (strtotime($vote->start_time)>time() ) {
            $retArr['code'] = 202;
            $retArr['msg'] = $codes[202];
            return $retArr;
        }
        
        // check if the vote is on.
        if (strtotime($vote->end_time)<time()) {
            $retArr['code'] = 202;
            $retArr['msg'] = '投票已结束';
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
        if(env('FORCE_SUBSCRIBE_VOTE')){
            if ($wxuser->subscribe !== 1) {
                $retArr['code'] = 209;
                $retArr['msg'] = $codes[209];
                return $retArr;
            }
        }

        // check 'throttle_vote_speed' and 'throttle_white_list':if 'throttle_vote_speed'
        // is not set to 0, candidates who are not in 'throttle_white_list' will be throttled
        // when voting.
        if ($vote->throttle_vote_speed != 0) {
            //if (! in_array($cid, unserialize($vote->throttle_white_list))) {
                $lastVote = $this->getLastVoteByCid($id, $cid);
                if ((time() - $lastVote->log_time) <= $vote->throttle_vote_speed) {
                    $retArr['code'] = 208;
                    $retArr['msg'] = $codes[208];
                    return $retArr;
                }
            //}
        }

        // check 'single_vote_status':one wxuser can only give one vote to a candidate per day.
        if ($vote->single_vote_status==1) {
            $todayVoteRecord = DB::table('vote_log')
                                    ->where('vote_id', '=', $id)
                                    ->where('item_id', '=', $cid)
                                    ->where('time_key', '=', $todayTime)
                                    ->where('user_id', '=', $wid)
                                    ->first();
            if ($todayVoteRecord) {
                $retArr['code'] = 205;
                $retArr['msg'] = $codes[205];
                return $retArr;
            }
        }

        // check 'daily_user_votes':the votes that a wxuser can give.
        $todayVoteCount = DB::table('vote_log')
                                ->where('vote_id', '=', $id)
                                ->where('user_id', '=', $wid)
                                ->where('time_key', '=', $todayTime)
                                ->count();
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
        if ($vote->start_limit_votes!=0 && $this->getTodayVoteNumByCid($id, $cid) > $vote->start_limit_votes) {
            if ($this->getVoteNumByTime($id, $cid, 5) > $vote->five_mins_limit) {
                DB::table('candidate')->where('id', '=', $cid)->update(['status'=>2]);
            }
        } else {
            if ($this->getVoteNumByTime($id, $cid, 5) > $vote->five_mins_limit) {
                DB::table('candidate')->where('id', '=', $cid)->update(['status'=>2]);
            }
        }


        // voting is successful.
        $data = [
            'vote_id' => $id,
            'item_id' => $cid,
            'user_id' => $wid,
            'time_key' => $todayTime,
            'log_time' => time(),
            'ip' => ip2long($this->getClientIp()),
        ];
        DB::table('vote_log')->insert($data);
        DB::table('candidate')->where('id', '=', $cid)->increment('num', 1);
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
        return DB::table('vote_log')
                        ->where('vote_id', '=', $id)
                        ->where('item_id', '=', $cid)
                        ->where('time_key', '=', strtotime(date('Y-m-d')))
                        ->count();
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
    protected function getVoteNumByTime ($id, $cid, $min) {
        return DB::table('vote_log')
                        ->where('vote_id', '=', $id)
                        ->where('item_id', '=', $cid)
                        ->where('log_time', '>', (time()-60*$min))
                        ->count();
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
        return DB::table('vote_log')
                        ->where('vote_id', '=', $id)
                        ->where('item_id', '=', $cid)
                        ->where('time_key', '=', strtotime(date('Y-m-d')))
                        ->orderBy('id', 'desc')
                        ->first();
    }
}