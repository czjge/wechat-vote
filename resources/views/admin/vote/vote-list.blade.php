@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">
                        <form class="form-inline" role="form">

                        </form>
                    </h3>
                    <div class="box-tools">
                        {{--<a href="{{ route('admin.vote.getCandidateAdd', ['id'=>$id]) }}" class="btn btn-default"><i class="fa fa-plus"> 新增</i></a>--}}
                        <a href="javascript:history.go(-1)" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>选手</th>
                            <th>票数</th>
                        </tr>
                        @foreach ($list as $k => $v)
                            <tr>
                                <td>{{ $k }}</td>
                                <td>{{ $v }}</td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="box-footer">

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