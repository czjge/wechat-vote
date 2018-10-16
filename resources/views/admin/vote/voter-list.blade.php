@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <form class="form-inline vote-form" role="form" action="{{ route('admin.vote.getVoterList', ['id'=>$id, 'cid'=>$cid]) }}" pjax-container>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datetimepicker" name="start_time" value="{{ Input::get('start_time') }}">
                            </div>
                            -
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datetimepicker" name="end_time" value="{{ Input::get('end_time') }}">
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </h3>
                    <div class="box-tools">
                        {{--<a href="{{ route('admin.vote.getCandidateAdd', ['id'=>$id]) }}" class="btn btn-default"><i class="fa fa-plus"> 新增</i></a>--}}
                        <a href="{{ route('admin.vote.getCandidateList', ['id'=>$id]) }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>昵称</th>
                            <th>头像</th>
                            <th>城市</th>
                            <th>ip</th>
                            {{--<th>openid</th>--}}
                            <th>投票时间</th>
                            <th>操作</th>
                        </tr>
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nickname }}</td>
                                <td>
                                    <img src="{{ $item->headimgurl }}" width="100"/>
                                </td>
                                <td>{{ $item->city }}</td>
                                <td>{{ long2ip($item->ip) }}</td>
                                {{--<td>{{ $item->openid }}</td>--}}
                                <td>{{ date('Y-m-d H:i:s', $item->log_time) }}</td>
                                <td>
                                    @adminpermission('user-vote-list')
                                        <a href="{{ route('admin.vote.getVoteList', ['id'=>$item->vote_id, 'wid'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-list"> 被投人列表</i></a>
                                    @endadminpermission
                                    {{--<a data-id="{{ $item->id }}" data-module="candidate" class="btn btn-default btn-delete"><i class="fa fa-trash"> 删除</i></a>--}}
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="box-footer">
                        @if ($paginator=='')
                            {{ $list->appends([
                                'start_time' => Input::get('start_time'),
                                'end_time' => Input::get('end_time')
                            ])->links() }}
                        @else
                            {!! $paginator->appends([
                                'start_time' => Input::get('start_time'),
                                'end_time' => Input::get('end_time')
                            ])->render(new App\Extensions\boolawuiThreePresenter($paginator)) !!}
                        @endif
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