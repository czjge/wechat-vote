@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑权限</h3>
                    <a href="{{ route('admin.permission.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.permission.postEdit') }}" method="post" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" value="{{ $permission->id }}" name="id"/>

                    <div class="box-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">系统名</label>
                            <input type="text" class="form-control" name="name" value="{{ $permission->name }}" placeholder="" required maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="col-sm-2 control-label">展示名</label>
                            <input type="text" class="form-control" name="display_name" value="{{ $permission->display_name }}" placeholder="" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">模块</label>
                            <select class="form-control" name="module">
                                @foreach($permissionModuleList as $permissionModuleItem)
                                    <option value="{{ $permissionModuleItem }}" <?php if($permissionModuleItem==$permission->module){echo "selected='selected'";}?> >{{ $permissionModuleItem }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">说明</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="" maxlength="255">{{ $permission->description }}</textarea>
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