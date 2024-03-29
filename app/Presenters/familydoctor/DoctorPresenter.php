<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-08-11
 * Time: 11:31
 */

namespace App\Presenters\familydoctor;

use App\Models\familydoctor\Doctor;

class DoctorPresenter
{
    public function showListStatus (Doctor $doctor)
    {
        if ($doctor->status==0) {
            return '<span class="label label-info">待审核</span>';
        }
        if ($doctor->status==1) {
            return '<span class="label label-success">审核通过</span>';
        }
        if ($doctor->status==-1) {
            return '<span class="label label-danger">审核未通过</span>';
        }
    }
}