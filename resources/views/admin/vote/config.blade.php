@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">投票配置信息</h3>
                    <a href="{{ route('admin.vote.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postConfig') }}" method="post" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $vote->id }}"/>

                    <div class="box-body">
                        <div class="form-group">
                            <label>微信公众账号appid:</label>

                            <input type="text" class="form-control" name="appid" value="{{ $vote->appid }}">
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                            <label>微信公众账号appsecret:</label>

                            <input type="text" class="form-control" name="appsecret" value="{{ $vote->appsecret }}">
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                            <label>是否开启CDN加速:</label>

                            <div>
                                <input type="radio" name="cdn_status" class="minimal" <?php if($vote->cdn_status == 0) echo 'checked';?> value="0">关闭&nbsp;
                                <input type="radio" name="cdn_status" class="minimal" <?php if($vote->cdn_status == 1) echo 'checked';?> value="1">开启
                            </div>
                            <span class="help-block">开启后，前台页面打开速度更快</span>
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