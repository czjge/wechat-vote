@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增科室</h3>
                    <a href="{{ route('admin.department.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.department.postAdd') }}" method="post" pjax-container>
                    {!! csrf_field() !!}

                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label"><span class="text-red">*</span>科室名称</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="hid" class="col-sm-2 control-label">所属医院</label>
                            <select class="form-control select2" name="hid" id="hid">
                                @foreach ($hospitalList as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keyword" class="col-sm-2 control-label">关键词</label>
                            <input type="text" class="form-control" name="keyword" id="keyword" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="intro" class="col-sm-2 control-label">简介</label>
                            <input type="text" class="form-control" name="intro" id="intro" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="detail" class="col-sm-2 control-label">详细介绍</label>
                            <textarea class="form-control" name="detail" id="detail" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">状态</label>
                            <select class="form-control" name="status" id="status">
                                <option value="0">待审核</option>
                                <option value="1">审核通过</option>
                                <option value="2">审核未通过</option>
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