<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\familydoctor;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fd_team';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'community_id', 'name', 'photos', 'service_region',
        'desc', 'status', 'contact_phone', 'contact_qrcode', 'push_contact'
    ];

    /**
     * Get the doctors for the team.
     */
    public function doctors()
    {
        return $this->hasMany('App\Models\familydoctor\Doctor', 'team_id');
    }

    /**
     * Get the community that owns the team.
     */
    public function community()
    {
        return $this->belongsTo('App\Models\familydoctor\Community', 'community_id');
    }
}