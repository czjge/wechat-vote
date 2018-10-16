<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home\v15;

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
        
        //品牌分类
//        $ranks = (int) $request->input('rank');
//        $rank = $ranks<2?1:$ranks;
//        $rankList = DB::table('vote_15_brand')->where('status', '=','0')->get();

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        if (! $vote) {
            throw new TableRowNotFoundException('没有该投票');
        }

        //$keywords = $request->input('keywords');


        // 总票数
        $votesNum = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->sum('num');

        // 选手列表
//        if ($keywords) {
//            $builder = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->where('name', 'like', '%'.$keywords.'%');
//        } else {
//            $builder = DB::table('candidate')->where('vote_id', '=', $id)->where('type', '=', $type)->whereIn('status', [0, 2])->where('rank', '=', $rank);
//        }
        $builder = DB::table('vote_15_brand')->where('status', '=','0');
        // 排序方式
        if (strtotime($vote->start_time)>time()) {
            $builder = $builder->orderBy('yaodian', 'dasc');
        }else{
            $builder = $builder->orderBy('num', 'desc')->orderBy('yaodian', 'dasc');
        }
        
        $brands = $builder->get();

        $perPage = config('home.pageNum');
        if ($request->has('page')) {
            $currentPage = $request->input('page');
            $currentPage = $currentPage <= 0 ? 1 :$currentPage;
        } else {
            $currentPage = 1;
        }
        $item = array_slice($brands, ($currentPage-1)*$perPage, $perPage);
        $total = count(DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->get());

        $paginator = new LengthAwarePaginator($item, count($brands), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        $brands = $paginator->toArray()['data'];


        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);


        return view('app.vote.'.$id.'.index', [
            'id'=>$id,
            'vote' => $vote,
            'candidatesNum' => $total,
            'votesNum' => $votesNum,
            'brands' => $brands,
            'paginator' => $paginator,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc' => $vote->other_share_desc,
                'shareLogo' => $vote->other_share_logo,
                'shareUrl' => route('home.vote.getIndex'.$id).'?id='.$vote->id,
            ],
        ]);
    }

    public function getInfo (Request $request, $cid) {
        $id = (int) $request->input('id');
        $type = (int) $request->input('type');

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        $candidate = DB::table('candidate')->where('id', '=', $cid)->first();
        $brand = DB::table('vote_15_brand')->where('status', '=','0')->where('id', '=',$type)->first();
        
        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);

        // do-voting url.
        $wid = Session::get('wxuserid_'.$id);
        $ajaxVoteUrl = route('home.vote.getDoVote'.$id, ['cid'=>$cid, 'wid'=>$wid]) . '?id=' . $id;
        $reloadUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]) . '?id=' . $id;
        
        //评论部分
        $ajaxCommentUrl = route('home.vote.getDoVoteComment'.$id, ['cid'=>$cid, 'wid'=>$wid]) . '?id=' . $id;
        $commetNumber = DB::table('vote_comment')->where('vote_id', '=', $id)->where('item_id', '=', $cid)->where('status', '=', 0)->count();
        if($type==1){
            $comment = DB::table('vote_comment')->where('vote_id', '=', $id)->where('item_id', '=', $cid)->where('status', '=', 0)->orderBy('comment_time', 'desc')->get();
        }else{
            $comment = DB::table('vote_comment')->where('vote_id', '=', $id)->where('item_id', '=', $cid)->where('status', '=', 0)->orderBy('comment_time', 'desc')->take(10)->get();
        }
        
        foreach ($comment as $k => $v) {
            $user = DB::table('vote_wxuser')->where('id', '=', $v->user_id)->first();
            if($user){
                $comment[$k]->name = $user->nickname;
                $comment[$k]->headimgurl = $user->headimgurl;
            }
        }
        
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
            'id' => $id,
            'vote' => $vote,
            'type' => $type,
            'brand'=>$brand,
            'comment' => $comment,
            'commetNumber' => $commetNumber,
            'candidate' => $candidate,
            'subscribe' => Session::get('subscribe_'.$id),
            'ajaxVoteUrl' => $ajaxVoteUrl,
            'ajaxCommentUrl' => $ajaxCommentUrl,
            'reloadUrl' => $reloadUrl,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->info_share_title,
                'shareDesc' => $vote->info_share_desc,
                'shareLogo' => $vote->other_share_logo,
                'shareUrl' => route('home.vote.getInfo'.$id, ['cid'=>$candidate->id]).'?id='.$vote->id.'&type='.$type,
            ],
        ]);
    }

    public function getRank (Request $request) {
        $id = (int) $request->input('id');
        
        $type = (int) $request->input('type');
        $keywords = $request->input('keywords');
        
        $vote = DB::table('vote')->where('id', '=', $id)->first();
        $brand = array();
        $rank = 1;
        
        if($type>0){
            if($keywords){
                $rank = 2;
                $rankList =DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->where('name', 'like', '%'.$keywords.'%')->orderBy('num', 'dasc')->orderBy('id', 'asc')->get();
            }else{
                $rank = 3;
                $rankList =DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->where('rank', '=', $type)->orderBy('num', 'dasc')->orderBy('id', 'asc')->get();
                $brand = DB::table('vote_15_brand')->where('status', '=','0')->where('id', '=',$type)->first();
            }
            $shareUrl = route('home.vote.getRank'.$id).'?id='.$vote->id.'&type='.$type;
        }else{
            $rankList = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0,2])->orderBy('num', 'desc')->orderBy('id', 'asc')->take($vote->rank_num)->get();
            $shareUrl = route('home.vote.getRank'.$id).'?id='.$vote->id;
        }
        
        foreach ($rankList as $k => $v) {
            $rankList[$k]->url = route('home.vote.getInfo'.$id, ['cid'=>$v->id]) . '?id=' . $v->vote_id.'&type='.$v->rank;
        }
        
        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);
        
        $wid = Session::get('wxuserid_'.$id);

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);


        return view('app.vote.'.$id.'.rank', [
            'id'=>$id,
            'type'=>$type,
            'vote' => $vote,
            'wid' => $wid,
            'rankList' => $rankList,
            'rank' => $rank,
            'subscribe' => Session::get('subscribe_'.$id),
            'brandList' => $brand,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc' => $vote->other_share_desc,
                'shareLogo' => $vote->other_share_logo,
                'shareUrl' => $shareUrl,
            ],
        ]);
    }

    public function getDoVote (Request $request, $cid, $wid) {
        $id = (int) $request->input('id');
        $captcha = $request->input('captcha_code');
        $brand = $request->input('type');

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
        $wxJssdkConfig = $this->getJssdkConfig($id);
        
        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);


        return view('app.vote.'.$id.'.register', [
            'vote'=>$vote,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc' => $vote->other_share_desc,
                'shareLogo' => $vote->other_share_logo,
                'shareUrl' => route('home.vote.getIndex'.$id).'?id='.$vote->id,
            ],    
        ]);
    }

    public function getDoRegister (Request $request) {
        $voteId = (int) $request->input('id');
        //$picUrl = $request->input('picurl');
        $phone = $request->input('tel');

        $duplicateItem = DB::table('candidate')->where('vote_id', '=', $voteId)->where('tel', '=', $phone)->where('status', '=', 0)->first();
        if ($duplicateItem && ! empty($duplicateItem->tel)) {
            return response()->json(3);
        }

        $vote = DB::table('vote')->where('id', '=', $voteId)->first();
        $data = $request->except(['id', 'type']);

        $data['no'] = (DB::table('candidate')->where('vote_id', '=', $voteId)->max('no'))+1;
        $data['status'] = $vote->audit_status == 0 ? 0 : 1;
        //$data['pic_url'] = $picUrl;
        $data['vote_id'] = $voteId;
        $data['created_at'] = date('Y-m-d H:i:s',time());
        $data['updated_at'] = date('Y-m-d H:i:s',time());

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
    
    public function getDoVoteComment (Request $request, $cid, $wid) {
        $id = (int) $request->input('id');
        $comment = $request->input('comment');
        
        $data = array(
            'vote_id' => $id,
            'item_id' => $cid,
            'user_id' => $wid,
            'comment_time' => time(),
            'status' => 1,
            'comment' => $comment,
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