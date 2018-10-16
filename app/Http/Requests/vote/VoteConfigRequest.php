<?php

namespace App\Http\Requests\vote;

use App\Http\Requests\Request;

class VoteConfigRequest extends Request
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
            'appid' => 'sometimes|max:255',
            'appsecret' => 'sometimes|max:255',
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
            'appid.max' => 'appid长度不能超过255',
            'appsecret.max' => 'appsecret长度不能超过255',
        ];
    }
}
