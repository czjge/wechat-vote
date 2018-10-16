<?php

namespace App\Http\Requests\core;

use App\Http\Requests\Request;

class HospitalRequest extends Request
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
            'name'    => 'required|unique:hys_px_hospital,name|max:255',
            'phone'   => 'required|max:64',
            'address' => 'required|max:255',
            'status'  => 'required|in:0,1,2',
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
            'name.required'    => '医院名称不能为空',
            'name.unique'      => '医院名称已存在',
            'name.max'         => '医院名称长度不能超过255',
            'phone.required'   => '联系电话不能为空',
            'phone.max'        => '联系电话长度不能超过64',
            'address.required' => '医院地址不能为空',
            'address.max'      => '医院地址长度不能超过255',
            'status.required'  => '状态值不能为空',
            'status.in'        => '状态值只能是0或者1或者2',
        ];
    }
}
