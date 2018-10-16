@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">
                            <form class="form-inline" role="form" action="{{ route('admin.familydoctor.community.list') }}" pjax-container>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="请输入社区名称" value="{{ Input::get('name') }}">
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="status">
                                        <option value="">状态</option>
                                        <option value="0" @if (Input::get('status') == '0')selected="selected"@endif >待审核</option>
                                        <option value="1" @if (Input::get('status') == '1')selected="selected"@endif >审核通过</option>
                                        <option value="-1" @if (Input::get('status') == '-1')selected="selected"@endif >审核未通过</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-default">搜索</button>
                            </form>
                        </h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.familydoctor.community.getAdd') }}" class="btn btn-default"><i class="fa fa-plus"> 新增</i></a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>名称</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            @foreach ($community_list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                @inject('CommunityPresenter', 'App\Presenters\familydoctor\CommunityPresenter')
                                <td>{!! $CommunityPresenter->showListStatus($item) !!}</td>
                                <td>
                                    <a href="{{ route('admin.familydoctor.community.getEdit', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-edit"> 编辑</i></a>
                                    <a data-id="{{ $item->id }}" data-module="fd-community" class="btn btn-default btn-delete"><i class="fa fa-trash"> 删除</i></a>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        <div class="box-footer">
                            {{ $community_list->appends([
                                'name'   => Input::get('name'),
                                'status' => Input::get('status'),
                            ])->links() }}
                        </div>

                        @if (count($community_list) == 0)
                            <div class="text-center">暂无数据</div>
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
        </div>
    </div>
@endsection