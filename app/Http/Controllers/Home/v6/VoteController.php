<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home\v6;

use App\Http\Controllers\HomeBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Overtrue\Wechat\Js;
use Illuminate\Support\Facades\Session;
use App\Repositories\vote\v6\VoteRepository as voteRep;
use App\Events\VotePageWasLoaded;
use App\Events\CandidatePageWasLoaded;
use App\Models\vote\Vote;
use App\Models\vote\Candidate;
use Cache;
use App\Extensions\Common;

class VoteController extends HomeBaseController
{
    use Common;

    private $indexListCacheKey = 'scmy.vote.index.list.6';
    private $rankListCacheKey = 'scmy.vote.rank.list.6';

    protected $voteRep;

    public function __construct(voteRep $voteRep) {

        $this->voteRep = $voteRep;

        parent::__construct();
    }

    public function getIndex (Request $request) {
        // this action(int) is a must, cuz "$id" is a string.
        $id = (int) $request->input('id');
        //$type = $request->input('type') ? (int) $request->input('type') : 0;
        $keywords = $request->input('keywords');

        $vote = Vote::findOrFail($id);


        // 选手列表
        $builder = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2]);
        if ($keywords) {
            $builder = $builder->where('name', 'like', '%'.$keywords.'%')->orWhere('of_hos', 'like', '%'.$keywords.'%');
        }

        // 排序方式
        if ($vote->index_sort_type == 1) {
            $builder = $builder->orderBy('no', 'desc');
        } elseif ($vote->index_sort_type == 2) {
            $builder = $builder->orderBy('no', 'asc');
        } elseif ($vote->index_sort_type == 3) {
            $builder = $builder->orderBy('num', 'desc')->orderBy('no', 'asc');
        } elseif ($vote->index_sort_type == 4) {
            $builder = $builder->orderBy(DB::raw('convert(name using gbk)'));
        } elseif ($vote->index_sort_type == 5) {
            $builder = $builder->orderBy('sort', 'desc');
        }

        // 获取列表
        if (env('USE_REDIS_CACHE')) {
            $candidates = Cache::store('redis')->remember($this->indexListCacheKey, env('REDIS_CACHE_TIME_INDEX'), function () use ($builder) {
                return $builder->get();
            });
        } else {
            $candidates = $builder->get();
        }

//        $perPage = config('home.pageNum');
//        if ($request->has('page')) {
//            $currentPage = $request->input('page');
//            $currentPage = $currentPage <= 0 ? 1 :$currentPage;
//        } else {
//            $currentPage = 1;
//        }
//        $item = array_slice($candidates, ($currentPage-1)*$perPage, $perPage);
//
//        $paginator = new LengthAwarePaginator($item, count($candidates), $perPage, $currentPage, [
//            'path'     => Paginator::resolveCurrentPath(),
//            'pageName' => 'page',
//        ]);
//
//        $candidates = $paginator->toArray()['data'];

//        foreach ($candidates as $key => $candidate) {
//            $candidates[$key]->desc = mb_substr($this->trimAll($candidate->desc), 0, 20, 'utf-8') . '...';
//        }



        // 总票数
        $votes_num = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->sum('num');

        // 总参赛选手数
        $candidates_num = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->count();

        event(new VotePageWasLoaded($vote));

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);



        return view('app.vote.'.$id.'.index', [
            'id'    => $id,
            //'type'  => $type,
            'vote'  => $vote,
            'candidatesNum' => $candidates_num,
            'votesNum'      => $votes_num ? $votes_num : 0,
            'candidates'    => $candidates,
            //'paginator'     => $paginator,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc'  => $vote->other_share_desc,
                'shareLogo'  => $vote->other_share_logo,
                'shareUrl'   => route('home.vote.getIndex'.$vote->id).'?id='.$vote->id,
            ],
        ]);
    }

    public function getInfo (Request $request, $cid) {
        $id = (int) $request->input('id');
        //$type = $request->input('type') ? (int) $request->input('type') : 0; // 和评论加载相关

        $vote = Vote::findOrFail($id);
        $candidate = Candidate::findOrFail($cid);
        $qian = ["\t","\n","\r"];
        $candidate->desc = str_replace($qian, '<br/>', $candidate->desc);
        //$candidate->desc_short = mb_substr($this->trimAll($candidate->desc), 0, 10, 'utf-8');

        $wid = Session::get('wxuserid_'.$id);
        $ajaxVoteUrl = route('home.vote.getDoVote'.$id, ['cid'=>$cid, 'wid'=>$wid]) . '?id=' . $id;
        //$reloadUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]) . '?id=' . $id.'&type='.$type;
        $reloadUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]) . '?id=' . $id;

        //评论部分
