<?php

namespace App\Http\Requests\vote;

use App\Http\Requests\Request;

class VoteCandidateRequest extends Request
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
            //'tel' => 'sometimes|regex:/^1[34578][0-9]{9}$/|unique:candidate,tel',
            'tel' => 'sometimes|regex:/^1[345789][0-9]{9}$/',
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
            'name.required' => '名称不能为空',
            'name.max' => '名称长度不能超过255',
            'tel.regex' => '手机号格式不正确',
            //'tel.unique' => '该手机号已经存在',
        ];
    }
}
