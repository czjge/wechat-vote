<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/11
 * Time: 11:38
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\vote\FieldValue;
use App\Models\vote\Wxuser;
use App\Repositories\vote\VoteRepository as voteRep;
use App\Models\vote\Vote;
use App\Models\vote\Candidate;
use App\Models\vote\VoteLog;
use App\Models\vote\VoteComment;
use App\Models\vote\FieldItem;
use Illuminate\Http\Request;
use App\Http\Requests\vote\VoteRequest;
use App\Http\Requests\vote\VoteBaseinfoRequest;
use App\Http\Requests\vote\VoteConfigRequest;
use App\Http\Requests\vote\VoteManageRequest;
use App\Http\Requests\vote\VoteCandidateRequest;
use Atorscho\Crumbs\CrumbsFacade;
use Auth;
use Excel;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Extensions\Common;


class VoteController extends AdminBaseController
{
    use Common;

    private $voteRep;

    public function __construct(voteRep $voteRep) {
        $this->voteRep = $voteRep;

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $title = $request->input('title');

        $voteModel = new Vote();
        $candidateModel = new Candidate();
        if ($title != '') {
            $voteModel = $voteModel->where('title', 'like', '%'.$title.'%');
        }

        $voteList = $voteModel->where('status', '=', 1)->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));
        foreach ($voteList as $item) {
            $item->candidateAllNum = $candidateModel->where('vote_id', '=', $item->id)->where('status', '<>', 3)->count();
            $item->candidateUncheckNum = $candidateModel->where('vote_id', '=', $item->id)->where('status', '=', 1)->count();
            $item->candidateLockNum = $candidateModel->where('vote_id', '=', $item->id)->where('status', '=', 2)->count();
        }

        CrumbsFacade::addCurrent("投票列表");
        return view('admin.vote.list', ['list'=>$voteList]);
    }

    public function getExtendFieldList ($id) {
        $vote = Vote::findOrFail($id);
        $extendFieldList = FieldItem::where('vote_id', '=', $id)->paginate(config('admin.pageNum'));

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::addCurrent("扩展字段");
        return view('admin.vote.extend-field-list', [
            'extendFieldList' => $extendFieldList,
            'vote' => $vote,
        ]);
    }

    public function getExtendFieldAdd ($id) {
        $vote = Vote::findOrFail($id);

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::add(route('admin.vote.getExtendFieldList', ['id'=>$vote->id]), " '{$vote->title}' 扩展字段");
        CrumbsFacade::addCurrent("新增扩展字段");
        return view('admin.vote.extend-field-add', [
            'vote' => $vote,
        ]);
    }

    public function postExtendFieldAdd ($id, Request $request) {
        $data = $request->except('_token');
        $data['vote_id'] = $id;

        if ($request->input('field_type')=='select') {
            $data['select_values'] = serialize(explode(',', $request->input('select_values')));
        }

        if (FieldItem::create($data) instanceof FieldItem) {
            return redirect()->route('admin.vote.getExtendFieldList', ['id'=>$id])->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getExtendFieldEdit ($id, $fid) {
        $vote = Vote::findOrFail($id);
        $extendField = FieldItem::findOrFail($fid);

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::add(route('admin.vote.getExtendFieldList', ['id'=>$vote->id]), " '{$vote->title}' 扩展字段");
        CrumbsFacade::addCurrent("编辑扩展字段");
        return view('admin.vote.extend-field-edit', [
            'vote' => $vote,
            'extendField' => $extendField,
        ]);
    }

    public function postExtendFieldEdit (Request $request) {
        $data = $request->except('_token', 'id');

        if (FieldItem::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.vote.getExtendFieldList', ['id'=>$request->input('vote_id')])->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getAdd () {
        if (! Auth::guard('admin')->user()->can('vote-add')) {
            abort(403);
        }

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::addCurrent("新增投票");
        return view('admin.vote.add');
    }

    public function postAdd (VoteRequest $request) {
        if (! Auth::guard('admin')->user()->can('vote-add')) {
            abort(403);
        }

        $data = $request->except('_token');

        if (Vote::create($data) instanceof Vote) {
            return redirect()->route('admin.vote.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        if (! Auth::guard('admin')->user()->can('vote-edit')) {
            abort(403);
        }

        $vote = Vote::findOrFail($id);

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::addCurrent("编辑投票");
        return view('admin.vote.edit', ['vote'=>$vote]);
    }

    public function postEdit (VoteRequest $request) {
        if (! Auth::guard('admin')->user()->can('vote-edit')) {
            abort(403);
        }

        $data = $request->except('_token', 'id');

        if (Vote::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.vote.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getBaseinfo ($id) {
        if (! Auth::guard('admin')->user()->can('vote-baseinfo')) {
            abort(403);
        }

        $vote = Vote::findOrFail($id);

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::addCurrent("投票基本信息");
        return view('admin.vote.baseinfo', ['vote'=>$vote]);
    }

    public function postBaseinfo (VoteBaseinfoRequest $request) {
        if (! Auth::guard('admin')->user()->can('vote-baseinfo')) {
            abort(403);
        }

        $data = $request->except('_token', 'id');
        $data['photo_size'] = $request->input('photo_size') * 1024;

        if (Vote::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.vote.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getConfig ($id) {
        if (! Auth::guard('admin')->user()->can('vote-config')) {
            abort(403);
        }

        $vote = Vote::findOrFail($id);

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::addCurrent("投票配置信息");
        return view('admin.vote.config', ['vote'=>$vote]);
    }

    public function postConfig (VoteConfigRequest $request) {
        if (! Auth::guard('admin')->user()->can('vote-config')) {
            abort(403);
        }

        $data = $request->except('_token', 'id');

        if (Vote::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.vote.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getManage ($id) {
        if (! Auth::guard('admin')->user()->can('vote-manage')) {
            abort(403);
        }

        $vote = Vote::findOrFail($id);

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::addCurrent("投票管理");
        return view('admin.vote.manage', ['vote'=>$vote]);
    }

    public function postManage (VoteManageRequest $request) {
        if (! Auth::guard('admin')->user()->can('vote-manage')) {
            abort(403);
        }

        $data = $request->except('_token', 'id');

        // 如果允许投票时间为空字符串，则unset掉，避免插入00000:0000:000，导入以后的编辑从0年开始
        if ($data['vote_start_time']=='' || $data['vote_end_time']=='') {
            unset($data['vote_start_time']);
            unset($data['vote_end_time']);
        }


        if (Vote::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.vote.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function postThrottleWhiteList (Request $request) {
        if (! Auth::guard('admin')->user()->can('vote-manage')) {
            return response('Unauthorized.', 403);
        }

        $vote = Vote::findOrFail($request->input('id'));

        if ($vote->throttle_white_list) {
            $throttleWhiteList = Candidate::whereIn('id', unserialize($vote->throttle_white_list))->get();
            $notThrottleWhiteList = Candidate::whereNotIn('id', unserialize($vote->throttle_white_list))->where('vote_id', '=', $request->input('id'))->get();
        } else {
            $throttleWhiteList = '';
            $notThrottleWhiteList = Candidate::where('vote_id', '=', $request->input('id'))->get();
        }


        return response()->json([
            'white_list' => $throttleWhiteList,
            'not_white_list' => $notThrottleWhiteList,
        ]);
    }

    public function postThrottleWhiteRemove (Request $request) {
        if (! Auth::guard('admin')->user()->can('vote-manage')) {
            return response('Unauthorized.', 403);
        }

        $id = $request->input('id');
        $cid = $request->input('cid');

        $vote = Vote::findOrFail($id);
        $candidate = Candidate::findOrFail($cid)->toArray();

        // here we can make sure that
        // throttle white list is not empty.
        $throttleWhiteList = unserialize($vote->throttle_white_list);
        $key = array_search($cid, $throttleWhiteList);
        if ($key !== false) {
            array_splice($throttleWhiteList, $key, 1);

            // save it
            // caution: decide if $throttleWhiteList is an empty array.
            Vote::where('id', '=', $id)->update(['throttle_white_list'=>($throttleWhiteList ? serialize($throttleWhiteList) : '')]);
            return response()->json($candidate);
        } else {
            return response()->json(false);
        }
    }

    public function postThrottleWhiteAdd (Request $request) {
        if (! Auth::guard('admin')->user()->can('vote-manage')) {
            return response('Unauthorized.', 403);
        }

        $id = $request->input('id');
        $cid = $request->input('cid');

        $vote = Vote::findOrFail($id);
        $candidate = Candidate::findOrFail($cid)->toArray();

        if ($vote->throttle_white_list=='') {
            $throttleWhiteList = [];
        } else {
            $throttleWhiteList = unserialize($vote->throttle_white_list);
        }
        array_push($throttleWhiteList, $cid);

        // save it
        Vote::where('id', '=', $id)->update(['throttle_white_list'=>serialize($throttleWhiteList)]);

        return response()->json($candidate);
    }

    public function getDelete ($id) {
        if (! Auth::guard('admin')->user()->can('vote-delete')) {
            abort(403);
        }

        if (Vote::where('id', '=', $id)->update(['status'=>-1])) {
            return redirect()->route('admin.vote.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }

    public function getCandidateList (Request $request, $id) {
        $kwd = $request->input('kwd');
        $status = $request->input('status');

        $candidateModel = new Candidate();
        if ($kwd != '') {
            if (is_numeric($kwd)) {
                $candidateModel = $candidateModel->where('no', '=', $kwd);
            } else {
                $candidateModel = $candidateModel->where('name', 'like', '%'.$kwd.'%');
            }
        }
        if ($status != '' && $status != -1) {
            $candidateModel = $candidateModel->where('status', '=', $status);
        } else {
            $candidateModel = $candidateModel->where('status', '<>', 3);
        }

        $candidateList = $candidateModel->where('vote_id', '=', $id)->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));

        $vote = Vote::findOrFail($id);
        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::addCurrent(" '{$vote->title}' 选手列表");
        return view('admin.vote.candidate-list', ['list'=>$candidateList, 'id'=>$id]);
    }

    public function getCandidateAdd ($id) {
        if (! Auth::guard('admin')->user()->can('candidate-add')) {
            abort(403);
        }

        $vote = Vote::findOrFail($id);

        // get the extend field list
        $extendFieldList = FieldItem::where('vote_id', '=', $id)->get();
        foreach ($extendFieldList as $k => $v) {
            if ($v->field_type=='select') {
                $extendFieldList[$k]->select_values = unserialize($v->select_values);
            }
        }

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::add(route('admin.vote.getCandidateList', ['id'=>$vote->id]), " '{$vote->title}' 选手列表");
        CrumbsFacade::addCurrent("新增选手");
        return view('admin.vote.candidate-add', [
            'vote' => $vote,
            'extendFieldList' => $extendFieldList,
        ]);
    }

    public function postCandidateAdd (VoteCandidateRequest $request) {
        if (! Auth::guard('admin')->user()->can('candidate-add')) {
            abort(403);
        }

        $voteId = $request->input('vote_id');
        $tel = $request->input('tel');

        $candidateModel = new Candidate();
        $duplicateItem = $candidateModel->where('vote_id', '=', $voteId)->where('tel', '=', $tel)->first();
        if ($duplicateItem && ! empty($duplicateItem->tel)) {
            return back()->with('fail', '手机号码已经存在');
        }

        $extendFieldList = FieldItem::where('vote_id', '=', $voteId)->get()->pluck('field_name')->toArray();
        $extendFieldListLength = count($extendFieldList);
        $extendFieldList[] = '_token';
        $data = $request->except($extendFieldList);

        $data['no'] = ($candidateModel->where('vote_id', '=', $voteId)->max('no')) + 1;

        $newCandidate = $candidateModel->create($data);
        if ($newCandidate instanceof Candidate) {
            $extendFieldValues = array_slice($request->all(), -$extendFieldListLength, $extendFieldListLength, true);
            FieldValue::create([
                'candidate_id' => $newCandidate->id,
                'values' => serialize($extendFieldValues),
            ]);
            return redirect()->route('admin.vote.getCandidateList', ['id'=>$voteId])->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getCandidateExport ($id) {
        if (! Auth::guard('admin')->user()->can('candidate-export')) {
            abort(403);
        }

        $candidateList = Candidate::where('vote_id', '=', $id)->where('status', '<>', 3)->get();
        
        Excel::create("选手列表", function($excel) use($candidateList)
        {
            $excel->sheet('sheet1',function($sheet)  use($candidateList)
            {
                $sheet->fromModel($candidateList);
            });
        })->export('xls');
    }

    public function postCandidateImport ($id, Request $request) {
        if (! Auth::guard('admin')->user()->can('candidate-import')) {
            abort(403);
        }

        //dd($request->all());
        Excel::selectSheetsByIndex(0)->load($request->file('file')->getRealPath(), function($reader) {

            // Getting all results.
            $results = $reader->get();
             dd($results);

            foreach ($results as $key => $item) {
//                $insertData = [
//                    'vote_id' => $id,
//                    'no' => ($key+1),
//                    'name' => $item->name,
//                    'desc' => $item->desc,
//                    'pic_url' => $item->pic_url,
//                    'rank' => $item->rank==null ? '' : $item->rank,
//                    'type' => 1,
//                ];
                $insertData = [
                    'vote_id' => 12,
                    'no' => ($key+85),
                    'name' => $item->name,
                    'sex' => $item->sex=='女' ? 1 : 0,
                    'desc' => $item->desc==null ? '' : $item->desc,
                    'pic_url' => $item->pic_url==null ? '' : $item->pic_url,
                    'title' => $item->title==null ? '' : $item->title,
                    'of_hospital' => $item->of_hospital,
                    'of_dep' => $item->of_dep==null ? '' : $item->of_dep==null,
                    'type' => 0,
                    'status' => 1,
                ];
                Candidate::create($insertData);
            }

            dd('ok....insert records ' . ($key+1));
        });
    }

    public function getCandidateEdit ($id, $cid) {
        if (! Auth::guard('admin')->user()->can('candidate-edit')) {
            abort(403);
        }

        $candidate = Candidate::findOrFail($cid);
        $vote = Vote::findOrFail($id);

        $extendFieldList = FieldItem::where('vote_id', '=', $id)->get();
        if (count($extendFieldList)>0) {
            $extendFieldListArr = $extendFieldList->pluck('field_name')->toArray();
            foreach ($extendFieldList as $k => $v) {
                if ($v->field_type=='select') {
                    $extendFieldList[$k]->select_values = unserialize($v->select_values);
                }
            }
            $extendFieldValues = FieldValue::where('candidate_id', '=', $cid)->first();        
            if ($extendFieldValues!=null) {
                $extendFieldValuesArr = unserialize($extendFieldValues->values);
            } else {            
                foreach ($extendFieldListArr as $item) {
                    $extendFieldValuesArr[$item] = '';
                }
            }
        } else {
            $extendFieldValuesArr = [];
        }      

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::add(route('admin.vote.getCandidateList', ['id'=>$id]), " '{$vote->title}' 选手列表");
        CrumbsFacade::addCurrent("编辑选手");
        return view('admin.vote.candidate-edit', [
            'candidate' => $candidate,
            'extendFieldList' => $extendFieldList,
            'extendFieldValuesArr' => $extendFieldValuesArr,
        ]);
    }

    public function postCandidateEdit (Request $request) {
        if (! Auth::guard('admin')->user()->can('candidate-edit')) {
            abort(403);
        }

        // I can't find a more elegant way to organize my code below for now,
        // although it's a little bit stupid to judge whether tel field
        // has been changed like that, it's a must to verify.Fix it later.
        $candidateModel = new Candidate();
        $candidate = $candidateModel->find($request->input('id'));
        $validataTelRule = $candidate->tel == $request->input('tel') ?
            'sometimes|regex:/^1[345789][0-9]{9}$/' :
            'sometimes|regex:/^1[345789][0-9]{9}$/|unique:candidate,tel';
        $validataTelMsg = $candidate->tel == $request->input('tel') ?
            [
                'tel.unique' => '该手机号已经存在',
            ] :
            [
                'tel.regex' => '手机号格式不正确',
                'tel.unique' => '该手机号已经存在',
            ];

        $validataMsg = [
            'name.required' => '名称不能为空',
            'name.max' => '名称长度不能超过255',
        ];
        $this->validate($request, [
            'name' => 'required|max:255',
            'tel' => $validataTelRule,
        ], array_merge($validataMsg, $validataTelMsg));

        //$data = $request->except('_token', 'id');
        $extendFieldList = FieldItem::where('vote_id', '=', $candidate->vote_id)->get()->pluck('field_name')->toArray();
        $extendFieldListLength = count($extendFieldList);
        $extendFieldList[] = '_token';
        $extendFieldList[] = 'id';
        $data = $request->except($extendFieldList);

        if ($candidateModel->where('id', '=', $request->input('id'))->update($data)) {
            $extendFieldValues = array_slice($request->all(), -$extendFieldListLength, $extendFieldListLength, true);
            FieldValue::where('candidate_id', '=', $candidate->id)->update(['values' => serialize($extendFieldValues)]);
            return redirect()->route('admin.vote.getCandidateList', ['id'=>$candidate->vote_id])->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getCandidateChangeStatus ($id, $cid, $status) {
        if (! Auth::guard('admin')->user()->can('candidate-check')) {
            abort(403);
        }

        $candidateModel = new Candidate();

        if ($candidateModel->where('id', '=', $cid)->update(['status'=>$status])) {
            return redirect()->route('admin.vote.getCandidateList', ['id'=>$id])->with('suc', '修改状态成功');
        } else {
            return back()->with('fail', '修改状态失败');
        }
    }

    public function getCandidateDelete ($id) {
        if (! Auth::guard('admin')->user()->can('candidate-delete')) {
            abort(403);
        }

        $candidateModel = new Candidate();
        $candidate = $candidateModel->find($id);

        if ($candidateModel->where('id', '=', $id)->update(['status'=>3])) {
            return redirect()->route('admin.vote.getCandidateList', ['id'=>$candidate->vote_id])->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }

    public function getCandidateVoteHistory ($id, $cid) {
        if (! Auth::guard('admin')->user()->can('candidate-vote-history')) {
            abort(403);
        }

        $voteLogModel = new VoteLog();
        //$voteModel = new Vote();

        $vote = Vote::findOrFail($id);

        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $begin_day = date('Y-m-d', strtotime($vote->start_time));
            $days = [];
            $votes = [];
            for ($i=strtotime($begin_day);$i<=strtotime($vote->end_time);$i+=86400) {
                $days[] = date('m,d', $i);
                $vote_log_table_suffix = ceil((($i+86400)-strtotime($vote->start_time)) / 86400);
                $vote_log_table_name = 'vote_log_' . $vote_log_table_suffix;
                $votes[] = DB::table($vote_log_table_name)->where('vote_id', '=', $id)->where('item_id', '=', $cid)->count();
            }
        } else {
            // TODO optimize the sql later.
            $days = $voteLogModel->where('vote_id', '=', $id)->where('item_id', '=', $cid)->groupBy('time_key')->get()->pluck('time_key')->toArray();
            $votes = [];
            foreach ($days as $day) {
                $votes[] = $voteLogModel->where('vote_id', '=', $id)->where('item_id', '=', $cid)->where('time_key', '=', $day)->count();
            }
            foreach ($days as $k => $v) {
                $days[$k] = date('m,d', $v);
            }
        }

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::add(route('admin.vote.getCandidateList', ['id'=>$id]), " '{$vote->title}' 选手列表");
        CrumbsFacade::addCurrent("投票历史");
        return view('admin.vote.candidate-vote-history', ['days'=>json_encode($days), 'votes'=>json_encode($votes), 'vote'=>$vote]);
    }

    public function getVoterList (Request $request, $id, $cid) {
        if (! Auth::guard('admin')->user()->can('candidate-voter-list')) {
            abort(403);
        }

        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');

        $voteLogModel = new VoteLog();

        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $vote = DB::table('vote')->where('id', '=', $id)->first();
            $voter_list = [];
            if ($start_time != '' && $end_time != '') {
                $vote_log_table_suffix_start = ceil((strtotime($start_time)-strtotime($vote->start_time)) / 86400);
                $vote_log_table_name_start = 'vote_log_' . $vote_log_table_suffix_start;
                $vote_log_table_suffix_end = ceil((strtotime($end_time)-strtotime($vote->start_time)) / 86400);
                $vote_log_table_name_end = 'vote_log_' . $vote_log_table_suffix_end;

                if ($vote_log_table_suffix_start==$vote_log_table_suffix_end) {
                    $voter_list = DB::table($vote_log_table_name_start)
                        ->whereBetween ($vote_log_table_name_start.'.log_time', [strtotime($start_time), strtotime($end_time)])
                        ->join('vote_wxuser', function ($join) use ($id, $cid, $vote_log_table_name_start) {
                            $join->on('vote_wxuser.id', '=', $vote_log_table_name_start.'.user_id')
                                ->where($vote_log_table_name_start.'.vote_id', '=', $id)
                                ->where($vote_log_table_name_start.'.item_id', '=', $cid);
                        })->select(['*'])->get();
                }
                if (($vote_log_table_suffix_end-$vote_log_table_suffix_start)==1) {
                    $mid_time = strtotime($vote->start_time)+$vote_log_table_suffix_start*86400;
                    $voter_list_temp1 = DB::table($vote_log_table_name_start)
                        ->whereBetween ($vote_log_table_name_start.'.log_time', [strtotime($start_time), $mid_time])
                        ->join('vote_wxuser', function ($join) use ($id, $cid, $vote_log_table_name_start) {
                            $join->on('vote_wxuser.id', '=', $vote_log_table_name_start.'.user_id')
                                ->where($vote_log_table_name_start.'.vote_id', '=', $id)
                                ->where($vote_log_table_name_start.'.item_id', '=', $cid);
                        })->select(['*'])->get();
                    $voter_list_temp2 = DB::table($vote_log_table_name_end)
                        ->whereBetween ($vote_log_table_name_end.'.log_time', [$mid_time, strtotime($end_time)])
                        ->join('vote_wxuser', function ($join) use ($id, $cid, $vote_log_table_name_end) {
                            $join->on('vote_wxuser.id', '=', $vote_log_table_name_end.'.user_id')
                                ->where($vote_log_table_name_end.'.vote_id', '=', $id)
                                ->where($vote_log_table_name_end.'.item_id', '=', $cid);
                        })->select(['*'])->get();
                    $voter_list = array_merge($voter_list, $voter_list_temp1, $voter_list_temp2);
                }
                if (($vote_log_table_suffix_end-$vote_log_table_suffix_start)>1) {
                    for ($i=$vote_log_table_suffix_start;$i<=$vote_log_table_suffix_end;$i++) {
                        $where_start_time = '';
                        $where_end_time = '';
                        $vote_log_table_temp = '';
                        if ($i==$vote_log_table_suffix_start) {
                            $where_start_time = strtotime($start_time);
                        } else {
                            $where_start_time = strtotime($vote->start_time)+($i-1)*86400;
                        }
                        if ($i==$vote_log_table_suffix_end) {
                            $where_end_time = strtotime($end_time);
                        } else {
                            $where_end_time = strtotime($vote->start_time)+$i*86400;
                        }
                        $vote_log_table_temp = 'vote_log_' . $i;
                        $voter_list_temp = DB::table($vote_log_table_temp)
                            ->whereBetween ($vote_log_table_temp.'.log_time', [$where_start_time, $where_end_time])
                            ->join('vote_wxuser', function ($join) use ($id, $cid, $vote_log_table_temp) {
                                $join->on('vote_wxuser.id', '=', $vote_log_table_temp.'.user_id')
                                    ->where($vote_log_table_temp.'.vote_id', '=', $id)
                                    ->where($vote_log_table_temp.'.item_id', '=', $cid);
                            })->select(['*'])->get();
                        $voter_list = array_merge($voter_list, $voter_list_temp);
                    }
                }
            } else {
                $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
                for ($i=1;$i<=$vote_log_table_suffix;$i++) {
                    $vote_log_table_name = 'vote_log_' . $i;
                    $voter_list_temp = DB::table($vote_log_table_name)
                        ->join('vote_wxuser', function ($join) use ($id, $cid, $vote_log_table_name) {
                            $join->on('vote_wxuser.id', '=', $vote_log_table_name.'.user_id')
                                ->where($vote_log_table_name.'.vote_id', '=', $id)
                                ->where($vote_log_table_name.'.item_id', '=', $cid);
                        })->select(['*'])->get();
                    $voter_list = array_merge($voter_list, $voter_list_temp);
                }
            }
            $perPage = config('home.pageNum');
            if ($request->has('page')) {
                $currentPage = $request->input('page');
                $currentPage = $currentPage <= 0 ? 1 :$currentPage;
            } else {
                $currentPage = 1;
            }
            $item = array_slice($voter_list, ($currentPage-1)*$perPage, $perPage);

            $paginator = new LengthAwarePaginator($item, count($voter_list), $perPage, $currentPage, [
                'path'     => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]);

            $voterList = $paginator->toArray()['data'];
        } else {
            if ($start_time != '' && $end_time != '') {
                $voteLogModel = $voteLogModel->whereBetween ('vote_log.log_time', [strtotime($start_time), strtotime($end_time)]);
            }
            $voterList = $voteLogModel
                ->join('vote_wxuser', function ($join) use ($id, $cid) {
                    $join->on('vote_wxuser.id', '=', 'vote_log.user_id')
                        ->where('vote_log.vote_id', '=', $id)
                        ->where('vote_log.item_id', '=', $cid);
                })->select(['*'])->paginate(config('admin.pageNum'));
            $paginator = '';
        }

        $vote = Vote::findOrFail($id);
        $candidate = Candidate::findOrFail($cid);


        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::add(route('admin.vote.getCandidateList', ['id'=>$id]), " '{$vote->title}' 选手列表");
        CrumbsFacade::addCurrent(" '{$candidate->name}' 用户投票列表");
        return view('admin.vote.voter-list', [
            'list'      => $voterList,
            'id'        => $id,
            'cid'       => $cid,
            'paginator' => $paginator,
        ]);
    }

    public function getCandidateVoteManage ($id, $cid) {
        if (! Auth::guard('admin')->user()->can('candidate-vote-manage')) {
            abort(403);
        }

        $candidate = Candidate::findOrFail($cid);
        $vote = Vote::findOrFail($id);

        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::add(route('admin.vote.getCandidateList', ['id'=>$id]), " '{$vote->title}' 选手列表");
        CrumbsFacade::addCurrent("用户投票管理");
        return view('admin.vote.candidate-vote-manage', ['candidate'=>$candidate]);
    }

    public function postCandidateVoteManage (VoteManageRequest $request) {
        if (! Auth::guard('admin')->user()->can('candidate-vote-manage')) {
            abort(403);
        }

        $data = $request->except('_token', 'id', 'vote_id');

        if (Candidate::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.vote.getCandidateList', ['id'=>$request->input('vote_id')])->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getVoteList ($id, $wid) {
        if (! Auth::guard('admin')->user()->can('user-vote-list')) {
            abort(403);
        }

        $voteLogModel = new VoteLog();

        $vote = Vote::findOrFail($id);
        $wxuser = Wxuser::findOrFail($wid);

        if (env('VOTE_LOG_SPLIT_TABLE')) {
            $candidates = [];
            $vote_log_table_suffix = ceil((time()-strtotime($vote->start_time)) / 86400);
            for ($i=1;$i<=$vote_log_table_suffix;$i++) {
                $vote_log_table_name = 'vote_log_' . $i;
                $candidates_temp = DB::table($vote_log_table_name)
                    ->join('candidate', function ($join) use ($id, $wid, $vote_log_table_name) {
                        $join->on('candidate.id', '=', $vote_log_table_name.'.item_id')
                            ->where($vote_log_table_name.'.vote_id', '=', $id)
                            ->where($vote_log_table_name.'.user_id', '=', $wid);
                    })->groupBy($vote_log_table_name.'.item_id')->select(['*'])->pluck($vote_log_table_name.'.item_id', 'candidate.name')->toArray();
                foreach ($candidates_temp as $k => $v) {
                    $candidates_temp[$k] = DB::table($vote_log_table_name)->where('vote_id', '=', $id)->where('item_id', '=', $v)->where('user_id', '=', $wid)->count();
                }
                $candidates = $this->array_value_sum($candidates, $candidates_temp);
            }
        } else {
            // TODO optimize the sql later.
            $candidates = $voteLogModel
                ->join('candidate', function ($join) use ($id, $wid) {
                    $join->on('candidate.id', '=', 'vote_log.item_id')
                        ->where('vote_log.vote_id', '=', $id)
                        ->where('vote_log.user_id', '=', $wid);
                })->groupBy('vote_log.item_id')->select(['*'])->pluck('vote_log.item_id', 'candidate.name')->toArray();
            foreach ($candidates as $k => $v) {
                $candidates[$k] = $voteLogModel->where('vote_id', '=', $id)->where('item_id', '=', $v)->where('user_id', '=', $wid)->count();
            }
        }


        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::add(route('admin.vote.getCandidateList', ['id'=>$id]), " '{$vote->title}' 选手列表");
        CrumbsFacade::addCurrent(" '{$wxuser->nickname}' 被投人列表");
        return view('admin.vote.vote-list', ['list'=>$candidates]);
    }
    
    public function getCommetList (Request $request,$id) {
        if (! Auth::guard('admin')->user()->can('comment_verify')) {
            abort(403);
        }

        $status = $request->input('status');
        $voteCommentModel = new VoteComment();
        
        if ($status == -1 || $status===null) {
            $commentList = $voteCommentModel->where('vote_id', '=', $id)->where('status', '<>',3)->orderBy('status', 'desc')->orderBy('comment_time', 'desc')->paginate(config('admin.pageNum'));
        }else{
            $commentList = $voteCommentModel->where('vote_id', '=', $id)->where('status', '=', $status)->orderBy('status', 'desc')->orderBy('comment_time', 'desc')->paginate(config('admin.pageNum'));
        }
        
        CrumbsFacade::add('admin/vote/list', "投票列表");
        CrumbsFacade::addCurrent("评论审核列表");
        return view('admin.vote.vote-comment-list', ['list'=>$commentList,'id'=>$id]);
    }
    
    public function getCommetEdit (Request $request,$id,$cid,$tid) {
        if (! Auth::guard('admin')->user()->can('comment_verify')) {
            abort(403);
        }

        $voteCommentModel = new VoteComment();
        
        if ($voteCommentModel->where('id', '=', $cid)->update(['status'=>$tid])) {
            return redirect()->route('admin.vote.getCommetList', ['id'=>$id])->with('suc', '修改或删除成功');
        } else {
            return back()->with('fail', '修改或删除失败');
        }
    }
}