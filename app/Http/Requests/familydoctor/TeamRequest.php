<?php

namespace App\Http\Requests\familydoctor;

use App\Http\Requests\Request;

class TeamRequest extends Request
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
            'status.required'       => '状态值不能为空',
            'status.in'             => '状态值只能是0或者1或者-1',
        ];
    }
}
