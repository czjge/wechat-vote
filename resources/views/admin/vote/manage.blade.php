@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">投票管理</h3>
                    <a href="{{ route('admin.vote.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postManage') }}" method="post" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $vote->id }}"/>

                    <div class="box-body">
                        <div class="form-group">
                            <label>是否开启单次投票:</label>

                            <div>
                                <input type="radio" name="single_vote_status" class="minimal" <?php if($vote->single_vote_status == 0) echo 'checked';?> value="0">关闭&nbsp;
                                <input type="radio" name="single_vote_status" class="minimal" <?php if($vote->single_vote_status == 1) echo 'checked';?> value="1">开启
                            </div>
                            <span class="help-block">开启后，一个用户每天对一个选手只能投一票</span>
                        </div>

                        <div class="form-group">
                            <label>每天投票数:</label>

                            <input type="text" class="form-control" name="daily_user_votes" value="{{ $vote->daily_user_votes }}">
                            <span class="help-block">设置一个用户每天可以投多少票</span>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">
                                <label>投票时间段:</label>

                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datetimepicker_vote_time" name="vote_start_time" value="{{ $vote->vote_start_time }}">
                                </div>
                                <span class="help-block">设置哪个时间段允许投票</span>
                            </div>
                            <div class="col-xs-4">
                                <label>&nbsp;</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control datetimepicker_vote_time" name="vote_end_time" value="{{ $vote->vote_end_time }}">
                                </div>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>是否开启关注后才能投票:</label>

                            <div>
                                <input type="radio" name="subscribe_vote_status" class="minimal" <?php if($vote->subscribe_vote_status == 0) echo 'checked';?> value="0">关闭&nbsp;
                                <input type="radio" name="subscribe_vote_status" class="minimal" <?php if($vote->subscribe_vote_status == 1) echo 'checked';?> value="1">开启
                            </div>
                            <span class="help-block">开启后，用户每次投票前需要先关注公众号</span>
                        </div>

                        <div class="form-group">
                            <label>是否开启验证码:</label>

                            <div>
                                <input type="radio" name="captcha_status" class="minimal" <?php if($vote->captcha_status == 0) echo 'checked';?> value="0">关闭&nbsp;
                                <input type="radio" name="captcha_status" class="minimal" <?php if($vote->captcha_status == 1) echo 'checked';?> value="1">开启
                            </div>
                            <span class="help-block">开启后，用户每次投票前需要输入验证码</span>
                        </div>

                        <div class="form-group">
                            <label>最大得票数:</label>

                            <input type="text" class="form-control" name="daily_max_votes" value="{{ $vote->daily_max_votes }}">
                            <span class="help-block">设置一个选手每天可以得多少票</span>
                        </div>

                        <div class="form-group">
                            <label>5mins限制数:</label>

                            <input type="text" class="form-control" name="five_mins_limit" value="{{ $vote->five_mins_limit }}">
                            <span class="help-block">5分钟内超过投票数自动锁定</span>
                        </div>

                        <div class="form-group">
                            <label>投票速率:</label>

                            <input type="text" class="form-control" name="throttle_vote_speed" value="{{ $vote->throttle_vote_speed }}">
                            <span class="help-block">
                                投票速率限制（0表示不限制，1表示此次选手得票距离上次得票至少为1s）<br/>
                                注意：必须<span class="text-red">投票速率不为0</span>才起效；白名单为空表示全部限速
                            </span>
                        </div>

                        <div class="form-group">
                            <label>每天投票限额起始票数:</label>

                            <input type="text" class="form-control" name="start_limit_votes" value="{{ $vote->start_limit_votes }}">
                            <span class="help-block">
                                每天投票量超过多少启用投票限制（0表示不管投票量多少始终启用投票限制）<br/>
                                注意：目前投票限制是指5mins限制数
                            </span>
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