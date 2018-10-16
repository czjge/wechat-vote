<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 17:06
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests;
use App\Repositories\PermissionRepository as PermissionRep;
use App\Http\Requests\PermissionAddRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Atorscho\Crumbs\CrumbsFacade;
use Illuminate\Support\Facades\DB;

class PermissionController extends AdminBaseController
{
    private $permissionRep;

    public function __construct(PermissionRep $permissionRep) {
        $this->permissionRep = $permissionRep;

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $name = $request->input('name');
        $module = $request->input('module');

        $where = [];
        if ($name != '') {
            $where[] = ['display_name', 'like', '%'.$name.'%'];
        }
        if ($module!="") {
            $where[] = ['module', '=', $module];
        }
        $permissionList = Permission::where($where)->orderBy('module', 'desc')->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));

        $permissionModuleList = config('admin.permissionModule');

        CrumbsFacade::addCurrent("权限列表");
        return view('admin.permission.list', [
            'list' => $permissionList,
            'permissionModuleList' => $permissionModuleList,
        ]);
    }

    public function getAdd () {
        $permissionModuleList = config('admin.permissionModule');

        CrumbsFacade::add('admin/permission/list', "权限列表");
        CrumbsFacade::addCurrent("新增权限");
        return view('admin.permission.add', [
            'permissionModuleList' => $permissionModuleList,
        ]);
    }

    public function postAdd (PermissionAddRequest $request) {
        $data = $request->except('_token');

        if (Permission::create($data) instanceof Permission) {
            return redirect()->route('admin.permission.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $permission = Permission::findOrFail($id);
        $permissionModuleList = config('admin.permissionModule');

        CrumbsFacade::add('admin/permission/list', "权限列表");
        CrumbsFacade::addCurrent("编辑权限");
        return view('admin.permission.edit', [
            'permission' => $permission,
            'permissionModuleList' => $permissionModuleList,
        ]);
    }

    public function postEdit (Request $request) {
        // I can't find a more elegant way to organize my code below for now,
        // although it's a little bit stupid to judge whether name field
        // has been changed like that, it's a must to verify.Fix it later.
        $permission = Permission::findOrFail($request->input('id'));
        $validataNameRule = $permission->name == $request->input('name') ?
                                        'required' :
                                        'required|unique:permissions,name';
        $validataNameMsg = $permission->name == $request->input('name') ?
                                        [
                                            'name.required' => '权限系统名不能为空'
                                        ] :
                                        [
                                            'name.required' => '权限系统名不能为空',
                                            'name.unique' => '权限系统名不能重复',
                                        ];
        $this->validate($request, [
            'name' => $validataNameRule,
        ], $validataNameMsg);

        $data = $request->except('_token', 'id');

        if (Permission::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.permission.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        // first we need to check if a role owns the permission
        // that we try to delete, if it does, we need to deny it.
        if (DB::table('permission_role')->where('permission_id', '=', $id)->first()) {
            return back()->with('fail', '该权限关联了角色');
        }

        if (Permission::where('id', '=', $id)->delete()) {
            return redirect()->route('admin.permission.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }
}