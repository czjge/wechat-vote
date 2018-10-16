@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">投票历史</h3>
                    <a href="{{ route('admin.vote.getCandidateList', ['id'=>$vote->id]) }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>

                <div class="chart">
                    <canvas id="lineChart" style="height:250px"></canvas>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection