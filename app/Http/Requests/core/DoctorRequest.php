<?php

namespace App\Http\Requests\core;

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
            'name'           => 'required|max:255',
            'sex'            => 'required|in:0,1',
            'hid'            => 'required|regex:/^[0-9]*[1-9][0-9]*$/',
            'department_id'  => 'required|regex:/^[0-9]*[1-9][0-9]*$/',
            'phone'          => 'sometimes|regex:/^1[3,4,5,7,8]\d{9}$/',
            'is_consultable' => 'required|in:0,1',
            'status'         => 'required|in:0,1,2',
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
            'name.required'           => '医生名称不能为空',
            'name.max'                => '医生名称长度不能超过255',
            'sex.required'            => '医生性别不能为空',
            'sex.in'                  => '医生性别取值范围不对',
            'hid.required'            => '医生所属医院id不能为空',
            'hid.regex'               => '医生所属医院id必须是正整数',
            'department_id.required'  => '医生所属科室id不能为空',
            'department_id.regex'     => '医生所属科室id必须是正整数',
            'phone.regex'             => '手机号码格式不对',
            'is_consultable.required' => '是否开启图文咨询不能为空',
            'is_consultable.in'       => '是否开启图文咨询取值范围不对',
            'status.required'         => '状态值不能为空',
            'status.in'               => '状态值取值范围不对',
        ];
    }
}
