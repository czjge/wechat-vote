<?php
/**
 * Created by PhpStorm.
 * User: wangjiang
 * Date: 2016/11/8
 * Time: 10:54
 */
namespace App\Models\familydoctor;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fd_community';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'contact_phone', 'contact_qrcode', 'region',
        'address', 'logos', 'paid_service_tag', 'unpaid_service_tag', 'push_contact',
        'hospital_id', 'desc', 'status',
    ];

    /**
     * Get the hospital that links the community.
     */
    public function hospital()
    {
        return $this->belongsTo('App\Models\core\Hospital', 'hospital_id');
    }

    /**
     * Get the doctors for the community.
     */
    public function doctors()
    {
        return $this->hasMany('App\Models\familydoctor\Doctor', 'community_id');
    }

    /**
     * Get the teams for the community.
     */
    public function teams()
    {
        return $this->hasMany('App\Models\familydoctor\Team', 'community_id');
    }
}