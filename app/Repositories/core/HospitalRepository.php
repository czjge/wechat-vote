<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 11:07
 */
namespace App\Repositories\core;

use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Extensions\Common;
use App\Extensions\captcha\Verify;

class HospitalRepository extends Repository
{
    use Common;

    public function model() {
        return 'App\Models\core\Hospital';
    }

}