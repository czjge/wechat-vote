<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\hao;

use Illuminate\Database\Eloquent\Model;

class PerRankDoctor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hao_perrank_doctor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hospital', 'department', 'name', 'title',
        'avatar', 'intro', 'goodat', 'schedule_time',
        'score', 'is_recommend', 'disease',
        'hospital_id', 'department_id', 'doctor_id'
    ];

    /**
     * Get the hospital that doctor works.
     */
//    public function hospital()
//    {
//        return $this->belongsTo('App\Models\core\Hospital', 'hid');
//    }

    /**
     * Get the department that doctor works.
     */
//    public function department()
//    {
//        return $this->belongsTo('App\Models\core\Department', 'department_id');
//    }
}