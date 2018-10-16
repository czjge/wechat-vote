<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/11
 * Time: 11:38
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use Auth;
use App\Repositories\AdminRepository as AdminRep;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Atorscho\Crumbs\CrumbsFacade;
use Illuminate\Support\Facades\Config;
use Redis;


class IndexController extends AdminBaseController
{
    private $adminRep;

    public function __construct(AdminRep $adminRep) {
        $this->adminRep = $adminRep;

        CrumbsFacade::add("admin", "主页");
        parent::__construct();
    }

    public function index () {
        return view("admin.index");
    }

    public function postChgPwd (Request $request) {
        $oldPassword = $request->input('old_password');
        $newPassword = $request->input('new_password');

        // here we can't compare the hashed oldPassword with the password in the database,
        // we hava to use Hash Facade.
        if (Hash::check($oldPassword, Auth::guard('admin')->user()->password)) {
            $this->adminRep->update(['password'=>bcrypt($newPassword)], Auth::guard('admin')->user()->id);

            // after change password, we need to logout.
            Auth::guard('admin')->logout();

            return response()->json(1);
        } else {
            return response()->json(2);
        }
    }
}