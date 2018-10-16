<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\familydoctor;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fd_doctor';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id', 'community_id', 'name', 'sex', 'title',
        'avatars', 'mobile', 'adept', 'desc', 'adept_tag',
        'status', 'schedule_time', 'prefession', 'schedule_remark',
    ];

    /**
     * Get the team that owns the doctor.
     */
    public function team()
    {
        return $this->belongsTo('App\Models\familydoctor\Team', 'team_id');
    }

    /**
     * Get the community that owns the doctor.
     */
    public function community()
    {
        return $this->belongsTo('App\Models\familydoctor\Community', 'community_id');
    }
}