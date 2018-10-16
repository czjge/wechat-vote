<?php

namespace App\Http\Requests\familydoctor;

use App\Http\Requests\Request;

class DoctorRequest extends Request
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
            'community_id' => 'sometimes|numeric',
            'team_id'      => 'sometimes|numeric',
            'sex'          => 'required|in:0,1',
            'mobile'       => 'sometimes|regex:/^1[3,4,5,7,8]\d{9}$/',
            'status'       => 'required|in:0,1,-1',
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
            'community_id.numeric'  => '社区id必须是数字',
            'team_id.numeric'       => '团队id必须是数字',
            'sex.required'          => '性别不能为空',
            'sex.in'                => '性别值只能是0或者1',
            'mobile.regex'          => '手机号码不符合规范',
            'status.required'       => '状态值不能为空',
            'status.in'             => '状态值只能是0或者1或者-1',
        ];
    }
}
