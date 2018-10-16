<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 17:06
 */
namespace App\Http\Controllers\Admin\core;

use App\Http\Controllers\AdminBaseController;
use App\Models\core\Hospital;
use App\Repositories\core\DepartmentRepository as DepRep;
use App\Http\Requests\core\DepartmentRequest;
use App\Models\core\Department;
use App\Models\core\Doctor;
use Illuminate\Http\Request;
use Atorscho\Crumbs\CrumbsFacade;

class DepartmentController extends AdminBaseController
{
    private $depRep;

    public function __construct(DepRep $depRep) {
        $this->depRep = $depRep;

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $hid = $request->input('hid');
        $name = $request->input('name');
        $status = $request->input('status');

        $where = [];
        if ($hid) {
            $where[] = ['hid', '=', $hid];
        }
        if ($name) {
            $where[] = ['name', 'like', '%'.$name.'%'];
        }
        if (in_array($status, ['0', '1', '2'])) {
            $where[] = ['status', '=', $status];
        }

        $departmentList = Department::where($where)->with('hospital')->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));
        $hospitalList = Hospital::get();

        CrumbsFacade::addCurrent("科室列表");
        return view('admin.department.list', [
            'departmentList' => $departmentList,
            'hospitalList' => $hospitalList,
        ]);
    }

    public function getAdd () {
        $hospitalList = Hospital::get();

        CrumbsFacade::add(route('admin.department.list'), "科室列表");
        CrumbsFacade::addCurrent("新增科室");
        return view('admin.department.add', [
            'hospitalList' => $hospitalList,
        ]);
    }

    public function postAdd (DepartmentRequest $request) {
        $data = $request->except('_token');

        if (Department::create($data) instanceof Department) {
            return redirect()->route('admin.department.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $department = Department::findOrFail($id);
        $hospitalList = Hospital::get();

        CrumbsFacade::add(route('admin.department.list'), "科室列表");
        CrumbsFacade::addCurrent("编辑科室");
        return view('admin.department.edit', [
            'department' => $department,
            'hospitalList' => $hospitalList,
        ]);
    }

    public function postEdit (DepartmentRequest $request) {
        $id = $request->input('id');

        $data = $request->except('_token', 'id');

        if (Department::where('id', '=', $id)->update($data)) {
            return redirect()->route('admin.department.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        if (Doctor::where('department_id', '=', $id)->first()) {
            return back()->with('warning', '有医生关联，删除失败');
        }

        if (Department::where('id', '=', $id)->delete()) {
            return redirect()->route('admin.department.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }
}