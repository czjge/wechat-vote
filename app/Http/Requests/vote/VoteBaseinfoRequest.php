<?php

namespace App\Http\Requests\vote;

use App\Http\Requests\Request;

class VoteBaseinfoRequest extends Request
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
            'rank_num' => 'sometimes|integer',
            'photo_size' => 'sometimes|integer',
            'photo_num' => 'sometimes|integer',
            'audit_status' => 'sometimes|in:0,1',
            'index_sort_type' => 'sometimes|in:1,2,3,4,5',
            'info_share_title' => 'sometimes|max:255',
            'info_share_desc' => 'sometimes|max:255',
            'other_share_logo' => 'sometimes|max:255',
            'other_share_title' => 'sometimes|max:255',
            'other_share_desc' => 'sometimes|max:255',
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
            'rank_num.integer' => '排行榜数量必须为数字',
            'photo_size.integer' => '允许上传照片大小必须为整数',
            'photo_num.integer' => '允许上传照片张数必须为整数',
            'audit_status.in' => '是否开启审核后显示值必须是0或者1',
            'index_sort_type.in' => '首页选手排序方式值必须是1、2、3、4或者5',
            'info_share_title.max' => '详情页分享标题字数不能超过255',
            'info_share_desc.max' => '详情页分享描述字数不能超过255',
            'other_share_logo.max' => '非详情页分享logo字数不能超过255',
            'other_share_title.max' => '非详情页分享标题字数不能超过255',
            'other_share_desc.max' => '非详情页分享描述字数不能超过255',
        ];
    }
}
