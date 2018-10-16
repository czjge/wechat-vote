<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminAddRequest extends Request
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
            'name' => 'required|unique:admins,name',
            'password' => 'required|confirmed',
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
            'name.required' => '管理员系统名不能为空',
            'name.unique' => '管理员系统名不能重复',
            'password.required' => '管理员密码不能为空',
            'password.confirmed' => '管理员密码前后不一致',
        ];
    }
}
