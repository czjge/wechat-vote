<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 17:06
 */
namespace App\Http\Controllers\Admin\core;

use App\Http\Controllers\AdminBaseController;
use App\Models\core\Doctor;
use App\Models\core\Hospital;
use App\Models\core\Department;
use App\Models\core\DiseaseType;
use App\Models\core\ClassifyType;
use App\Models\core\HealthCircle;
use App\Models\core\Users;
use App\Repositories\core\DoctorRepository as DocRep;
use App\Http\Requests\core\DoctorRequest;
use Illuminate\Http\Request;
use Atorscho\Crumbs\CrumbsFacade;

class DoctorController extends AdminBaseController
{
    private $docRep;

    public function __construct(DocRep $docRep) {
        $this->docRep = $docRep;

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $hid = $request->input('hid');
        $department_id = $request->input('department_id');
        $name = $request->input('name');
        $is_hao = $request->input('is_hao');
        $label = $request->input('label');
        $status = $request->input('status');

        $where = [];
        if ($hid) {
            $where[] = ['hid', '=', $hid];
            $departmentList = Department::where('hid', '=', $hid)->get();
        } else {
            $departmentList = [];
        }
        if ($department_id) {
            $where[] = ['department_id', '=', $department_id];
        }
        if ($name) {
            $where[] = ['name', 'like', '%'.$name.'%'];
        }
        if (in_array($is_hao, ['0', '1'])) {
            $where[] = ['is_hao', '=', $is_hao];
        }
        if (in_array($status, ['0', '1', '2'])) {
            $where[] = ['status', '=', $status];
        }

        $builder = Doctor::where($where);

        if ($label) {
            $builder = $builder->whereRaw('FIND_IN_SET(' . $label . ',label)');
        }
        $doctorList = $builder->with('hospital')->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));

        $hospitalList = Hospital::get();
        $diseaseType = DiseaseType::where('status', '=', 1)->get();

        CrumbsFacade::addCurrent("医生列表");
        return view('admin.doctor.list', [
            'doctorList' => $doctorList,
            'hospitalList' => $hospitalList,
            'departmentList' => $departmentList,
            'diseaseType' => $diseaseType,
        ]);
    }

    public function ajaxGetDeps ($hid) {
        $departmentList = Department::where('hid', '=', $hid)->where('status', '=', 1)->get();

        $retval = [];
        foreach ($departmentList as $item) {
            $temp = [];
            $temp['id'] = $item->id;
            $temp['text'] = $item->name;
            $retval[] = $temp;
        }

        return response()->json($retval);
    }

    public function ajaxGetAddTag ($name) {
        if (is_numeric($name)) {
            exit;
        }

        $count = ClassifyType::where('name', '=', $name)->where('type', '=', 3)->count();

        if ($count==0 && ! empty(trim($name))) {
            $data['name'] = $name;
            $data['type'] = 3;

            if ($model = ClassifyType::create($data)) {
                return response()->json($model->id);
            } else {
                return response()->json(2);
            }
        } else {
            return response()->json(0);
        }
    }

    public function getAdd () {
        $tags = ClassifyType::where('type', '=', 3)->where('status', '=', 1)->get();
        $circles = HealthCircle::where('status', '=', 1)->get();
        $labels = DiseaseType::where('status', '=', 1)->get();

        $hospitalList = Hospital::get();
        $initialDeps = Department::where('hid', '=', $hospitalList['0']->id)->get();

        CrumbsFacade::add(route('admin.doctor.list'), "医生列表");
        CrumbsFacade::addCurrent("新增医生");
        return view('admin.doctor.add', [
            'tags' => $tags,
            'circles' => $circles,
            'labels' => $labels,
            'hospitalList' => $hospitalList,
            'initialDeps' => $initialDeps,
        ]);
    }

    public function postAdd (DoctorRequest $request) {
        $name = $request->input('name');
        $hid = $request->input('hid');
        $departmentId = $request->input('department_id');
        $existDoctor = Doctor::where('name', '=', $name)->where('hid', '=', $hid)->where('department_id', '=', $departmentId)->first();
        if ($existDoctor) {
            return back()->with('fail', '同一个医院同一个科室出现同名');
        }


        //dd($request->all());
        $data = $request->except('_token');

        // 往hys_users表写数据?
        if ($data['phone']) {
            $insert_data = [
                'nickname' => substr($data['phone'], 0, 3) . '****' . substr($data['phone'], 7),
                'password' => 'ccca79fb796e217996d2572e6c0d4f47',
                'phone'    => $data['phone'],
                'vip'      => 1,
                'gold'     => 80,
                'reg_time' => time(),
                'status'   => 1,
            ];

            if (Users::where('phone', '=', $data['phone'])->first()) {
                return back()->with('fail', '该电话号码已经注册了');
            } else {
                $users = Users::create($insert_data);
            }
        } else {
            $insert_data = [
                'password' => 'ccca79fb796e217996d2572e6c0d4f47',
                'vip'      => 1,
                'gold'     => 80,
                'reg_time' => time(),
                'status'   => 1,
                'phone'    => time(), // 由于数据库该字段有唯一约束，而前台填写资料时候不一定填写手机号码
            ];

            $users = Users::create($insert_data);
        }
        unset($data['phone']);

        // 坐诊时间
        $schedule_time = [];
        for ($i=1;$i<=7;$i++) {
            for ($j=1;$j<=3;$j+=2) {
                $schedule_time[$i . '_' . $j] = $data[$i . '_' . $j];
            }
        }
        $data['schedule_time'] = serialize($schedule_time);

        // 擅长标签
        if (isset($data['adept_tag'])) {
            foreach ($data['adept_tag'] as $k => $v) {
                if (! is_numeric($v)) {
                    $tag = ClassifyType::where('name', '=', $v)->where('type', '=', 3)->first();
                    $data['adept_tag'][$k] = $tag['id'];
                }
            }
            $data['adept_tag'] = implode(',', $data['adept_tag']);
        }

        // 所属圈子
        if (isset($data['circle_ids'])) {
            $data['circle_ids'] = implode(',', $data['circle_ids']);
        }

        // 是否可以图文咨询
        $data['is_consultable'] = chr($data['is_consultable']);



        if (($doctor = Doctor::create($data)) instanceof Doctor) {
            Users::where('uid', '=', $users->uid)->update(['doc_id' => $doctor->id]);
            return redirect()->route('admin.doctor.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $doctor = Doctor::where('id', '=', $id)->first();
        $user = Users::where('doc_id', '=', $doctor->id)->first();

        $labels = DiseaseType::where('status', '=', 1)->get();
        $circles = HealthCircle::where('status', '=', 1)->get();
        $tags = ClassifyType::where('type', '=', 3)->where('status', '=', 1)->get();

        $hospitalList = Hospital::get();
        $initialDeps = Department::where('hid', '=', Hospital::where('id', '=', $doctor->hid)->first()->id)->get();

        // 是否可以图文咨询
        //$doctor->is_consultable = ord($doctor->is_consultable);

        // 如果有医生擅长标签
        if ($doctor->adept_tag) {
            //$this->assign('_tags', explode(',', $doctor['adept_tag']));
        }

        // 如果有医生所属圈子
        if ($doctor->circle_ids) {
            //$this->assign('_circle_ids', explode(',', $doctor['circle_ids']));
        }

        // 坐诊时间
        $scheduleTime = unserialize($doctor->schedule_time);
        $scheduleTimeArr = [];
        if ($scheduleTime) {
            foreach ($scheduleTime as $key => $value) {
                if ($value == '1') {
                    $scheduleTimeArr[] = $key;
                }
            }
        }


        CrumbsFacade::add(route('admin.doctor.list'), "医生列表");
        CrumbsFacade::addCurrent("编辑医生");
        return view('admin.doctor.edit', [
            'doctor' => $doctor,
            'user' => $user,
            'labels' => $labels,
            'circles' => $circles,
            'tags' => $tags,
            '_tags' => explode(',', $doctor->adept_tag),
            '_circle_ids' => explode(',', $doctor->circle_ids),
            'hospitalList' => $hospitalList,
            'initialDeps' => $initialDeps,
            'scheduleTime' => implode('@', $scheduleTimeArr),
        ]);
    }

    public function postEdit (DoctorRequest $request) {
        $name = $request->input('name');
        $hid = $request->input('hid');
        $departmentId = $request->input('department_id');
        $id = $request->input('id');

        $oldDoctor = Doctor::where('id', '=', $id)->first();
        if ($oldDoctor->name != $name) {
            $existDoctor = Doctor::where('name', '=', $name)->where('hid', '=', $hid)->where('department_id', '=', $departmentId)->first();
            if ($existDoctor) {
                return back()->with('fail', '同一个医院同一个科室出现同名');
            }
        }

        //dd($request->all());
        $data = $request->except('_token', 'id');

        // 坐诊时间
        $schedule_time = [];
        for ($i=1;$i<=7;$i++) {
            for ($j=1;$j<=3;$j+=2) {
                $schedule_time[$i . '_' . $j] = $data[$i . '_' . $j];
            }
        }
        $data['schedule_time'] = serialize($schedule_time);

        // 擅长标签
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

        // 所属圈子
        if (isset($data['circle_ids'])) {
            $data['circle_ids'] = implode(',', $data['circle_ids']);
        } else {
            $data['circle_ids'] = '';
        }

        // 是否可以图文咨询
        //$data['is_consultable'] = chr($data['is_consultable']);

        $phone = $data['phone'];
        unset($data['phone']);
        foreach ($data as $k => $v) {
            if ((int) substr( $k, 0, 1 ) > 0) {
                unset($data[$k]);
            }
        }

        if (Doctor::where('id', '=', $id)->update($data)!==false && Users::where('doc_id', '=', $id)->update(['phone'=>$phone])!==false) {
            return redirect()->route('admin.doctor.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        if (Doctor::where('id', '=', $id)->delete() && Users::where('doc_id', '=', $id)->delete()) {
            return redirect()->route('admin.doctor.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }
}