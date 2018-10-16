@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑医院</h3>
                    <a href="{{ route('admin.hospital.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.hospital.postEdit') }}" method="post" pjax-container>
                    {!! csrf_field() !!}

                    <input type="hidden" name="id" value="{{ $hospital->id }}"/>

                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label"><span class="text-red">*</span>医院名称</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ $hospital->name }}" placeholder="" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label"><span class="text-red">*</span>联系电话</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $hospital->phone }}" placeholder="" required maxlength="64">
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label"><span class="text-red">*</span>医院地址</label>
                            <input type="text" class="form-control" name="address" id="address" value="{{ $hospital->address }}" placeholder="" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">医院类别</label>
                            <select class="form-control" name="type" id="type">
                                @foreach (Config::get('admin.hospitalType') as $item)
                                    <option value="{{ $item }}" @if ($hospital->type == $item)selected="selected"@endif >{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="level" class="col-sm-2 control-label">医院等级</label>
                            <select class="form-control" name="level" id="level">
                                @foreach (Config::get('admin.hospitalLevel') as $item)
                                    <option value="{{ $item }}" @if ($hospital->level == $item)selected="selected"@endif >{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="logourl" class="col-sm-2 control-label">logo</label>

                            <input type="file" class="form-control fileupload" value="{{ $hospital->logourl }}">
                            <span class="help-block">支持jpg和png格式</span>
                            <div class="img-div" data-name="logourl">
                                <input type='hidden' name='logourl' value='{{ $hospital->logourl }}'/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reg_strategy" class="col-sm-2 control-label">挂号攻略</label>

                            <input type="file" class="form-control fileupload" value="{{ $hospital->reg_strategy }}">
                            <span class="help-block">支持jpg和png格式</span>
                            <div class="img-div" data-name="reg_strategy">
                                <input type='hidden' name='reg_strategy' value='{{ $hospital->reg_strategy }}'/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="area_id" class="col-sm-2 control-label">所属区域</label>
                            <select class="form-control" name="area_id" id="area_id">
                                <option value="1">成都</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keyword" class="col-sm-2 control-label">关键词</label>
                            <input type="text" class="form-control" name="keyword" id="keyword" value="{{ $hospital->keyword }}" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="intro" class="col-sm-2 control-label">简介</label>
                            <input type="text" class="form-control" name="intro" id="intro" value="{{ $hospital->intro }}" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="detail" class="col-sm-2 control-label">详细介绍</label>
                            <textarea class="form-control" name="detail" id="detail" rows="10">{{ $hospital->detail }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">状态</label>
                            <select class="form-control" name="status" id="status">
                                <option value="0" @if ($hospital->status == '0')selected="selected"@endif >待审核</option>
                                <option value="1" @if ($hospital->status == '1')selected="selected"@endif >审核通过</option>
                                <option value="2" @if ($hospital->status == '2')selected="selected"@endif >审核未通过</option>
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