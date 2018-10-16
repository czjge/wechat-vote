<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 11:07
 */
namespace App\Repositories\core;

use Bosnadev\Repositories\Eloquent\Repository;
use App\Extensions\Common;

class DoctorRepository extends Repository
{
    use Common;

    public function model() {
        return 'App\Models\core\Doctor';
    }

}