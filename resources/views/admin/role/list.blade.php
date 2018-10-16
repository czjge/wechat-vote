@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <form class="form-inline" role="form" action="{{ route('admin.role.list') }}" pjax-container>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="请输入名称" value="{{ Input::get('name') }}">
                                </div>
                                <button type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.role.getAdd') }}" class="btn btn-default"><i class="fa fa-plus"> 新增</i></a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>系统名</th>
                                <th>操作</th>
                            </tr>
                            @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->display_name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <a href="{{ route('admin.role.getEdit', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-edit"> 编辑</i></a>
                                    <a data-id="{{ $item->id }}" data-module="role" class="btn btn-default btn-delete"><i class="fa fa-trash"> 删除</i></a>
                                    <a href="{{ route('admin.role.getAttachPermission', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-lock"> 权限</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        <div class="box-footer">
                            {{ $list->appends([
                                'name' => Input::get('name')
                            ])->links() }}
                        </div>

                        @if (count($list) == 0)
                            <div class="text-center">暂无数据</div>
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
        </div>
    </div>
@endsection