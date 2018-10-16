@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">授予角色</h3>
                    <a href="{{ route('admin.admin.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                    <div class="box-tools">

                    </div>
                </div>
                <!-- /.box-header -->
                <form role="form" action="{{ route('admin.admin.postAttachRole') }}" method="post" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $id }}"/>

                    <div class="box-body">

                        @foreach ($roles as $role)
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="minimal" @if ($role->have)checked @endif>&nbsp;&nbsp;{{ $role->display_name }}
                            </label>
                        </div>
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