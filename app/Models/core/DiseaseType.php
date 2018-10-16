<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\core;

use Illuminate\Database\Eloquent\Model;

class DiseaseType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hys_disease_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'disease_label', 'description', 'status', 'name', 'map_location_url',
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