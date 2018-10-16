@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"></h3>
                    <div class="box-tools">
                        @adminpermission('vote-add')
                            <a href="{{ route('admin.vote.getExtendFieldAdd', ['id'=>$vote->id]) }}" class="btn btn-default"><i class="fa fa-plus"> 新增</i></a>
                        @endadminpermission
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>#</th>
                            <th>字段展示名</th>
                            <th>字段名</th>
                            <th>字段类型</th>
                            <th>字段长度</th>
                            <th>默认值</th>
                            <th>操作</th>
                        </tr>
                        @foreach ($extendFieldList as $extendFieldItem)
                            <tr>
                                <td>{{ $extendFieldItem->id }}</td>
                                <td>{{ $extendFieldItem->display_name }}</td>
                                <td>{{ $extendFieldItem->field_name }}</td>
                                <td>
                                    @if($extendFieldItem->field_type=='string')
                                        字符串
                                    @elseif($extendFieldItem->field_type=='integer')
                                        整数
                                    @elseif($extendFieldItem->field_type=='text')
                                        文本
                                    @elseif($extendFieldItem->field_type=='select')
                                        下拉框
                                    @endif
                                </td>
                                <td>{{ $extendFieldItem->field_length }}</td>
                                <td>{{ $extendFieldItem->df_value }}</td>
                                <td>
                                    @adminpermission('vote-edit')
                                        <a href="{{ route('admin.vote.getExtendFieldEdit', ['id'=>$vote->id, 'fid'=>$extendFieldItem->id]) }}" class="btn btn-default"><i class="fa fa-edit"> 编辑</i></a>
                                    @endadminpermission
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="box-footer">
                        {{ $extendFieldList->appends([
                            'title' => Input::get('title')
                        ])->links() }}
                    </div>

                    @if (count($extendFieldList) == 0)
                        <div class="text-center">暂无数据</div>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection