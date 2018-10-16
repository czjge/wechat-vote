@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <form class="form-inline" role="form" action="{{ route('admin.department.list') }}" pjax-container>
                                <div class="form-group">
                                    <select class="form-control select2" name="hid" style="width: 200px;">
                                        <option value="">医院</option>
                                        @foreach ($hospitalList as $item)
                                            <option value="{{ $item->id }}" @if (Input::get('hid') == $item->id)selected="selected"@endif >{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="请输入科室名称" value="{{ Input::get('name') }}">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="status">
                                        <option value="">状态</option>
                                        <option value="0" @if (Input::get('status') == '0')selected="selected"@endif >待审核</option>
                                        <option value="1" @if (Input::get('status') == '1')selected="selected"@endif >审核通过</option>
                                        <option value="2" @if (Input::get('status') == '2')selected="selected"@endif >审核未通过</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.department.getAdd') }}" class="btn btn-default"><i class="fa fa-plus"> 新增</i></a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>医院</th>
                                <th>科室</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            @foreach ($departmentList as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->hospital->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    @if ($item->status == 0)
                                        <span class="label label-info">待审核</span>
                                    @elseif($item->status == 1)
                                        <span class="label label-success">审核通过</span>
                                    @else
                                        <span class="label label-danger">审核未通过</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.department.getEdit', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-edit"> 编辑</i></a>
                                    <a data-id="{{ $item->id }}" data-module="department" class="btn btn-default btn-delete"><i class="fa fa-trash"> 删除</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        <div class="box-footer">
                            {{ $departmentList->appends([
                                'hid' => Input::get('hid'),
                                'name' => Input::get('name'),
                                'status' => Input::get('status'),
                            ])->links() }}
                        </div>

                        @if (count($departmentList) == 0)
                            <div class="text-center">暂无数据</div>
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
        </div>
    </div>
@endsection