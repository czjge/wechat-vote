<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\core;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hys_users';

    protected $primaryKey  = 'uid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname', 'smspass', 'smsexpire', 'password',
        'email', 'phone', 'sex', 'birthday', 'license',
        'vip', 'doc_id', 'pat_id', 'gold', 'cost',
        'qq', 'reg_ip', 'reg_time', 'last_login_ip',
        'last_login_time', 'wx_user_open_id', 'wjw_id_card',
        'wjw_name_cn', 'wjw_user_id', 'status',
    ];

//    /**
//     * Get the hospital that doctor works.
//     */
//    public function hospital()
//    {
//        return $this->belongsTo('App\Models\core\Hospital', 'hid');
//    }
//
//    /**
//     * Get the department that doctor works.
//     */
//    public function department()
//    {
//        return $this->belongsTo('App\Models\core\Department', 'department_id');
//    }
}