<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\core;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hys_px_hospital';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'logoid', 'keyword', 'intro', 'detail', 'sorts',
        'status', 'area_id', 'lnglat', 'reg_strategy', 'phone',
        'address', 'level', 'logourl', 'type', 'traffic', 'classify', 'service_info'
    ];

    /**
     * Get the departments for the hospital.
     */
    public function departments()
    {
        return $this->hasMany('App\Models\core\Department', 'hid');
    }
}