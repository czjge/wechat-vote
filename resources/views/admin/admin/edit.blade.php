@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑用户</h3>
                    <a href="{{ route('admin.admin.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.admin.postEdit') }}" method="post" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" value="{{ $admin->id }}" name="id"/>

                    <div class="box-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">系统名</label>
                            <input type="text" class="form-control" name="name" value="{{ $admin->name }}" placeholder="" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="display_name" class="col-sm-2 control-label">展示名</label>
                            <input type="text" class="form-control" name="display_name" value="{{ $admin->display_name }}" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">说明</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="" maxlength="255">{{ $admin->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">状态</label>
                            <select class="form-control" name="status">
                                <option value="0" <?php if($admin->status==0){echo 'selected="selected"';}?> >正常</option>
                                <option value="1" <?php if($admin->status==1){echo 'selected="selected"';}?> >锁定</option>
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