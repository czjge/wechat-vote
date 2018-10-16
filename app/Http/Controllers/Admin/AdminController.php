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
use App\Repositories\RoleRepository as RoleRep;
use App\Repositories\AdminRepository as AdminRep;
use App\Http\Requests\AdminAddRequest;
use App\Models\Role;
use App\Admin;
use Illuminate\Http\Request;
use App\Http\Requests\AdminAttachRolesRequest;
use Atorscho\Crumbs\CrumbsFacade;

class AdminController extends AdminBaseController
{
    private $roleRep;
    private $adminRep;

    public function __construct(RoleRep $roleRep, AdminRep $adminRep) {
        $this->roleRep = $roleRep;
        $this->adminRep = $adminRep;

        // we add this,
        // because if a view is empty with crumbItem,
        // the view will raise a error.
        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function getList (Request $request) {
        $name = $request->input('name');

        $where[] = ['id', '<>', 922];
        if ($name != '') {
            $where[] = ['display_name', 'like', '%'.$name.'%'];
        }
        $userList = Admin::where($where)->orderBy('created_at', 'desc')->paginate(config('admin.pageNum'));

        CrumbsFacade::addCurrent("用户列表");
        return view('admin.admin.list', ['list'=>$userList]);
    }

    public function getAdd () {
        CrumbsFacade::add('admin/user/list', "用户列表");
        CrumbsFacade::addCurrent("新增用户");
        return view('admin.admin.add');
    }

    public function postAdd (AdminAddRequest $request) {
        $data = $request->except('_token, password_confirmation');

        // add this to avoid integrity constraint violation(email filed unique constraint).
        $data['email'] = $request->input('name') . '@example.com';
        $data['status'] = 0;

        // encrypt the password.
        $data['password'] = bcrypt($request->input('password'));

        if (Admin::create($data) instanceof Admin) {
            return redirect()->route('admin.admin.list')->with('suc', '新增成功');
        } else {
            return back()->with('fail', '新增失败');
        }
    }

    public function getEdit ($id) {
        $admin = Admin::findOrFail($id);

        CrumbsFacade::add('admin/user/list', "用户列表");
        CrumbsFacade::addCurrent("编辑用户");
        return view('admin.admin.edit', ['admin'=>$admin]);
    }

    public function postEdit (Request $request) {
        // I can't find a more elegant way to organize my code below for now,
        // although it's a little bit stupid to judge whether name field
        // has been changed like that, it's a must to verify.Fix it later.
        $admin = Admin::findOrFail($request->input('id'));
        $validataNameRule = $admin->name == $request->input('name') ?
            'required' :
            'required|unique:admins,name';
        $validataNameMsg = $admin->name == $request->input('name') ?
            [
                'name.required' => '管理员系统名不能为空'
            ] :
            [
                'name.required' => '管理员系统名不能为空',
                'name.unique' => '管理员系统名不能重复',
            ];
        $this->validate($request, [
            'name' => $validataNameRule,
        ], $validataNameMsg);

        $data = $request->except('_token', 'id');

        if (Admin::where('id', '=', $request->input('id'))->update($data)) {
            return redirect()->route('admin.admin.list')->with('suc', '编辑成功');
        } else {
            return back()->with('fail', '编辑失败');
        }
    }

    public function getDelete ($id) {
        if (Admin::where('id', '=', $id)->delete()) {
            return redirect()->route('admin.admin.list')->with('suc', '删除成功');
        } else {
            return back()->with('fail', '删除失败');
        }
    }

    public function getAttachRole ($id) {
        $roles = Role::all();
        $myRoleIds = Admin::findOrFail($id)->roles()->get()->pluck('id')->toArray();

        foreach ($roles as $role) {
            if (in_array($role->id, $myRoleIds)) {
                $role->have = true;
            }
        }

        CrumbsFacade::add('admin/user/list', "用户列表");
        CrumbsFacade::addCurrent("授予角色");
        return view('admin.admin.attach-role', ['roles'=>$roles, 'id'=>$id]);
    }

    public function postAttachRole (AdminAttachRolesRequest $request) {
        $userId = $request->input('id');
        $roles = $request->input('roles');

        $admin = Admin::findOrFail($userId);

        // first we need detach all roles of a user
        $admin->detachRoles();

        // then if the user is attached roles, we just attach them.
        if ($roles) {
            $admin->attachRoles($roles);
        }

        return redirect()->route('admin.admin.list')->with('suc', '编辑角色成功');
    }
}