<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 17:06
 */
namespace App\Http\Controllers\Admin\core;

use App\Http\Controllers\AdminBaseController;
use App\Repositories\core\HospitalRepository as HosRep;
use App\Http\Requests\core\HospitalRequest;
use App\Models\core\Hospital;
use App\Models\core\Department;
use App\Models\core\Doctor;
use Illuminate\Http\Request;
use Atorscho\Crumbs\CrumbsFacade;

class HospitalController extends AdminBaseController
{
    private $hosRep;

    public function __construct(HosRep $hosRep) {
        $this->hosRep = $hosRep;

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $name = $request->input('name');
        $level = $request->input('level');
        $status = $request->input('status');

        $where = [];
        if ($name) {
            $where[] = ['name', 'like', '%'.$name.'%'];
        }
        if ($level) {
            $where[] = ['level', '=', $level];
        }
        if (in_array($status, ['0', '1', '2'])) {
            $where[] = ['status', '=', $status];
        }
        $hospitalList = Hospital::where($where)->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));

        CrumbsFacade::addCurrent("医院列表");
        return view('admin.hospital.list', [
            'hospitalList' => $hospitalList,
        ]);
    }

    public function getAdd () {
        CrumbsFacade::add(route('admin.hospital.list'), "医院列表");
        CrumbsFacade::addCurrent("新增医院");
        return view('admin.hospital.add');
    }

    public function postAdd (HospitalRequest $request) {
        $data = $request->except('_token');

        if (Hospital::create($data) instanceof Hospital) {
            return redirect()->route('admin.hospital.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $hospital = Hospital::findOrFail($id);

        CrumbsFacade::add(route('admin.hospital.list'), "医院列表");
        CrumbsFacade::addCurrent("编辑医院");
        return view('admin.hospital.edit', [
            'hospital' => $hospital,
        ]);
    }

    public function postEdit (Request $request) {
        $id = $request->input('id');

        $this->validate($request, [
            'name' => 'required|max:255|unique:hys_px_hospital,name,'.$id,
        ], [
            'name.required' => '医院名称不能为空',
            'name.max' => '医院名称长度不能超过255',
            'name.unique' => '医院名称不能重复',
        ]);


        $data = $request->except('_token', 'id');

        if (Hospital::where('id', '=', $id)->update($data)) {
            return redirect()->route('admin.hospital.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        if (Department::where('hid', '=', $id)->first()) {
            return back()->with('warning', '有科室关联，删除失败');
        }

        if (Doctor::where('hid', '=', $id)->first()) {
            return back()->with('warning', '有医生关联，删除失败');
        }

        if (Hospital::where('id', '=', $id)->delete()) {
            return redirect()->route('admin.hospital.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }
}