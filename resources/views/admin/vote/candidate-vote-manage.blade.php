@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">用户投票管理</h3>
                    <a href="{{ route('admin.vote.getCandidateList', ['id'=>$candidate->vote_id]) }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postCandidateVoteManage') }}" method="post" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $candidate->id }}"/>
                    <input type="hidden" name="vote_id" value="{{ $candidate->vote_id }}"/>

                    <div class="box-body">
                        <div class="form-group">
                            <label>最大得票数:</label>

                            <input type="text" class="form-control" name="daily_max_votes" value="{{ $candidate->daily_max_votes }}">
                            <span class="help-block">设置一个选手每天可以得多少票</span>
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