<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home\v1;

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

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        if (! $vote) {
            throw new TableRowNotFoundException('没有该投票');
        }

        $keywords = $request->input('keywords');


        // 总票数
        $votesNum = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->sum('num');
        if($type==1){
            $builder = DB::table('hys_px_doctor')->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hys_px_doctor.hid');
            $candidates = $builder->where('hys_px_doctor.hao_doctor', '=', 1)
                        ->select('hys_px_doctor.name as doctor_name',
                                'hys_px_doctor.avatar as pic_url',
                                'hys_px_doctor.prof as doctor_title',
                                'hys_px_hospital.name as hospital_name',
                                'hys_px_doctor.id as doctor_id')
                        ->orderBy(DB::raw('convert(hys_px_doctor.name using gbk)'))->get();
            $paginator = '';
        }else{
            // 选手列表
            if ($keywords) {
                $builder = DB::table('candidate')->where('vote_id', '=', 1)->whereIn('status', [0, 2])->where('name', 'like', '%'.$keywords.'%');
//                $builder = DB::table('candidate')->where('vote_id', '=', 1)->whereIn('status', [0, 2])
//                        ->where(function($query)use($keywords){
//                            $query->where('of_dep', 'like', '%'.$keywords.'%')
//                                ->orWhere(function($query)use($keywords){
//                                    $query->where('of_hospital', 'like', '%'.$keywords.'%');
//                                });
//                        });
            }else {
                $builder = DB::table('candidate')->where('vote_id', '=', 1)->where('type', '=', 0)->whereIn('status', [0, 2]);
            }
            
            // 排序方式
            if ($vote->index_sort_type == 1) {
                $builder = $builder->orderBy('no', 'desc');
            } elseif ($vote->index_sort_type == 2) {
                $builder = $builder->orderBy('no', 'asc');
            } elseif ($vote->index_sort_type == 3) {
                $builder = $builder->orderBy('num', 'desc')->orderBy('no', 'asc');
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

            $paginator = new LengthAwarePaginator($item, count($candidates), $perPage, $currentPage, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]);

            $candidates = $paginator->toArray()['data'];
        }
        
        $total = count(DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0, 2])->get());

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);

        return view('app.vote.'.$id.'.index', [
            'id' => $id,
            'type'=>$type,
            'vote' => $vote,
            'candidatesNum' => $total,
            'votesNum' => $votesNum?$votesNum:0,
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
        $type = $request->input('type')?(int) $request->input('type'):0; // 0

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        
        // do-voting url.
        $wid = Session::get('wxuserid_'.$id);
        
        if ($type==1) {
            $candidate = DB::table('hys_px_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hys_px_doctor.hid')
                ->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hys_px_doctor.department_id')
                ->where('hys_px_doctor.id', '=', $cid)
                ->select(
                    DB::raw('hys_px_doctor.name as doctor_name,
                    hys_px_doctor.avatar as doctor_avatar,
                    hys_px_doctor.prof as doctor_title,
                    hys_px_hospital.name as hospital,
                    hys_px_department.name as doctor_dep,
                    hys_px_doctor.intro as doctor_intro,
                    hys_px_doctor.shanchang as doctor_goodat,
                    hys_px_doctor.schedule_time as schedule_time')
                ) ->first();
            $ajaxVoteUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]) . '?id=' . $id.'&type='.$type;
            $reloadUrl = route('home.vote.getIndex'.$id) . '?id=' . $id.'&type=0';
            
        }else{
            $candidate = DB::table('candidate')->where('id', '=', $cid)->first();
            $ajaxVoteUrl = route('home.vote.getDoVote'.$id, ['cid'=>$cid, 'wid'=>$wid]) . '?id=' . $id;
            $reloadUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]) . '?id=' . $id.'&type='.$type;
            
        }
       
         // 格式化坐诊时间
        $schedule_time_array = unserialize($candidate->schedule_time);
        $schedule_time_str = '';
        $week_map = [
            '1' => '星期一',
            '2' => '星期二',
            '3' => '星期三',
            '4' => '星期四',
            '5' => '星期五',
            '6' => '星期六',
            '7' => '星期日',
        ];
        $day_map = [
            '1' => '上午',
            '3' => '下午',
        ];
        if($schedule_time_array!==false){
             foreach ($schedule_time_array as $key => $value) {
                if ($value=='1') {
                    $schedule_time_str .= $week_map[$key[0]].$day_map[$key[2]].($key+1==array_count_values($schedule_time_array)[1] ? '' : '，');
                }
            }
            $candidate->schedule_time = $schedule_time_str;
        }
        
        if($candidate->schedule_time){
            $candidate->schedule_time = rtrim($candidate->schedule_time, ',');
            $candidate->schedule_time = rtrim($candidate->schedule_time, '，');
        }
       
        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($id);
        
        // candidate clicks.
        DB::table('candidate')->where('id', '=', $cid)->increment('clicks', 1);
        
        if($type==0){
            // info_share_title:replace some default values.
            if (strpos($vote->info_share_title, '{NAME}') !== false) {
                $vote->info_share_title = str_replace('{NAME}', $candidate->name, $vote->info_share_title);
            }
            if (strpos($vote->info_share_title, '{NO}') !== false) {
                $vote->info_share_title = str_replace('{NO}', $candidate->no, $vote->info_share_title);
            }
            $shareLogo = 'http://qiniu.langzoo.com/'.$candidate->pic_url;
            $shareUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]).'?id='.$id.'&type='.$type;
        }else{
            $shareLogo =  'http://qiniu.langzoo.com/'.$candidate->doctor_avatar;
            $shareUrl = route('home.vote.getInfo'.$id, ['cid'=>$cid]).'?id=1&type=1';
        }
        
        if(env('FORCE_SUBSCRIBE_VOTE')){
            $subscribe = Session::get('subscribe_'.$id);
        }else{
            $subscribe = 1;
        }

        // total clicks.
        DB::table('vote')->where('id', '=', $id)->increment('clicks', 1);
        
        
        return view('app.vote.'.$id.'.info', [
            'id' =>$id,
            'type' => $type,
            'vote' => $vote,
            'candidate' => $candidate,
            'subscribe' => $subscribe,
            'ajaxVoteUrl' => $ajaxVoteUrl,
            'reloadUrl' => $reloadUrl,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc' => $vote->info_share_desc,
                'shareLogo' => $shareLogo,
                'shareUrl' => $shareUrl,
            ],
        ]);
    }

    public function getRank (Request $request) {
        $id = (int) $request->input('id');
	$type = $request->input('type')?(int)$request->input('type'):0; // 0

        $vote = DB::table('vote')->where('id', '=', $id)->first();
        
        $rankList = DB::table('candidate')->where('vote_id', '=', $id)->whereIn('status', [0,2])->orderBy('num', 'desc')->take($vote->rank_num)->get();
        
        
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

    public function getLog (Request $request) {
        $vote_id = $request->input('id');
        $todayTime = strtotime(date('Y-m-d'));
        $vote = DB::table('vote')->where('id', '=', $vote_id)->first();
        $wid = Session::get('wxuserid_'.$vote_id);

        $wxJssdkConfig = $this->getJssdkConfig($vote_id);
        
        $logLists = DB::table('candidate')
                ->leftJoin('vote_log', 'candidate.id', '=', 'vote_log.item_id')
                ->where('vote_log.user_id', '=', $wid)
                ->where('candidate.vote_id', '=', $vote_id)
                ->where('vote_log.time_key', '=', $todayTime)
                ->select(
                    'candidate.pic_url as doctor_avatar',
                    'candidate.name as doctor_name',
                    'candidate.title as doctor_title',
                    'candidate.id as doctor_id',
                    'vote_log.log_time as times'
                ) ->get();
               
        return view('app.vote.'.$vote_id.'.log', [
            'id' => $vote_id,
            'logLists' => $logLists,
            'vote' => $vote,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->other_share_title,
                'shareDesc' => $vote->other_share_desc,
                'shareLogo' => $vote->other_share_logo,
                'shareUrl' => route('home.vote.getIndex'.$vote->id).'?id='.$vote->id,
            ],
        ]);
    }

}