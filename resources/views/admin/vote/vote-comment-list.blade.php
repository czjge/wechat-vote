@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <form class="form-inline" role="form" action="{{ route('admin.vote.getCommetList', ['id'=>$id]) }}" pjax-container>
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
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>id</th>
                            <th>评论对象</th>
                            <th>评论内容</th>
                            <th>评论时间</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        @foreach ($list as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->candidate->name }}</td>
                                <td style="width: 60%;max-height: 50px">{{ $item->comment }}</td>
                                <td><?php echo date('Y-m-d H:i:s',$item->comment_time)  ;?></td>
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
                                    <a href="{{ route('admin.vote.getCommetEdit', ['id'=>$id,'cid'=>$item->id,'tid'=>0]) }}" class="btn btn-default"><i class="fa fa-history"> 正常</i></a>
                                    <a href="{{ route('admin.vote.getCommetEdit', ['id'=>$id,'cid'=>$item->id,'tid'=>1]) }}" class="btn btn-default"><i class="fa fa-history"> 待审核</i></a>
                                    <a href="{{ route('admin.vote.getCommetEdit', ['id'=>$id,'cid'=>$item->id,'tid'=>3]) }}" class="btn btn-default"><i class="fa fa-history"> 删除</i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="box-footer">
                        {{ $list->appends([
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