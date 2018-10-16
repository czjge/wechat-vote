<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\HomeBaseController;
use App\Exceptions\TableRowNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Overtrue\Wechat\Js;
use Illuminate\Support\Facades\Session;
use App\Repositories\vote\VoteRepository as voteRep;

class VoteController extends HomeBaseController
{

    protected $voteRep;

    public function __construct(voteRep $voteRep) {

        $this->voteRep = $voteRep;

        parent::__construct();
    }

    public function getIndex (Request $request) {
        $id = (int) $request->input('id');
        $type = (int) $request->input('type'); // 0

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        if (! $vote) {
            throw new TableRowNotFoundException('没有该投票');
        }

        $keywords = $request->input('keywords');


        // 总票数
        $votesNum = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->sum('num');

        // 选手列表
        if ($keywords) {
            $builder = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->where('name', 'like', '%'.$keywords.'%');
        } else {
            $builder = DB::table('candidate')->where('vote_id', '=', $id)->where('type', '=', $type)->whereIn('status', [0, 2]);
        }
        // 排序方式
        if ($vote->index_sort_type == 1) {
            $builder = $builder->orderBy('no', 'desc');
        } elseif ($vote->index_sort_type == 2) {
            $builder = $builder->orderBy('no', 'asc');
        } elseif ($vote->index_sort_type == 3) {
            $builder = $builder->orderBy('num', 'desc');
        }
        $candidates = $builder->get();

        $perPage = config('home.pageNum');
        if ($request->has('page')) {
            $currentPage = $request->input('page');
            $currentPage = $currentPage <= 0 ? 1 :$currentPage;
        } else {
            $currentPage = 1;
        }
        $item = array_slice($candidates, ($currentPage-1)*$perPage, $perPage);
        $total = count(DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->get());

        $paginator = new LengthAwarePaginator($item, count($candidates), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        $candidates = $paginator->toArray()['data'];


        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);


        return view('app.vote.'.$id.'.index', [
            'vote' => $vote,
            'candidatesNum' => $total,
            'votesNum' => $votesNum,
            'candidates' => $candidates,
            'paginator' => $paginator,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc' => $vote->other_share_desc,
                'shareLogo' => $vote->other_share_logo,
                'shareUrl' => route('home.vote.getIndex').'?id='.$vote->id,
            ],
        ]);
    }

    public function getInfo (Request $request, $cid) {
        $id = (int) $request->input('id');

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        $candidate = DB::table('candidate')->where('id', '=', $cid)->first();

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);

        // do-voting url.
        $wid = Session::get('wxuserid_'.$id);
        $ajaxVoteUrl = route('home.vote.getDoVote', ['cid'=>$cid, 'wid'=>$wid]) . '?id=' . $id;
        $reloadUrl = route('home.vote.getInfo', ['cid'=>$cid]) . '?id=' . $id;

        // candidate clicks.
        DB::table('candidate')->where('id', '=', $cid)->increment('clicks', 1);

        // info_share_title:replace some default values.
        if (strpos($vote->info_share_title, '{NAME}') !== false) {
            $vote->info_share_title = str_replace('{NAME}', $candidate->name, $vote->info_share_title);
        }
        if (strpos($vote->info_share_title, '{NO}') !== false) {
            $vote->info_share_title = str_replace('{NO}', $candidate->no, $vote->info_share_title);
        }

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);


        return view('app.vote.'.$id.'.info', [
            'vote' => $vote,
            'candidate' => $candidate,
            'subscribe' => Session::get('subscribe_'.$id),
            'ajaxVoteUrl' => $ajaxVoteUrl,
            'reloadUrl' => $reloadUrl,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->info_share_title,
                'shareDesc' => $vote->info_share_desc,
                'shareLogo' => $candidate->pic_url,
                'shareUrl' => route('home.vote.getInfo', ['cid'=>$candidate->id]).'?id='.$vote->id,
            ],
        ]);
    }

    public function getRank (Request $request) {
        $id = (int) $request->input('id');

        $vote = DB::table('vote')->where('id', '=', $id)->first();

        $rankList = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0,2])->where('type', '=', 0)->orderBy('num', 'desc')->take($vote->rank_num)->get();
        foreach ($rankList as $k => $v) {
            $rankList[$k]->url = route('home.vote.getInfo', ['cid'=>$v->id]) . '?id=' . $v->vote_id;
        }

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);


        return view('app.vote.'.$id.'.rank', [
            'vote' => $vote,
            'rankList' => $rankList,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc' => $vote->other_share_desc,
                'shareLogo' => $vote->other_share_logo,
                'shareUrl' => route('home.vote.getRank').'?id='.$vote->id,
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

        $vote = DB::table('vote')->where('id', '=', $id)->first();

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);


        return view('app.vote.'.$id.'.register', ['vote'=>$vote]);
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

}