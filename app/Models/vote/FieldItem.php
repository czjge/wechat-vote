<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\vote;

use Illuminate\Database\Eloquent\Model;

class FieldItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'field_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vote_id', 'display_name', 'field_name',
        'field_type', 'field_length', 'df_value',
        'is_must', 'prompt_msg', 'select_values'
    ];
}