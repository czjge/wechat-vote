<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 17:06
 */
namespace App\Http\Controllers\Admin\familydoctor;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\familydoctor\DoctorRequest;
use App\Models\familydoctor\Community;
use App\Models\familydoctor\Doctor;
use App\Models\core\ClassifyType;
use App\Models\familydoctor\Team;
use Illuminate\Http\Request;
use Atorscho\Crumbs\CrumbsFacade;

class DoctorController extends AdminBaseController
{
    public function __construct() {

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $team_id = $request->input('team_id');
        $community_id = $request->input('community_id');
        $name = $request->input('name');
        $status = $request->input('status');

        $where = [];
        if ($community_id) {
            $where[] = ['community_id', '=', $community_id];
            $team_list = Team::where('community_id', '=', $community_id)->get();
        } else {
            $team_list = [];
        }
        if ($team_id) {
            $where[] = ['team_id', '=', $team_id];
        }
        if ($name) {
            $where[] = ['name', 'like', '%'.$name.'%'];
        }
        if (in_array($status, ['0', '1', '-1'])) {
            $where[] = ['status', '=', $status];
        }
        $dcotor_list = Doctor::where($where)->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));
        $community_list = Community::get();


        CrumbsFacade::addCurrent("医生列表");
        return view('admin.fd-doctor.list', [
            'dcotor_list'    => $dcotor_list,
            'community_list' => $community_list,
            'team_list'      => $team_list,
        ]);
    }

    public function ajaxGetTeams ($cid) {
        $team_list = Team::where('community_id', '=', $cid)->where('status', '=', 1)->get();

        $retval[] = [
            'id'   => 0,
            'text' => '请选择',
        ];
        foreach ($team_list as $item) {
            $temp = [];
            $temp['id']   = $item->id;
            $temp['text'] = $item->name;
            $retval[] = $temp;
        }

        return response()->json($retval);
    }

    public function getAdd () {
        $tags = ClassifyType::where('type', '=', 3)->where('status', '=', 1)->get();
        $community_list = Community::get();
        $initial_team = Team::where('community_id', '=', $community_list['0']->id)->get();

        CrumbsFacade::add(route('admin.familydoctor.doctor.list'), "医生列表");
        CrumbsFacade::addCurrent("新增医生");
        return view('admin.fd-doctor.add', [
            'tags'           => $tags,
            'community_list' => $community_list,
            'initial_team'   => $initial_team,
        ]);
    }

    public function postAdd (DoctorRequest $request) {
        //dd($request->all());
        $data = $request->except('_token');

        // avatars
//        if ($request->hasFile('avatars')) {
//            $avatars_array = $request->file('avatars');
//            $avatars_url_array = [];
//            foreach ($avatars_array as $avatars_item) {
//                $avatars_url_array[] = $this->uploadSingleFile($avatars_item);
//            }
//            $data['avatars'] = serialize($avatars_url_array);
//        } else {
//            $data['avatars'] = '';
//        }
        $avatars_array = array_filter($request->input('avatars')); // 去掉空值
        $data['avatars'] = serialize($avatars_array);

        // schedule_time
        $schedule_time = [];
        for ($i=1;$i<=7;$i++) {
            for ($j=1;$j<=3;$j+=2) {
                $schedule_time[$i . '_' . $j] = $data[$i . '_' . $j];
            }
        }
        $data['schedule_time'] = serialize($schedule_time);

        // adept_tag
        if (isset($data['adept_tag'])) {
            foreach ($data['adept_tag'] as $k => $v) {
                if (! is_numeric($v)) {
                    $tag = ClassifyType::where('name', '=', $v)->where('type', '=', 3)->first();
                    $data['adept_tag'][$k] = $tag['id'];
                }
            }
            $data['adept_tag'] = implode(',', $data['adept_tag']);
        }


        if (Doctor::create($data) instanceof Doctor) {
            return redirect()->route('admin.familydoctor.doctor.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $doctor = Doctor::findOrFail($id);
        $tags = ClassifyType::where('type', '=', 3)->where('status', '=', 1)->get();
        $community_list = Community::get();
        if ($doctor->community_id!=0) {
            $initial_team = Team::where('community_id', '=', Community::where('id', '=', $doctor->community_id)->first()->id)->get();
        } else {
            $initial_team = Team::where('community_id', '=', $community_list['0']->id)->get();
        }

        // schedule_time
        $scheduleTime = unserialize($doctor->schedule_time);
        $scheduleTimeArr = [];
        if ($scheduleTime) {
            foreach ($scheduleTime as $key => $value) {
                if ($value == '1') {
                    $scheduleTimeArr[] = $key;
                }
            }
        }


        CrumbsFacade::add(route('admin.familydoctor.doctor.list'), "医生列表");
        CrumbsFacade::addCurrent("编辑医生");
        return view('admin.fd-doctor.edit', [
            'doctor'         => $doctor,
            'tags'           => $tags,
            '_tags'          => explode(',', $doctor->adept_tag),
            'scheduleTime'   => implode('@', $scheduleTimeArr),
            'community_list' => $community_list,
            'initial_team'   => $initial_team,
            'avatars'        => unserialize($doctor->avatars),
        ]);
    }

    public function postEdit (DoctorRequest $request) {
        //dd($request->all());
        $id = $request->input('id');

        $data = $request->except('_token', 'id');

        // avatars
//        if (isset($data['_avatars'])) {
//            if ($request->hasFile('avatars')) {
//                if (count($data['_avatars'])==count($data['avatars'])) {
//                    $new_avatars_array = $request->file('avatars');
//                    foreach ($new_avatars_array as $key => $new_avatars_item) {
//                        if ($new_avatars_item!=null) {
//                            $data['_avatars'][$key] = $this->uploadSingleFile($new_avatars_item);
//                        }
//                    }
//                } else {
//                    $new_avatars_array = $request->file('avatars');
//                    foreach ($new_avatars_array as $new_avatars_item) {
//                        if ($new_avatars_item!=null) {
//                            $data['_avatars'][] = $this->uploadSingleFile($new_avatars_item);
//                        }
//                    }
//                }
//            }
//            $data['avatars'] = serialize($data['_avatars']);
//            unset($data['_avatars']);
//        } else {
//            $data['avatars'] = '';
//        }
        $avatars_array = array_filter($request->input('avatars')); // 去掉空值
        $data['avatars'] = serialize($avatars_array);

        // schedule_time
        $schedule_time = [];
        for ($i=1;$i<=7;$i++) {
            for ($j=1;$j<=3;$j+=2) {
                $schedule_time[$i . '_' . $j] = $data[$i . '_' . $j];
            }
        }
        $data['schedule_time'] = serialize($schedule_time);
        foreach ($data as $k => $v) {
            if ((int) substr( $k, 0, 1 ) > 0) {
                unset($data[$k]);
            }
        }

        // adept_tag
        if (isset($data['adept_tag'])) {
            foreach ($data['adept_tag'] as $k => $v) {
                if (! is_numeric($v)) {
                    $tag = ClassifyType::where('name', '=', $v)->where('type', '=', 3)->first();
                    $data['adept_tag'][$k] = $tag['id'];
                }
            }
            $data['adept_tag'] = implode(',', $data['adept_tag']);
        } else {
            $data['adept_tag'] = '';
        }


        if (Doctor::where('id', '=', $id)->update($data)) {
            return redirect()->route('admin.familydoctor.doctor.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        if (Doctor::where('id', '=', $id)->delete()) {
            return redirect()->route('admin.familydoctor.doctor.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }
}