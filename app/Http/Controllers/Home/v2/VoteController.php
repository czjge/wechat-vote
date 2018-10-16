<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home\v2;

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
        $vote_id = (int) $request->input('id');
        $type = $request->input('type')?(int) $request->input('type'):0; // 0
        $keywords = $request->input('keywords');

        $vote = DB::table('vote')->where('id', '=', $vote_id)->first();
        if (! $vote) {
            throw new TableRowNotFoundException('没有该投票');
        }


        if ($type==0) {
            // 院级榜单 - 0
            $builder = DB::table('hao_hosrank_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hao_hosrank_doctor.hospital_id')
                ->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hao_hosrank_doctor.department_id');
            if ($keywords) {
                $builder = $builder->where('hao_hosrank_doctor.hospital', 'like', '%'.$keywords.'%');
            }
            $retval = $builder->select(
                DB::raw('count(distinct hao_hosrank_doctor.department) as department_count, 
                        count(hao_hosrank_doctor.id) as doctor_count, 
                        hao_hosrank_doctor.hospital as hospital_name, 
                        hys_px_hospital.logourl as hospital_logo, 
                        hys_px_hospital.level as hospital_level,
                        hys_px_hospital.id as hospital_id')
            )->groupBy('hao_hosrank_doctor.hospital')->orderBy('hao_sorts')->get(); // todo order by
        } elseif ($type==1) {
            // 专科专病榜单 - 1
            $builder = DB::table('hao_perrank_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hao_perrank_doctor.hospital_id')
                ->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hao_perrank_doctor.department_id');
            if ($keywords) {
                $builder = $builder->where('hao_perrank_doctor.disease', 'like', '%'.$keywords.'%');
            }
            $retval = $builder->select(
                DB::raw('count(hao_perrank_doctor.id) as doctor_count, 
                        hao_perrank_doctor.disease as disease_name')
            )->groupBy('hao_perrank_doctor.disease')->get(); // todo order by

        } elseif ($type==2) {
            // 专家评审团
            $builder = DB::table('hys_px_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hys_px_doctor.hid');
            if ($keywords) {
                $builder = $builder->where('hys_px_doctor.name', 'like', '%'.$keywords.'%');
            }
            $retval = $builder->where('hys_px_doctor.hao_doctor', '=', 1)
                        ->select('hys_px_doctor.name as doctor_name',
                                'hys_px_doctor.avatar as doctor_avatar',
                                'hys_px_doctor.prof as doctor_title',
                                'hys_px_hospital.name as hospital_name',
                                'hys_px_doctor.id as doctor_id')
                        ->orderBy(DB::raw('convert(hys_px_doctor.name using gbk)'))->get();
        } elseif ($type==3) {
            // 百强榜单
            $builder = DB::table('candidate')->where('vote_id', '=', 3);
            if ($keywords) {
                $builder = $builder->where('name', 'like', '%'.$keywords.'%');
            }
            $retval = $builder->
                orderBy(DB::raw('convert(name using gbk)'))->get();
        } else {
            // 十强榜单
            $final_ids = [
                415, 427, 431, 439, 414, 440, 428, 449, 450, 497
            ]; // id为candidate表的id
            $builder = DB::table('candidate')->where('vote_id', '=', 3);
            if ($keywords) {
                $builder = $builder->where('name', 'like', '%'.$keywords.'%');
            }
            $retval = $builder
                ->whereIn('id', $final_ids)
                ->orderBy(DB::raw('convert(name using gbk)'))->get();
        }


        if ($type == 0) {
            $perPage = config('home.pageNum');
            if ($request->has('page')) {
                $currentPage = $request->input('page');
                $currentPage = $currentPage <= 0 ? 1 :$currentPage;
            } else {
                $currentPage = 1;
            }
            $item = array_slice($retval, ($currentPage-1)*$perPage, $perPage);

            $paginator = new LengthAwarePaginator($item, count($retval), $perPage, $currentPage, [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]);

            $retval = $paginator->toArray()['data'];
            //dd($hospitals);
        } else {
            $paginator = '';
        }


        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($vote_id);


        //$view_path = $type==0 ? 'app.vote.'.$vote_id.'.index' : 'app.vote.'.$vote_id.'.index1';
        if ($type==0) {
            $view_path = 'app.vote.'.$vote_id.'.index';
        } elseif ($type==1) {
            $view_path = 'app.vote.'.$vote_id.'.index1';
        } elseif ($type==2) {
            $view_path = 'app.vote.'.$vote_id.'.index2';
        } elseif ($type==3) {
            $view_path = 'app.vote.'.$vote_id.'.index3';
        } elseif ($type==4) {
            $view_path = 'app.vote.'.$vote_id.'.index4';
        }

        return view($view_path, [
            'id' => $vote_id,
            'vote' => $vote,
            'retval' => $retval,
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
        $vote_id = (int) $request->input('id');
        $item_id = $cid;
        $type = $request->input('type')?(int) $request->input('type'):0; // 0

        $vote = DB::table('vote')->where('id', '=', $vote_id)->first();
        if ($type==0) {
            $candidate = DB::table('hao_hosrank_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hao_hosrank_doctor.hospital_id')
                //->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hao_hosrank_doctor.department_id')
                ->leftJoin('hys_px_doctor', 'hys_px_doctor.id', '=', 'hao_hosrank_doctor.doctor_id')
                ->where('hao_hosrank_doctor.id', '=', $item_id)
                ->select(
                    DB::raw('hao_hosrank_doctor.name as doctor_name,
                    hys_px_doctor.avatar as doctor_avatar,
                    hao_hosrank_doctor.title as doctor_title,
                    hao_hosrank_doctor.hospital as hospital,
                    hao_hosrank_doctor.department as doctor_dep,
                    hao_hosrank_doctor.intro as doctor_intro,
                    hao_hosrank_doctor.goodat as doctor_goodat,
                    hao_hosrank_doctor.schedule_time as schedule_time')
                )->first(); // todo order by
        } elseif ($type==1) {
            $candidate = DB::table('hao_perrank_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hao_perrank_doctor.hospital_id')
                //->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hao_hosrank_doctor.department_id')
                ->leftJoin('hys_px_doctor', 'hys_px_doctor.id', '=', 'hao_perrank_doctor.doctor_id')
                ->where('hao_perrank_doctor.id', '=', $item_id)
                ->select(
                    DB::raw('hao_perrank_doctor.name as doctor_name,
                    hys_px_doctor.avatar as doctor_avatar,
                    hao_perrank_doctor.title as doctor_title,
                    hao_perrank_doctor.hospital as hospital,
                    hao_perrank_doctor.department as doctor_dep,
                    hao_perrank_doctor.intro as doctor_intro,
                    hao_perrank_doctor.goodat as doctor_goodat,
                    hao_perrank_doctor.schedule_time as schedule_time')
                )->first(); // todo order by
        } elseif ($type==2) {
            $candidate = DB::table('hys_px_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hys_px_doctor.hid')
                ->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hys_px_doctor.department_id')
                ->where('hys_px_doctor.id', '=', $item_id)
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
        } else {
            $candidate = DB::table('candidate')
                ->where('id', '=', $item_id)
                ->select(
                    'name as doctor_name',
                    'pic_url as doctor_avatar',
                    'title as doctor_title',
                    'of_hospital as hospital',
                    'of_dep as doctor_dep',
                    'desc as doctor_intro',
                    'shanchang as doctor_goodat',
                    'schedule_time as schedule_time'
                )->first();
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
        foreach ($schedule_time_array as $key => $value) {
            if ($value=='1') {
                $schedule_time_str .= $week_map[$key[0]].$day_map[$key[2]].($key+1==array_count_values($schedule_time_array)[1] ? '' : '，');
            }
        }
        $candidate->schedule_time = $schedule_time_str;

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($vote_id);


        return view('app.vote.'.$vote_id.'.info', [
            'vote' => $vote,
            'candidate' => $candidate,
            'wxJssdkConfig' => json_decode($wxJssdkConfig),
            'shareInfo' => [
                'shareTitle' => $vote->info_share_title,
                'shareDesc' => $vote->info_share_desc,
                'shareLogo' => 'https://qiniu.scmingyi.com/mp_vote/public/storage/',
                //'shareUrl' => route('home.vote.getInfo'.$vote->id, ['cid'=>$candidate->id]).'?id='.$vote->id,
                'shareUrl' => '',
            ],
        ]);
    }

    public function getRank (Request $request) {
        $vote_id = (int) $request->input('id');
        $type = $request->input('type')?(int)$request->input('type'):0;
        $keywords = $request->input('keywords');
        $hospital_id = $request->input('hospital_id');
        $disease = $request->input('disease');


        $hospital = DB::table('hys_px_hospital')->where('id', '=', $hospital_id)->first();
        $vote = DB::table('vote')->where('id', '=', $vote_id)->first();

        if($type==0){
            $builder = DB::table('hao_hosrank_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hao_hosrank_doctor.hospital_id')
                //->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hao_hosrank_doctor.department_id')
                ->leftJoin('hys_px_doctor', 'hys_px_doctor.id', '=', 'hao_hosrank_doctor.doctor_id')
                ->where('hao_hosrank_doctor.hospital_id', '=', $hospital_id);
            if ($keywords) {
                $builder = $builder->where(function ($query) use ($keywords) {
                    $query->where('hao_hosrank_doctor.hospital', 'like', '%'.$keywords.'%')
                        ->orWhere('hao_hosrank_doctor.name', 'like', '%'.$keywords.'%');
                });
            }
            $retval = $builder->select(
                DB::raw('hao_hosrank_doctor.name as doctor_name,
                hys_px_doctor.avatar as doctor_avatar,
                hao_hosrank_doctor.title as doctor_title,
                hao_hosrank_doctor.hospital as hospital,
                hao_hosrank_doctor.id as id')
            )->orderBy(DB::raw('convert(hao_hosrank_doctor.name using gbk)'))->get(); // todo order by
        }else{
            $builder = DB::table('hao_perrank_doctor')
                ->leftJoin('hys_px_hospital', 'hys_px_hospital.id', '=', 'hao_perrank_doctor.hospital_id')
                //->leftJoin('hys_px_department', 'hys_px_department.id', '=', 'hao_hosrank_doctor.department_id')
                ->leftJoin('hys_px_doctor', 'hys_px_doctor.id', '=', 'hao_perrank_doctor.doctor_id')
                ->where('hao_perrank_doctor.disease', '=', $disease);
            if ($keywords) {
                $builder = $builder->where(function ($query) use ($keywords) {
                    $query->where('hao_perrank_doctor.hospital', 'like', '%'.$keywords.'%')
                        ->orWhere('hao_perrank_doctor.name', 'like', '%'.$keywords.'%');
                });
            }
            $retval = $builder->select(
                DB::raw('hao_perrank_doctor.name as doctor_name,
                hys_px_doctor.avatar as doctor_avatar,
                hao_perrank_doctor.title as doctor_title,
                hao_perrank_doctor.hospital as hospital,
                hao_perrank_doctor.id as id,
                hao_perrank_doctor.is_recommend as is_recommend')
            )->orderBy('hao_perrank_doctor.id', 'asc')->get(); // todo order by
        }

        $perPage = 20;
        if ($request->has('page')) {
            $currentPage = $request->input('page');
            $currentPage = $currentPage <= 0 ? 1 :$currentPage;
        } else {
            $currentPage = 1;
        }
        $item = array_slice($retval, ($currentPage-1)*$perPage, $perPage);

        $paginator = new LengthAwarePaginator($item, count($retval), $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        $retval = $paginator->toArray()['data'];

        // wechat jssdkConfig.
        $wxJssdkConfig = $this->getJssdkConfig($vote_id);


        return view('app.vote.'.$vote_id.'.rank', [
            'id' => $vote_id,
            'vote' => $vote,
            'retval' => $retval,
            'type' => $type,
            'paginator' => $paginator,
            'title' => $type==0 ? $hospital->name : $disease,
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