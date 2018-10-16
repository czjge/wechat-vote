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
use App\Models\Permission;
use App\Repositories\RoleRepository as RoleRep;
use App\Repositories\PermissionRepository as PermissionRep;
use App\Http\Requests\RoleAddRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleAttachPermsRequest;
use Atorscho\Crumbs\CrumbsFacade;
use Illuminate\Support\Facades\DB;

class RoleController extends AdminBaseController
{
    private $roleRep;
    private $permissionRep;

    public function __construct(RoleRep $roleRep, PermissionRep $permissionRep) {
        $this->roleRep = $roleRep;
        $this->permissionRep = $permissionRep;

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $name = $request->input('name');

        $where = [];
        if ($name != '') {
            $where[] = ['display_name', 'like', '%'.$name.'%'];
        }
        $roleList = Role::where($where)->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));

        CrumbsFacade::addCurrent("角色列表");
        return view('admin.role.list', ['list'=>$roleList]);
    }

    public function getAdd () {
        CrumbsFacade::add('admin/role/list', "角色列表");
        CrumbsFacade::addCurrent("新增角色");
        return view('admin.role.add');
    }

    public function postAdd (RoleAddRequest $request) {
        $data = $request->except('_token');

        if (Role::create($data) instanceof Role) {
            return redirect()->route('admin.role.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $role = Role::findOrFail($id);

        CrumbsFacade::add('admin/role/list', "角色列表");
        CrumbsFacade::addCurrent("编辑角色");
        return view('admin.role.edit', ['role'=>$role]);
    }

    public function postEdit (Request $request) {
        // I can't find a more elegant way to organize my code below for now,
        // although it's a little bit stupid to judge whether name field
        // has been changed like that, it's a must to verify.Fix it later.
        $role = Role::findOrFail($request->input('id'));
        $validataNameRule = $role->name == $request->input('name') ?
                                        'required' :
                                        'required|unique:roles,name';
        $validataNameMsg = $role->name == $request->input('name') ?
                                        [
                                            'name.required' => '角色系统名不能为空'
                                        ] :
                                        [
                                            'name.required' => '角色系统名不能为空',
                                            'name.unique' => '角色系统名不能重复',
                                        ];
        $this->validate($request, [
            'name' => $validataNameRule,
        ], $validataNameMsg);

        $data = $request->except('_token', 'id');

        if (Role::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.role.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        // first we need to check if a user owns the role
        // that we try to delete, if it does, we need to deny it.
        if (DB::table('role_user')->where('role_id', '=', $id)->first()) {
            return back()->with('fail', '该角色关联了用户');
        }

        if (Role::where('id', '=', $id)->delete()) {
            return redirect()->route('admin.role.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }

    public function getAttachPermission ($id) {
        $perms = Permission::all()->groupBy('module');
        $myPermIds = Role::findOrFail($id)->perms()->get()->pluck('id')->toArray();

        foreach ($perms as $item) {
            foreach ($item as $perm) {
                if (in_array($perm->id, $myPermIds)) {
                    $perm->have = true;
                }
            }
        }

        CrumbsFacade::add('admin/role/list', "角色列表");
        CrumbsFacade::addCurrent("授予权限");
        return view('admin.role.attach-permission', [
            'perms' => $perms,
            'id' => $id,
        ]);
    }

    public function postAttachPermission (RoleAttachPermsRequest $request) {
        Role::findOrFail($request->input('id'))->savePermissions($request->input('perms'));

        return redirect()->route('admin.role.list')->with('suc', '编辑权限成功');
    }
}