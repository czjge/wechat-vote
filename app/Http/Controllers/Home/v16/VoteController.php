<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home\v16;

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
        $type = $request->input('type')?(int) $request->input('type'):0; // 0
        
        if($type>1){
            $title = (int)$request->input('title');
            if($title<6){
                $title = 6;
            }
        }else{
            $title = $request->input('title')?(int) $request->input('title'):6;
        }

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        if (! $vote) {
            throw new TableRowNotFoundException('没有该投票');
        }

        $keywords = $request->input('keywords');


        // 总票数
        $votesNum = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->sum('num');

        // 选手列表
        if ($keywords) {
            //$builder = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->where('of_dep', 'like', '%'.$keywords.'%')->orWhere('of_hospital', 'like', '%'.$keywords.'%');
            $builder = DB::table('candidate')->where('vote_id', '=', 16)->whereIn('status', [0, 2])
                    ->where(function($query)use($keywords){
                        $query->where('of_dep', 'like', '%'.$keywords.'%')
                            ->orWhere(function($query)use($keywords){
                                $query->where('of_hospital', 'like', '%'.$keywords.'%');
                            });
                    });
            
        } else if($type>0) {
            $builder = DB::table('candidate')->where('vote_id', '=', $id)->where('type', '=', 1)->where('rank', '=', $type)->whereIn('status', [0, 2]);
            if($title>0){
                $builder = $builder->where('title', '=', $title);
            }
        }else {
            $builder = DB::table('candidate')->where('vote_id', '=', $id)->where('type', '=', 0)->whereIn('status', [0, 2]);
            if($title>0){
                $builder = $builder->where('title', '=', $title);
            }
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
            'id' => $id,
            'title'=>$title,
            'type'=>$type,
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
                'shareUrl' => route('home.vote.getIndex'.$vote->id).'?id='.$vote->id,
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
        $ajaxVoteUrl = route('home.vote.getDoVote'.$id, ['cid'=>$cid, 'wid'=>$wid]) . '?id=' . $id;
        $reloadUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]) . '?id=' . $id;

        // candidate clicks.
        DB::table('candidate')->where('id', '=', $cid)->increment('clicks', 1);

        // info_share_title:replace some default values.
        if (strpos($vote->info_share_title, '{NAME}') !== false) {
            $vote->info_share_title = str_replace('{NAME}', $candidate->of_dep, $vote->info_share_title);
        }
        if (strpos($vote->info_share_title, '{NO}') !== false) {
            $vote->info_share_title = str_replace('{NO}', $candidate->no, $vote->info_share_title);
        }

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);
        
        $district = ['1'=>'锦江区','2'=>'青羊区','3'=>'金牛区','4'=>'武侯区','5'=>'成华区','6'=>'高新区','7'=>'天府新区',
            '8'=>'龙泉驿区','9'=>'青白江区','10'=>'新都区','11'=>'温江区','13'=>'都江堰市','14'=>'彭州市','15'=>'邛崃市',
            '16'=>'崇州市','17'=>'金堂县','12'=>'双流区','18'=>'郫县','19'=>'大邑县','20'=>'浦江县','21'=>'新津县','22'=>'简阳市'];
        
        return view('app.vote.'.$id.'.info', [
            'district'=> $district[$candidate->title],
            'vote' => $vote,
            'candidate' => $candidate,
            'subscribe' => Session::get('subscribe_'.$id),
            'ajaxVoteUrl' => $ajaxVoteUrl,
            'reloadUrl' => $reloadUrl,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->info_share_title,
                'shareDesc' => $vote->info_share_desc,
                'shareLogo' => 'https://qiniu.scmingyi.com/mp_vote/public/storage/'.$candidate->pic_url,
                'shareUrl' => route('home.vote.getInfo'.$vote->id, ['cid'=>$candidate->id]).'?id='.$vote->id,
            ],
        ]);
    }

    public function getRank (Request $request) {
        $id = (int) $request->input('id');
        $type = $request->input('type')?(int)$request->input('type'):0;

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        
        if($type>0){
            $rankList = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0,2])->where('type', '=', 1)->where('rank', '=', $type)->orderBy('num', 'desc')->take($vote->rank_num)->get();
        }else{
            $rankList = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0,2])->where('type', '=', $type)->orderBy('num', 'desc')->take($vote->rank_num)->get();
        }
        
        foreach ($rankList as $k => $v) {
            $rankList[$k]->url = route('home.vote.getInfo'.$v->vote_id, ['cid'=>$v->id]) . '?id=' . $v->vote_id;
        }
        
        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);


        return view('app.vote.'.$id.'.rank', [
            'type' => $type,
            'vote' => $vote,
            'rankList' => $rankList,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc' => $vote->other_share_desc,
                'shareLogo' => $vote->other_share_logo,
                'shareUrl' => route('home.vote.getRank'.$vote->id).'?id='.$vote->id,
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
    
    public function getForm (Request $request,$cid) {
        $id = (int) $request->input('id');
        if($id!=16){
            throw new TableRowNotFoundException('路径错误');
        }
        
        $vote = DB::table('vote')->where('id', '=', $id)->first();
        
        $list = DB::table('candidate')->where('vote_id', '=', $id)->where('id', '=',$cid)->where('status', '=', 0)->first();
        if(!$list){
            throw new TableRowNotFoundException('无法进行预签约，对象不存在或被锁定');
        }
        
        $candidate = DB::table('candidate')->where('id', '=', $cid)->first();
        
        // info_share_title:replace some default values.
        if (strpos($vote->info_share_title, '{NAME}') !== false) {
            $vote->info_share_title = str_replace('{NAME}', $candidate->of_dep, $vote->info_share_title);
        }
        if (strpos($vote->info_share_title, '{NO}') !== false) {
            $vote->info_share_title = str_replace('{NO}', $candidate->no, $vote->info_share_title);
        }
        
        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);
        
        return view('app.vote.'.$id.'.form', [
            'list'=>$list,
            'id'=>$id,
            'cid'=>$cid,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->info_share_title,
                'shareDesc' => $vote->info_share_desc,
                'shareLogo' => 'https://qiniu.scmingyi.com/mp_vote/public/storage/'.$candidate->pic_url,
                'shareUrl' => route('home.vote.getInfo'.$vote->id, ['cid'=>$candidate->id]).'?id='.$vote->id,
            ],
        ]);
    }
    
    public function postForm (Request $request,$cid) {
        $data = $request->except('_token', 'id');
        $id = (int) $request->input('id');
        if($id!=16){
            return response()->json(4);
        }
        
        $list = DB::table('candidate')->where('vote_id', '=', $id)->where('id', '=',$cid)->where('status', '=', 0)->first();
        if(!$list){
            return response()->json(5);
        }else if($list->type>0&&$list->rank==2){
            return response()->json(4);
        }
        
        
        $count = DB::table('vote_form')->where('cid', '=', $cid)->where('tel', '=', $data['tel'])->count();
        if ($count>0) {
            return response()->json(3);
        }
        
        $vote = DB::table('vote')->where('id', '=', $id)->first();
        
        $data['vid']=$id;
        $data['cname']=$list->type>0?$list->of_hospital:$list->of_dep;
        $data['created_at'] = date("Y-m-d H:i:s",time());
        
        if (DB::table('vote_form')->insert($data)) {
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