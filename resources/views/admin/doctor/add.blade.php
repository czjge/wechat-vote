@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增医生</h3>
                    <a href="{{ route('admin.doctor.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.doctor.postAdd') }}" method="post" pjax-container onsubmit="return checkDocForm()">
                    {!! csrf_field() !!}

                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label"><span class="text-red">*</span>医生姓名</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="sex" class="col-sm-2 control-label">性别</label>
                            <select class="form-control" name="sex" id="sex">
                                <option value="0">男</option>
                                <option value="1">女</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="hid" class="col-sm-2 control-label">所属医院</label>
                            <select class="form-control select2-hospital" name="hid" id="hid">
                                @foreach ($hospitalList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="department_id" class="col-sm-2 control-label">所属科室</label>
                            <select class="form-control select2-department" name="department_id" id="department_id">
                                @foreach ($initialDeps as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="prof" class="col-sm-2 control-label">职称</label>
                            <input type="text" class="form-control" name="prof" id="prof" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="avatar" class="col-sm-2 control-label">头像</label>

                            <input type="file" class="form-control fileupload">
                            <span class="help-block">请上传170px X 170px分辨率图片，支持jpg和png格式</span>
                            <div class="img-div" data-name="avatar"></div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">手机号码</label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="" maxlength="32">
                        </div>

                        <div class="form-group">
                            <label for="shanchang" class="col-sm-2 control-label">擅长</label>
                            <textarea class="form-control" name="shanchang" id="shanchang" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="intro" class="col-sm-2 control-label">个人简介</label>
                            <textarea class="form-control" name="intro" id="intro" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="adept_tag" class="col-sm-2 control-label">擅长Tag标签(App)</label>
                            <select class="form-control select2-adept_tag" multiple="multiple" name="adept_tag[]" id="adept_tag" data-placeholder="请选择">
                                @foreach ($tags as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="circle_ids" class="col-sm-2 control-label">所属圈子</label>
                            <select class="form-control select2" multiple="multiple" name="circle_ids[]" id="circle_ids" data-placeholder="收数据的请勿选择">
                                @foreach ($circles as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="label" class="col-sm-2 control-label">种类</label>
                            <select class="form-control" name="label" id="label">
                                <option value="0">无种类</option>
                                @foreach ($labels as $item)
                                    <option value="{{ $item->id }}">{{ $item->disease_label }}</option>
                                @endforeach
                            </select>
                            <span class="help-block">和就医地图相关时才勾选</span>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">状态</label>
                            <select class="form-control" name="status" id="status">
                                <option value="0">待审核</option>
                                <option value="1">审核通过</option>
                                <option value="2">审核未通过</option>
                            </select>
                            <span class="help-block">默认待审核(不在前端展示)，如需显示请勾选审核通过</span>
                        </div>

                        <div class="form-group">
                            <label for="is_consultable" class="col-sm-2 control-label">是否开启图文咨询</label>
                            <select class="form-control" name="is_consultable" id="is_consultable">
                                <option value="0">否</option>
                                <option value="1">是</option>
                            </select>
                            <span class="help-block">默认为否，包括下面的价格，收数据的请勿选择</span>
                        </div>

                        <div class="form-group">
                            <label for="consult_price" class="col-sm-2 control-label">图文咨询价格</label>
                            <input type="text" class="form-control" name="consult_price" id="consult_price" placeholder="">
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label ">坐诊时间</label>
                            <div class="" id="table-form">
                                <table class="table table-condensed table-bordered">
                                    <tr>
                                        <th style="border: 1px solid black;">日期</th>
                                        <th style="border: 1px solid black;">周一</th>
                                        <th style="border: 1px solid black;">周二</th>
                                        <th style="border: 1px solid black;">周三</th>
                                        <th style="border: 1px solid black;">周四</th>
                                        <th style="border: 1px solid black;">周五</th>
                                        <th style="border: 1px solid black;">周六</th>
                                        <th style="border: 1px solid black;">周日</th>
                                    </tr>
                                    <tr>
                                        <th style="border: 1px solid black;">上午</th>
                                        <td class="edit-avail" data-n="1_1" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="2_1" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="3_1" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="4_1" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="5_1" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="6_1" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="7_1" style="border: 1px solid black;"></td>
                                    </tr>
                                    <tr>
                                        <th style="border: 1px solid black;">下午</th>
                                        <td class="edit-avail" data-n="1_3" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="2_3" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="3_3" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="4_3" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="5_3" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="6_3" style="border: 1px solid black;"></td>
                                        <td class="edit-avail" data-n="7_3" style="border: 1px solid black;"></td>
                                    </tr>
                                </table>
                                <span class="help-block">全天=同时勾选上、下午</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="schedule_text" class="col-sm-2 control-label">坐诊信息（地址、补充等）</label>
                            <textarea class="form-control" name="schedule_text" id="schedule_text" rows="10"></textarea>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-default">提交</button>
                        </div>

                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection