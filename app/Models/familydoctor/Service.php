<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\familydoctor;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fd_service';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'type',
    ];
}