//        $ajax_comment_url = route('home.vote.getDoVoteComment'.$id, ['cid'=>$cid, 'wid'=>$wid]).'?id='.$id;
//        $comment_number = DB::table('vote_comment')->where('vote_id', '=', $id)->where('item_id', '=', $cid)->where('status', '=', 0)->count();
//        if ($type==1) {
//            $comment_list = DB::table('vote_comment')->where('vote_id', '=', $id)->where('item_id', '=', $cid)->where('status', '=', 0)->orderBy('comment_time', 'desc')->get();
//        } else {
//            $comment_list = DB::table('vote_comment')->where('vote_id', '=', $id)->where('item_id', '=', $cid)->where('status', '=', 0)->orderBy('comment_time', 'desc')->take(10)->get();
//        }
//        foreach ($comment_list as $k => $v) {
//            $user = DB::table('vote_wxuser')->where('id', '=', $v->user_id)->first();
//            if ($user) {
//                $comment_list[$k]->name = $user->nickname;
//                $comment_list[$k]->headimgurl = $user->headimgurl;
//            }
//        }

        // info_share_title:replace some default values.
        if (strpos($vote->info_share_title, '{NAME}') !== false) {
            $vote->info_share_title = str_replace('{NAME}', $candidate->name, $vote->info_share_title);
        }
        if (strpos($vote->info_share_title, '{NO}') !== false) {
            $vote->info_share_title = str_replace('{NO}', $candidate->no, $vote->info_share_title);
        }
        if (strpos($vote->info_share_title, '{HOS}') !== false) {
            $vote->info_share_title = str_replace('{HOS}', $candidate->of_hos, $vote->info_share_title);
        }

