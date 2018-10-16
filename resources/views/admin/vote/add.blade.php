@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增投票</h3>
                    <a href="{{ route('admin.vote.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postAdd') }}" method="post" class="vote-form" pjax-container>
                    {!! csrf_field() !!}

                    <div class="box-body">
                        <div class="form-group">
                            <label>活动标题:</label>

                            <input type="text" class="form-control" name="title" maxlength="255" required>
                            <span class="help-block">投票活动的标题</span>
                        </div>

                        <div class="form-group">
                            <label>开始时间:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datetimepicker" name="start_time" required>
                            </div>
                            <span class="help-block">投票活动的开始时间</span>
                        </div>

                        <div class="form-group">
                            <label>结束时间:</label>

                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right datetimepicker" name="end_time" required>
                            </div>
                            <span class="help-block">投票活动的结束时间</span>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-default">提交</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection