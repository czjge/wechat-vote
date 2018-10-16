<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/17
 * Time: 16:35
 */

namespace App\Http\Controllers\Home\v19;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Overtrue\Wechat\Js;
use App\Http\Controllers\HomeBaseController;
use App\Repositories\vote\v19\VoteRepository as voteRep;
use App\Events\VotePageWasLoaded;
use App\Events\CandidatePageWasLoaded;
use App\Models\vote\Vote;
use App\Models\vote\Candidate;
use App\Extensions\Common;
use App\Models\vote\FieldValue;
use Illuminate\Support\Facades\Input;


class VoteController extends HomeBaseController
{

    use Common;

    private $indexListCacheKey = 'scmy.vote.index.list.19';
    private $rankListCacheKey = 'scmy.vote.rank.list.19';
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
        // 只搜索vote表里面的字段
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
                return $builder->paginate(config('admin.pageNum'));
            });
        } else {
            $candidates = $builder->paginate(config('admin.pageNum'));
        }

        $wid = Session::get('wxuserid_'.$id);
        $reloadUrl = route('home.vote.getIndex'.$id) . '?id=' . $id . '&keywords=' . Input::get('keywords') . '&page=' . Input::get('page');

        // 添加额外字段等信息
        foreach ($candidates as $key => $candidate) {
            $extend_field_values = FieldValue::where('candidate_id', '=', $candidate->id)->first();
            if ($extend_field_values) {
                $extend_field_values_arr = unserialize($extend_field_values->values);
                foreach ($extend_field_values_arr as $k => $extend_field_values_item) {
                    $candidate->$k = $extend_field_values_item;
                }
            }
            $candidates[$key]->ajax_vote_url = route('home.vote.getDoVote'.$id, ['cid'=>$candidate->id, 'wid'=>$wid]) . '?id=' . $id;

            // 文章开始部分截取
            $candidates[$key]->article_content_start = mb_substr(explode('<br>', $candidate->desc)[0], 0, 25) . '...';
        }

        // 如果需要按照非vote表里面的字段搜索
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

        if ($vote->subscribe_vote_status == 1) {
            $subscribe = Session::get('subscribe_'.$id);
        } else {
            $subscribe = 1;
        }




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
            'subscribe' => $subscribe,
            'candidatesNum' => $candidates_num,
            'votesNum'      => $votes_num ? $votes_num : 0,
            'candidates'    => $candidates,
            'reloadUrl'     => $reloadUrl,
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

        // 添加额外字段
        $extend_field_values = FieldValue::where('candidate_id', '=', $candidate->id)->first();
        if ($extend_field_values) {
            $extend_field_values_arr = unserialize($extend_field_values->values);
            foreach ($extend_field_values_arr as $k => $extend_field_values_item) {
                $candidate->$k = $extend_field_values_item;
            }
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

        foreach ($rank_list as $key => $v) {
            $extend_field_values = FieldValue::where('candidate_id', '=', $v->id)->first();
            if ($extend_field_values) {
                $extend_field_values_arr = unserialize($extend_field_values->values);
                foreach ($extend_field_values_arr as $k => $extend_field_values_item) {
                    $v->$k = $extend_field_values_item;
                }
            }
            $rank_list[$key]->url = route('home.vote.getInfo'.$v->vote_id, ['cid'=>$v->id]) . '?id=' . $id;
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

    public function postDoSthByType(Request $request)
    {
        $type = $request->input('type');

        if ($type == 1) {
            $vote_id = $request->input('vote_id');
            $candidate_id = $request->input('id');
            $phone = $request->input('phone');
            $wid = Session::get('wxuserid_' . $vote_id);
            $post_data = $request->except(['_token', 'type', 'vote_id']);
            $vote = DB::table('vote')->where('id', '=', $vote_id)->first();
            $candidate = DB::table('candidate')->where('id', '=', $candidate_id)->first();

            // 查看是否关注了公众号
            // TODO...

            // 查看抢号时间到没
            if (time() < strtotime($vote->start_time)) {
                return response()->json(-5);
            }

            // 一个微信号只能预约一次
            if (DB::table('registration_log')->where('user_id', '=', $wid)->first()) {
                return response()->json(-4);
            }

            // 这里还要判断下是否还有号
            $candidate_id = $request->input('id');
            $candidate_extend_vals = DB::table('field_value')->where('candidate_id', '=', $candidate_id)->first();
            if ($candidate_extend_vals->values) {
                $temp = unserialize($candidate_extend_vals->values);
                $registration_left_num = unserialize($candidate_extend_vals->values)['registration_left_num'];
                if ($registration_left_num > 0) {
                    $data = ['signup_info' => serialize($post_data)];

                    // 数据存入
                    DB::beginTransaction();
                    if (DB::table('registration')->insert($data) && DB::table('registration_log')->insert(['user_id'=>$wid])) {
                        // 对应医生的号-1

                        $registration_left_num -= 1;
                        $temp['registration_left_num'] = $registration_left_num;
                        $re = DB::table('field_value')->where('candidate_id', '=', $candidate_id)->update(['values'=>serialize($temp)]);
                        if ($re !== false) {
                            DB::commit();

                            // 发送短信通知
                            $sms_post_url = 'https://sms.yunpian.com/v2/sms/single_send.json';
                            $sms_post_info = [
                                'apikey' => 'e82e0095554a00d71d496fceba928092',
                                'mobile' => $phone,
                                'text' => '【成都商报四川名医】通知:中医药健康文化推进-义诊活动,恭喜您已成功预约'.$candidate->name.'医生,请凭此短信于7月1日(星期天)上午8点30分准时至锦江区红星路步行广场(春熙路地铁D口前)取号就诊.特别提醒:现场取号截止时间9:30,如未按照约定时间到场取号,则视为放弃预约号源.来到义诊现场(红星路步行广场春熙路地铁D口前).也将有机会获得专家义诊名额.',
                            ];
                            $ch = curl_init();
                            curl_setopt ($ch, CURLOPT_URL, $sms_post_url);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sms_post_info));
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                            $sms_send_data = curl_exec($ch);
                            curl_close($ch);
                            $sms_gateway_back_msg = json_decode($sms_send_data, true);

                            // 日志记录
                            SelfLog::info(var_export($sms_gateway_back_msg, true));

                            return response()->json($registration_left_num);
                        } else {
                            DB::rollBack();
                            return response()->json(-3);
                        }
                    } else {
                        DB::rollBack();
                        return response()->json(-3);
                    }
                } else {
                    return response()->json(-2);
                }
            } else {
                return response()->json(-1);
            }
        }

        if ($type == 2) {
            $candidate_id = $request->input('id');
            $candidate_extend_vals = DB::table('field_value')->where('candidate_id', '=', $candidate_id)->first();
            if ($candidate_extend_vals->values) {
                $registration_left_num = unserialize($candidate_extend_vals->values)['registration_left_num'];
                return response()->json($registration_left_num);
            } else {
                return response()->json(-1);
            }
        }

        if ($type == 3) {
            $mobile = $request->input('mobile');
            $vote_id = $request->input('id');
            $wechat_userInfo = Session::get('userInfo_'.$vote_id);
            if ($wechat_userInfo['subscribe'] == 1) {
                $wechat_nickname = $wechat_userInfo['nickname'];
            } else {
                $wechat_nickname = '';
            }

            DB::beginTransaction();

            $ret = DB::table('tyj_voter_mobile_log')->insert([
                'mobile'          => $mobile,
                'wechat_nickname' => $wechat_nickname,
            ]);
            
            if ($ret) {
                DB::commit();
                return response()->json(1);
            } else {
                DB::rollBack();
                return response()->json(2);
            }
        }

        if ($type == 4) {
            $id = $request->input('id');
            $wid = Session::get('wxuserid_'.$id);

            // 查看投票用户是否有投票记录
            $vote_count = DB::table('vote_log')
                ->where('vote_id', '=', $id)
                ->where('user_id', '=', $wid)
                ->count();

            return response()->json($vote_count == 0 ? false :true);
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