<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home\v18;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Overtrue\Wechat\Js;
use App\Http\Controllers\HomeBaseController;
use App\Repositories\vote\v18\VoteRepository as voteRep;
use App\Events\VotePageWasLoaded;
use App\Events\CandidatePageWasLoaded;
use App\Models\vote\Vote;
use App\Models\vote\Candidate;
use App\Extensions\Common;
use App\Models\vote\FieldValue;


class VoteController extends HomeBaseController
{

    use Common;

    private $indexListCacheKey = 'scmy.vote.index.list.18';
    private $rankListCacheKey = 'scmy.vote.rank.list.18';
    protected $voteRep;

    public function __construct(voteRep $voteRep) {

        $this->voteRep = $voteRep;

        parent::__construct();
    }

    public function getIndex (Request $request) {
        // this action(int) is a must, cuz "$id" is a string.
        $id = (int) $request->input('id');
        $keywords = $request->input('keywords');

        $vote = Vote::findOrFail($id);


        // 选手列表
        $builder = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2]);
        // 只搜索医生姓名(vote表里面的字段)
        if ($keywords) {
            $builder = $builder->where('name', 'like', '%'.$keywords.'%');
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

        // 添加额外字段
        foreach ($candidates as $key => $candidate) {
            $extend_field_values = FieldValue::where('candidate_id', '=', $candidate->id)->first();
            if ($extend_field_values) {
                $extend_field_values_arr = unserialize($extend_field_values->values);
                foreach ($extend_field_values_arr as $k => $extend_field_values_item) {
                    $candidate->$k = $extend_field_values_item;
                }
            }
        }

        // 如果需要按照医院或者科室搜索(非vote表里面的字段)
//        if ($keywords) {
//            foreach ($candidates as $key => $candidate) {
//                // 具体搜索哪些字段看具体情况
//                if (strpos($candidate->name, $keywords) === false
//                    && strpos($candidate->hospital, $keywords) === false
//                    && strpos($candidate->department, $keywords) === false) {
//                    unset($candidates[$key]);
//                }
//            }
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
            'vote'  => $vote,
            'candidatesNum' => $candidates_num,
            'votesNum'      => $votes_num ? $votes_num : 0,
            'candidates'    => $candidates,
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

        $vote = Vote::findOrFail($id);
        $candidate = Candidate::findOrFail($cid);
        if ($candidate->vote_id !== $id) {
            abort(403);
        }

        $wid = Session::get('wxuserid_'.$id);
        //$wid = 1;
        $ajaxVoteUrl = route('home.vote.getDoVote'.$id, ['cid'=>$cid, 'wid'=>$wid]) . '?id=' . $id;
        $reloadUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]) . '?id=' . $id;

        // info_share_title:replace some default values.
        if (strpos($vote->info_share_title, '{NAME}') !== false) {
            $vote->info_share_title = str_replace('{NAME}', $candidate->name, $vote->info_share_title);
        }
        if (strpos($vote->info_share_title, '{NO}') !== false) {
            $vote->info_share_title = str_replace('{NO}', $candidate->no, $vote->info_share_title);
        }

        if ($vote->subscribe_vote_status == 1) {
            $subscribe = Session::get('subscribe_'.$id);
        } else {
            $subscribe = 1;
        }

        event(new VotePageWasLoaded($vote));
        event(new CandidatePageWasLoaded($candidate));

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);


        return view('app.vote.'.$id.'.info', [
            'id'   => $id,
            'vote' => $vote,
            'candidate'        => $candidate,
            'subscribe'        => $subscribe,
            'ajaxVoteUrl'      => $ajaxVoteUrl,
            'reloadUrl'        => $reloadUrl,
            'wxJssdkConfig'    => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->info_share_title,
                'shareDesc'  => $vote->info_share_desc,
                'shareLogo'  => $vote->other_share_logo,
                'shareUrl'   => route('home.vote.getInfo'.$id, ['cid'=>$cid]).'?id='.$id,
            ],
        ]);
    }

    public function getRank (Request $request) {
        $id = (int) $request->input('id');

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

        event(new VotePageWasLoaded($vote));

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);



        return view('app.vote.'.$id.'.rank', [
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
                    'candidate.no as no'
                ) ->get();
        }

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

    public function getTheme1(Request $request)
    {
        $vote_id = (int) $request->input('id');
        $vote = Vote::findOrFail($vote_id);

        event(new VotePageWasLoaded($vote));

        $wxJssdkConfig = $this->getJssdkConfig($vote_id);


        return view('app.vote.'.$vote_id.'.theme1', [
            'id'       => $vote_id,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc'  => $vote->other_share_desc,
                'shareLogo'  => $vote->other_share_logo,
                'shareUrl'   => route('home.vote.getTheme1'.$vote->id).'?id='.$vote->id,
            ],
        ]);
    }

    public function getTheme2(Request $request)
    {
        $vote_id = (int) $request->input('id');
        $vote = Vote::findOrFail($vote_id);

        event(new VotePageWasLoaded($vote));

        $wxJssdkConfig = $this->getJssdkConfig($vote_id);


        return view('app.vote.'.$vote_id.'.theme2', [
            'id'       => $vote_id,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc'  => $vote->other_share_desc,
                'shareLogo'  => $vote->other_share_logo,
                'shareUrl'   => route('home.vote.getTheme2'.$vote->id).'?id='.$vote->id,
            ],
        ]);
    }

    public function getRegister (Request $request) {
        $id = (int) $request->input('id');
        $vote = Vote::findOrFail($id);

        event(new VotePageWasLoaded($vote));


        return view('app.vote.'.$id.'.register', [
            'vote' => $vote,
        ]);
    }

    public function getDoRegister (Request $request) {
        //dd($request->all());
        $vote_id = (int) $request->input('id');

//        $duplicateItem = DB::table('candidate')->where('vote_id', '=', $voteId)->where('phone', '=', $phone)->where('status', '=', 0)->first();
//        if ($duplicateItem && ! empty($duplicateItem->tel)) {
//            return response()->json(3);
//        }

        $vote = DB::table('vote')->where('id', '=', $vote_id)->first();
        $data = $request->except(['id']);

        $data['no'] = (DB::table('candidate')->where('vote_id', '=', $vote_id)->max('no'))+1;
        $data['status'] = $vote->audit_status == 0 ? 0 : 1;
        $data['vote_id'] = $vote_id;

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

}