//        if ($type==0) {
//            $shareLogo = 'http://qiniu.langzoo.com/'.$candidate->pic_url;
//            $shareUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]).'?id='.$id.'&type='.$type;
//        } else {
//            $shareLogo =  'http://qiniu.langzoo.com/'.$candidate->doctor_avatar;
//            $shareUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]).'?id=1&type=1';
//        }
        // 红包链接
        $redpack_schedule = DB::table('redpack_schedule')->orderBy('id', 'desc')->first();
        if ($redpack_schedule) {
            $redpack_url = $redpack_schedule->redpack_url;
        } else {
            $redpack_url = false;
        }
        
        if ($vote->subscribe_vote_status==1) {
            $subscribe = Session::get('subscribe_'.$id);
        } else {
            $subscribe = 1;
        }

        // total clicks.
        event(new VotePageWasLoaded($vote));

        // candidate clicks.
        event(new CandidatePageWasLoaded($candidate));

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);

        // 祝福语
        $wish_words = '2018新年即将到来，四川名医联合全川医院20多名院长特别推出“2018·院长拜年”活动！本次活动，四川名医将邀请到四川大学华西医院、四川省肿瘤医院等20多家医院院长为大家送新春祝福，四川名医为了回馈粉丝，也将在春节期间为大家发放新春红包！';
        
        return view('app.vote.'.$id.'.info', [
            'id'   => $id,
            //'type' => $type,
            'vote' => $vote,
            'wish_words' => $wish_words,
            'candidate'        => $candidate,
            'subscribe'        => $subscribe,
            'ajaxVoteUrl'      => $ajaxVoteUrl,
            'reloadUrl'        => $reloadUrl,
            'redpack_url'      => $redpack_url,
//            'ajax_comment_url' => $ajax_comment_url,
//            'comment_number'   => $comment_number,
//            'comment_list'     => $comment_list,
            'wxJssdkConfig'    => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->info_share_title,
                'shareDesc'  => $vote->info_share_desc,
                //'shareLogo'  => $shareLogo,
                //'shareUrl'   => $shareUrl,
                'shareLogo'  => $vote->other_share_logo,
                //'shareUrl'   => route('home.vote.getInfo'.$id, ['cid'=>$cid]).'?id='.$id.'&type='.$type,
                'shareUrl'   => route('home.vote.getInfo'.$id, ['cid'=>$cid]).'?id='.$id,
            ],
        ]);
    }

    public function getRank (Request $request) {
        $id = (int) $request->input('id');
	    //$type = $request->input('type') ? (int)$request->input('type') : 0;

        $vote = Vote::findOrFail($id);

        // 获取列表
        if (env('USE_REDIS_CACHE')) {
            $rank_list = Cache::store('redis')->remember($this->rankListCacheKey, env('REDIS_CACHE_TIME_RANK'), function () use ($vote, $id) {
                return DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0,2])->orderBy('num', 'desc')->take($vote->rank_num)->get();
            });
        } else {
            $rank_list = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0,2])->orderBy('num', 'desc')->take($vote->rank_num)->get();
        }

        foreach ($rank_list as $k => $v) {
            $rank_list[$k]->url = route('home.vote.getInfo'.$v->vote_id, ['cid'=>$v->id]) . '?id=' . $id;
        }

        // total clicks.
        event(new VotePageWasLoaded($vote));

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);



        return view('app.vote.'.$id.'.rank', [
            //'type' => $type,
            'vote' => $vote,
            'rankList'      => $rank_list,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc'  => $vote->other_share_desc,
                'shareLogo'  => $vote->other_share_logo,
                'shareUrl'   => route('home.vote.getRank'.$vote->id).'?id='.$vote->id,
            ],
        ]);
    }

    public function getDoVote (Request $request, $cid, $wid) {
        $id = (int) $request->input('id');
        $captcha = $request->input('captcha_code');

        // can you believe it?! $id, $cid, $wid , they are all strings!!!
        $retArr = $this->voteRep->ajaxVote($id, (int) $cid, (int) $wid, $captcha);


        return response()->json($retArr);
    }

    protected function getJssdkConfig ($id) {
        $vote = DB::table('vote')->where('id', '=', $id)->first();

        // js-sdk, which will be persisted for 7200s.
        $wechatJs = new Js($vote->appid, $vote->appsecret);
        $jsApiList = ['hideAllNonBaseMenuItem', 'showMenuItems', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ'];
        return $wechatJs->config($jsApiList);
    }

    public function getRegister (Request $request) {
        $id = (int) $request->input('id');

        $vote = Vote::findOrFail($id);

        // total clicks.
        event(new VotePageWasLoaded($vote));


        return view('app.vote.'.$id.'.register', [
            'vote' => $vote
        ]);
    }

    public function getDoRegister (Request $request) {
        $voteId = (int) $request->input('id');
        $picUrl = $request->input('picurl');
        $phone = $request->input('phone');

        $duplicateItem = DB::table('candidate')->where('vote_id', '=', $voteId)->where('phone', '=', $phone)->where('status', '=', 0)->first();
        if ($duplicateItem && ! empty($duplicateItem->tel)) {
            return response()->json(3);
        }

        $vote = DB::table('vote')->where('id', '=', $voteId)->first();
        $data = $request->except(['id', 'picurl']);

        $data['no'] = (DB::table('candidate')->where('vote_id', '=', $voteId)->max('no'))+1;
        $data['status'] = $vote->audit_status == 0 ? 0 : 1;
        $data['pic_url'] = $picUrl;
        $data['vote_id'] = $voteId;

        if (DB::table('candidate')->insert($data)) {
            if ($vote->audit_status == 0) {
                return response()->json(1);
            } else {
                return response()->json(2);
            }
        } else {
            return response()->json(0);
        }
    }

    public function getLog (Request $request) {
        $vote_id = (int) $request->input('id');
        $vote = Vote::findOrFail($vote_id);
        $todayTime = strtotime(date('Y-m-d'));
        $wid = Session::get('wxuserid_'.$vote_id);


        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
            $vote_log_table_name = 'vote_log_' . $vote_log_table_suffix;
            $logList = DB::table('candidate')
                ->leftJoin($vote_log_table_name, 'candidate.id', '=', $vote_log_table_name.'.item_id')
                ->where($vote_log_table_name.'.user_id', '=', $wid)
                ->where('candidate.vote_id', '=', $vote_id)
                ->where($vote_log_table_name.'.time_key', '=', $todayTime)
                ->select(
                    'candidate.name as name',
                    'candidate.id as id',
                    $vote_log_table_name.'.log_time as time',
                    'candidate.of_dep as of_dep',
                    'candidate.no as no'
                ) ->get();
        } else {
            $logList = DB::table('candidate')
                ->leftJoin('vote_log', 'candidate.id', '=', 'vote_log.item_id')
                ->where('vote_log.user_id', '=', $wid)
                ->where('candidate.vote_id', '=', $vote_id)
                ->where('vote_log.time_key', '=', $todayTime)
                ->select(
                    'candidate.name as name',
                    'candidate.id as id',
                    'vote_log.log_time as time',
                    'candidate.of_dep as of_dep',
                    'candidate.no as no'
                ) ->get();
        }

        // total clicks.
        event(new VotePageWasLoaded($vote));

        $wxJssdkConfig = $this->getJssdkConfig($vote_id);


               
        return view('app.vote.'.$vote_id.'.log', [
            'id'       => $vote_id,
            'logList' => $logList,
            'vote'     => $vote,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc'  => $vote->other_share_desc,
                'shareLogo'  => $vote->other_share_logo,
                'shareUrl'   => route('home.vote.getIndex'.$vote->id).'?id='.$vote->id,
            ],
        ]);
    }

    public function getDoVoteComment (Request $request, $cid, $wid) {
        $id = (int) $request->input('id');
        $comment = $request->input('comment');

        $data = array(
            'vote_id'      => $id,
            'item_id'      => $cid,
            'user_id'      => $wid,
            'comment_time' => time(),
            'status'       => 1,
            'comment'      => $comment,
            'created_at'=> date('Y-m-d H:i:s',time())
        );

        $retArr = ['code' => '', 'msg' => ''];

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        $candidate = DB::table('candidate')->where('id', '=', $cid)->first();
        $wxuser = DB::table('vote_wxuser')->where('id', '=', $wid)->first();

        // check if these entities exist.
        if (! $vote || ! $candidate || ! $wxuser) {
            $retArr['code'] = 201;
            $retArr['msg'] = '评论对象错误';
            return $retArr;
        }

        // check if the vote is on.
        if (strtotime($vote->start_time)>time() || strtotime($vote->end_time)<time()) {
            $retArr['code'] = 202;
            $retArr['msg'] = '评论未开始或已结束';
            return $retArr;
        }

        // check candidate's status.
        if ($candidate->status !== 0) {
            $retArr['code'] = 203;
            $retArr['msg'] = '选手状态异常';
            return $retArr;
        }

        if (DB::table('vote_comment')->insert($data)){
            $retArr['code'] = 200;
            $retArr['msg'] = '评论成功,请等待管理员审核…';
        }

        return response()->json($retArr);
    }

}