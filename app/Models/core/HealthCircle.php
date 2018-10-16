<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\core;

use Illuminate\Database\Eloquent\Model;

class HealthCircle extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_health_circle';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'intro', 'surface_img', 'joined_num',
        'topic_num', 'doc_num', 'active_project_id',
        'disease_ids', 'sorts', 'status', 'create_time',
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