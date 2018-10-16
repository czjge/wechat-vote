@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增医生</h3>
                    <a href="{{ route('admin.familydoctor.doctor.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.familydoctor.doctor.postAdd') }}" method="post" pjax-container onsubmit="return checkFdDocForm()">
                    {!! csrf_field() !!}

                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label"><span class="text-red">*</span>医生名字</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="region" class="col-sm-2 control-label">所属社区</label>
                            <select class="form-control select2-community" name="community_id" id="community_id">
                                <option value="0">请选择</option>
                                @foreach ($community_list as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="region" class="col-sm-2 control-label">所属团队</label>
                            <select class="form-control select2-team" name="team_id" id="team_id">
                                <option value="0">请选择</option>
                                @foreach ($initial_team as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sex" class="col-sm-2 control-label">性别</label>
                            <select class="form-control" name="sex" id="sex">
                                <option value="0">男</option>
                                <option value="1">女</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">职称</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <a class="btn btn-default pull-right" id="doctor-avatar-add"><i class="fa fa-plus"> 新增</i></a>
                            <label for="" class="col-sm-2 control-label">头像</label><br/><br/>

                            <div class="doctor-avatar-container">
                                <div>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control doctor-avatar-btn">
                                        <input type="hidden" name="avatars[]" value="">
                                    </div>
                                    <div class="col-sm-6">
                                        <a class="btn btn-default" id="doctor-avatar-delete"><i class="fa fa-trash"> 删除</i></a>
                                    </div>
                                </div>
                            </div>

                            <br/><br/>
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="col-sm-2 control-label">手机号码</label>
                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="adept" class="col-sm-2 control-label">擅长</label>
                            <input type="text" class="form-control" name="adept" id="adept" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="prefession" class="col-sm-2 control-label">专业</label>
                            <input type="text" class="form-control" name="prefession" id="prefession" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="adept_tag" class="col-sm-2 control-label">擅长Tag标签</label>
                            <select class="form-control select2-adept_tag" multiple="multiple" name="adept_tag[]" id="adept_tag" data-placeholder="请选择">
                                @foreach ($tags as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
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
                            <label for="schedule_remark" class="col-sm-2 control-label">坐诊备注</label>
                            <textarea class="form-control" name="schedule_remark" id="schedule_remark" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="desc" class="col-sm-2 control-label">简介</label>
                            <textarea class="form-control" name="desc" id="desc" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">状态</label>
                            <select class="form-control" name="status" id="status">
                                <option value="0">待审核</option>
                                <option value="1">审核通过</option>
                                <option value="-1">审核未通过</option>
                            </select>
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