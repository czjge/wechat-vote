@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <form class="form-inline" role="form" action="{{ route('admin.vote.getCandidateList', ['id'=>$id]) }}" pjax-container>
                            <div class="form-group">
                                <input type="text" class="form-control" name="kwd" placeholder="请输入名称或者编号" value="{{ Input::get('kwd') }}">
                            </div>
                            <div class="form-group">
                                <select class="form-control" style="width: 150px;" name="status">
                                    <option value="-1">全部</option>
                                    <option value="0" <?php if(\Illuminate\Support\Facades\Input::get('status') === '0'){echo 'selected="selected"';}?> >正常</option>
                                    <option value="1" <?php if(\Illuminate\Support\Facades\Input::get('status') === '1'){echo 'selected="selected"';}?> >待审核</option>
                                    <option value="2" <?php if(\Illuminate\Support\Facades\Input::get('status') === '2'){echo 'selected="selected"';}?> >锁定</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default">搜索</button>
                        </form>
                    </h3>
                    <div class="box-tools">
                        @adminpermission('candidate-add')
                            <a href="{{ route('admin.vote.getCandidateAdd', ['id'=>$id]) }}" class="btn btn-default"><i class="fa fa-plus"> 新增</i></a>
                        @endadminpermission
                        @adminpermission('candidate-export')
                            <a href="{{ route('admin.vote.getCandidateExport', ['id'=>$id]) }}" class="btn btn-default" target="_blank"><i class="fa fa-upload"> 导出</i></a>
                        @endadminpermission
                        @adminpermission('candidate-import')
                            <a href="#" class="btn btn-default import-candidate-btn"><i class="fa fa-download"> 导入</i></a>
                            <form enctype="multipart/form-data" style="display: none;" action="{{ route('admin.vote.postCandidateImport', ['id'=>$id]) }}" method="post" id="import-candidate-form">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                <input type="file" class="import-candidate-btn-real" name="file"/>
                            </form>
                        @endadminpermission
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>名称</th>
                            <th>手机号</th>
                            <th>投票数</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->tel }}</td>
                                <td>{{ $item->num }}</td>
                                <td>
                                    @if ($item->status == 0)
                                        <span class="label label-success">正常</span>
                                    @elseif ($item->status == 1)
                                        <span class="label label-warning">待审核</span>
                                    @else
                                        <span class="label label-danger">锁定</span>
                                    @endif
                                </td>
                                <td>
                                    @adminpermission('candidate-edit')
                                        <a href="{{ route('admin.vote.getCandidateEdit', ['id'=>$item->vote_id, 'cid'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-edit"> 编辑</i></a>
                                    @endadminpermission

                                    @adminpermission('candidate-vote-history')
                                        <a href="{{ route('admin.vote.getCandidateVoteHistory', ['id'=>$item->vote_id, 'cid'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-history"> 投票历史</i></a>
                                    @endadminpermission

                                    @adminpermission('candidate-voter-list')
                                        <a href="{{ route('admin.vote.getVoterList', ['id'=>$item->vote_id, 'cid'=>$item->id]) }}" class="btn btn-default"><i class="fa fa-list"> 用户投票列表</i></a>
                                    @endadminpermission

                                    @adminpermission('candidate-vote-manage')
                                        <a href="{{ route('admin.vote.getCandidateVoteManage', ['id'=>$item->vote_id, 'cid'=>$item->id]) }}" class="btn btn-default"><i class="fa  fa-unlock-alt"> 投票管理</i></a>
                                    @endadminpermission

                                    @adminpermission('candidate-check')
                                        @if ($item->status == 0)
                                            <a data-id="{{ $item->vote_id }}" data-cid="{{ $item->id }}" data-status="2" data-msg="确定锁定该选手？" class="btn btn-default btn-status"><i class="fa  fa-lock"> 锁定</i></a>
                                            <a data-id="{{ $item->vote_id }}" data-cid="{{ $item->id }}" data-status="1" data-msg="确定将该选手状态改为待审核？" class="btn btn-default btn-status"><i class="fa  fa-calendar-times-o"> 待审核</i></a>
                                        @endif

                                        @if ($item->status == 1)
                                            <a data-id="{{ $item->vote_id }}" data-cid="{{ $item->id }}" data-status="0" data-msg="确定将该选手状态改为正常？" class="btn btn-default btn-status"><i class="fa  fa-calendar-check-o"> 审核</i></a>
                                        @endif

                                        @if ($item->status == 2)
                                            <a data-id="{{ $item->vote_id }}" data-cid="{{ $item->id }}" data-status="0" data-msg="确定将该选手状态改为正常？" class="btn btn-default btn-status"><i class="fa  fa-unlock-alt"> 正常</i></a>
                                        @endif
                                    @endadminpermission

                                    @adminpermission('candidate-delete')
                                        <a data-id="{{ $item->id }}" data-module="candidate" class="btn btn-default btn-delete"><i class="fa fa-trash"> 删除</i></a>
                                    @endadminpermission
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="box-footer">
                        {{ $list->appends([
                            'kwd' => Input::get('kwd'),
                            'status' => Input::get('status')
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