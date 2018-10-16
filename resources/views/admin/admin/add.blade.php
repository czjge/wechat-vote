@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增用户</h3>
                    <a href="{{ route('admin.admin.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.admin.postAdd') }}" method="post" pjax-container>
                    {!! csrf_field() !!}

                    <div class="box-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">系统名(登录名，不可重复)</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="" required maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="col-sm-2 control-label">密码</label>
                            <input type="password" class="form-control" name="password" placeholder="" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="col-sm-2 control-label">重复密码</label>
                            <input type="password" class="form-control" name="password_confirmation" placeholder="" maxlength="255" required>
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="col-sm-2 control-label">展示名</label>
                            <input type="text" class="form-control" name="display_name" placeholder="" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">说明</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="" maxlength="255"></textarea>
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