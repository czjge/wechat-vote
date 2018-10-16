<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-11
 * Time: 11:31
 */

namespace App\Presenters;

use App\Admin;

class UserPresenter
{
    public function showStatus (Admin $admin)
    {
        if ($admin->status==0) {
            return '<span class="label label-success">正常</span>';
        } elseif ($admin->status==1) {
            return '<span class="label label-danger">锁定</span>';
        }
    }
}