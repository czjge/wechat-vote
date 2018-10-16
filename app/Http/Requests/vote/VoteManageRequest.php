<?php

namespace App\Http\Requests\vote;

use App\Http\Requests\Request;

class VoteManageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'single_vote_status' => 'sometimes|in:0,1',
            'daily_user_votes' => 'sometimes|integer',
            'captcha_status' => 'sometimes|in:0,1',
            'daily_max_votes' => 'sometimes|integer',
            'five_mins_limit' => 'sometimes|integer',
            'throttle_vote_speed' => 'sometimes|integer',
            'start_limit_votes' => 'sometimes|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'single_vote_status.in' => '是否开启单次投票的值必须是0或者1',
            'daily_user_votes.integer' => '每天投票数必须是整数',
            'captcha_status.in' => '是否开启验证码的值必须是0或者1',
            'daily_max_votes.integer' => '最大得票数必须是整数',
            'five_mins_limit.integer' => '5mins限制数必须是整数',
            'throttle_vote_speed.integer' => '投票速率限制必须是整数',
            'start_limit_votes.integer' => '每天投票限额起始票数必须是整数',
        ];
    }
}
