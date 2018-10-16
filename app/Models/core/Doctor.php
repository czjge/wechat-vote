<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\core;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hys_px_doctor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id', 'name', 'avatar', 'intro', 'prof',
        'status', 'hid', 'area_id', 'add_time', 'add_ip',
        'sex', 'birthday', 'uid', 'step', 'xueli', 'liuxue',
        'keyan', 'xuehui', 'lunwen', 'kweixinpub', 'pweixinpub',
        'kweibo', 'pweixin', 'menzhennum', 'zhuyuannum', 'shoushunum',
        'shanchang', 'shanchang_tag', 'adept_tag', 'jibing1',
        'jibing1_name', 'jibing2', 'jibing2_name', 'jibing3',
        'jibing3_name', 'jibing1num', 'jibing2num', 'jibing3num',
        'zhiliao1', 'zhiliao2', 'zhiliao3', 'zhiliao1num',
        'zhiliao2num', 'zhiliao3num', 'wait_time', 'firstzhiliao',
        'proveimg', 'comment_num', 'banner_num', 'fail_reason',
        'is_import', 'label', 'is_hao', 'check_time', 'score',
        'is_famous', 'is_callable', 'unit_price', 'schedule_time',
        'schedule_text', 'zan_num', 'is_consultable', 'is_consulting',
        'consult_price', 'consulted_num', 'circle_ids',
    ];

    /**
     * Get the hospital that doctor works.
     */
    public function hospital()
    {
        return $this->belongsTo('App\Models\core\Hospital', 'hid');
    }

    /**
     * Get the department that doctor works.
     */
    public function department()
    {
        return $this->belongsTo('App\Models\core\Department', 'department_id');
    }
}