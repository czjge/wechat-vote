<?php

namespace App\Http\Requests\familydoctor;

use App\Http\Requests\Request;

class CommunityRequest extends Request
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
            'name'        => 'required|unique:fd_community,name|max:255',
            'hospital_id' => 'required|numeric',
            'status'      => 'required|in:0,1,-1',
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
            'name.required'        => '社区名称不能为空',
            'name.unique'          => '社区名称已存在',
            'name.max'             => '社区名称长度不能超过255',
            'hospital_id.required' => '医院id不能为空',
            'hospital_id.numeric'  => '医院id必须是数字',
            'status.required'      => '状态值不能为空',
            'status.in'            => '状态值只能是0或者1或者-1',
        ];
    }
}
