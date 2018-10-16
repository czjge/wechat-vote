<?php

namespace App\Http\Requests\core;

use App\Http\Requests\Request;

class DepartmentRequest extends Request
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
            'name' => 'required|max:255',
            'status' => 'required|in:0,1,2',
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
            'name.required' => '科室名称不能为空',
            'name.max' => '科室名称长度不能超过255',
            'status.required' => '状态值不能为空',
            'status.in' => '状态值只能是0或者1或者2',
        ];
    }
}
