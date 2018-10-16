@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">授予权限</h3>
                    <a href="{{ route('admin.role.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                    <div class="box-tools">

                    </div>
                </div>
                <!-- /.box-header -->
                <form role="form" action="{{ route('admin.role.postAttachPermission') }}" method="post" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $id }}"/>

                    <div class="box-body">

                        @foreach ($perms as $key => $value)
                            <h4>{{ $key }}</h4>
                            @foreach($value as $perm)
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" name="perms[]" value="{{ $perm->id }}" class="minimal" @if ($perm->have)checked @endif>&nbsp;&nbsp;{{ $perm->display_name }}
                                    </label>
                                </div>
                            @endforeach
                        @endforeach

                        <div class="box-footer">
                            <button type="submit" class="btn btn-default">提交</button>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection