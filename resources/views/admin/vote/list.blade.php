@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <form class="form-inline" role="form" action="{{ route('admin.vote.list') }}" pjax-container>
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" placeholder="请输入活动标题" value="{{ \Illuminate\Support\Facades\Input::get('title') }}">
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </h3>
                    <div class="box-tools">
                        @adminpermission('vote-add')
                            <a href="{{ route('admin.vote.getAdd') }}" class="btn btn-default"><i class="fa fa-plus"> 新增</i></a>
                        @endadminpermission
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>活动标题</th>
                            <th>开始时间</th>
                            <th>结束时间</th>
                            <th>状态</th>
                            <th>报名状态</th>
                            <th>操作</th>
                        </tr>
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->start_time }}</td>
                                <td>{{ $item->end_time }}</td>
                                @inject('VotePresenter', 'App\Presenters\VotePresenter')
                                <td>{!! $VotePresenter->showStatus($item) !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.vote.getCandidateList', ['id'=>$item->id]) }}" class="btn btn-info">总数({{ $item->candidateAllNum }})</a>
                                        <a href="{{ route('admin.vote.getCandidateList', ['id'=>$item->id]) }}?status=1" class="btn btn-warning">未审核({{ $item->candidateUncheckNum }})</a>
                                        <a href="{{ route('admin.vote.getCandidateList', ['id'=>$item->id]) }}?status=2" class="btn btn-danger">锁定({{ $item->candidateLockNum }})</a>
                                    </div>
                                </td>
                                <td>
                                    @adminpermission('vote-edit')
                                        <a href="{{ route('admin.vote.getEdit', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-edit"> 编辑</i></a>
                                    @endadminpermission
                                    @adminpermission('vote-baseinfo')
                                        <a href="{{ route('admin.vote.getBaseinfo', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-info"> 基本信息</i></a>
                                    @endadminpermission
                                    @adminpermission('vote-config')
                                        <a href="{{ route('admin.vote.getConfig', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-wrench"> 配置信息</i></a>
                                    @endadminpermission
                                    @adminpermission('vote-manage')
                                        <a href="{{ route('admin.vote.getManage', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-unlock-alt"> 投票管理</i></a>
                                    @endadminpermission
                                        <a href="{{ route('admin.vote.getExtendFieldList', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-cogs"> 扩展字段</i></a>
                                        <a href="{{ route('admin.vote.getCommetList', ['id'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-cogs"> 评论审核</i></a>
                                    @adminpermission('vote-delete')
                                        <a data-id="{{ $item->id }}" data-module="vote" class="btn btn-default btn-delete"><i class="fa fa-trash"> 删除</i></a>
                                    @endadminpermission
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="box-footer">
                        {{ $list->appends([
                            'title' => \Illuminate\Support\Facades\Input::get('title')
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