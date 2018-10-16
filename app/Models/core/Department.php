<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\core;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'hys_px_department';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hid', 'name', 'keyword', 'intro', 'detail', 'status',
    ];

    /**
     * Get the hospital that owns the department.
     */
    public function hospital()
    {
        return $this->belongsTo('App\Models\core\Hospital', 'hid');
    }
}