@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">投票基本信息</h3>
                    <a href="{{ route('admin.vote.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postBaseinfo') }}" method="post" enctype="multipart/form-data" id="myform" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $vote->id }}"/>

                    <div class="box-body">
                        <div class="form-group">
                            <label>是否开启审核后显示:</label>

                            <div>
                                <input type="radio" name="audit_status" class="minimal" <?php if($vote->audit_status == 0) echo 'checked';?> value="0">关闭&nbsp;
                                <input type="radio" name="audit_status" class="minimal" <?php if($vote->audit_status == 1) echo 'checked';?> value="1">开启
                            </div>
                            <span class="help-block">开启后，用户报名需要后台审核后才能显示</span>
                        </div>

                        <div class="form-group">
                            <label>排行榜数量:</label>

                            <input type="text" class="form-control" name="rank_num" value="{{ $vote->rank_num }}">
                            <span class="help-block">排行榜页面显示前多少位选手</span>
                        </div>

                        <div class="form-group">
                            <label>前台允许上传照片大小（kb）:</label>

                            <input type="text" class="form-control" name="photo_size" value="{{ $vote->photo_size/1024 }}">
                            <span class="help-block">若填写0则不限制</span>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label>允许上传照片张数:</label>--}}

                            {{--<input type="text" class="form-control" name="photo_num" value="{{ $vote->photo_num }}">--}}
                            {{--<span class="help-block">若填写0则不限制</span>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <label>首页选手排序方式:</label>

                            <div>
                                <input type="radio" name="index_sort_type" class="minimal" <?php if($vote->index_sort_type == 1) echo 'checked';?> value="1">按编号倒序&nbsp;
                                <input type="radio" name="index_sort_type" class="minimal" <?php if($vote->index_sort_type == 2) echo 'checked';?> value="2">按编号正序&nbsp;
                                <input type="radio" name="index_sort_type" class="minimal" <?php if($vote->index_sort_type == 3) echo 'checked';?> value="3">按投票量
                                <input type="radio" name="index_sort_type" class="minimal" <?php if($vote->index_sort_type == 4) echo 'checked';?> value="4">按名字拼音
                                <input type="radio" name="index_sort_type" class="minimal" <?php if($vote->index_sort_type == 5) echo 'checked';?> value="5">按排序号
                            </div>
                            <span class="help-block">开启后，用户报名需要后台审核后才能显示</span>
                        </div>

                        <div class="form-group">
                            <label>详情页分享标题:</label>

                            <input type="text" class="form-control" name="info_share_title" value="{{ $vote->info_share_title }}">
                            <span class="help-block">被投票选手名变量：{NAME}，选手编号：{NO}，医院名字：{HOS}。使用方法，如：我是{NO}的{NAME},大家帮我投一票吧</span>
                        </div>

                        <div class="form-group">
                            <label>详情页分享描述:</label>

                            <input type="text" class="form-control" name="info_share_desc" value="{{ $vote->info_share_desc }}">
                            <span class="help-block">填写活动详情页分享描述，不能使用变量</span>
                        </div>

                        <div class="form-group">
                            <label>非详情页分享标题:</label>

                            <input type="text" class="form-control" name="other_share_title" value="{{ $vote->other_share_title }}">
                            <span class="help-block">填写活动非详情页分享标题，不能使用变量</span>
                        </div>

                        <div class="form-group">
                            <label>非详情页分享描述:</label>

                            <input type="text" class="form-control" name="other_share_desc" value="{{ $vote->other_share_desc }}">
                            <span class="help-block">填写活动非详情页分享描述，不能使用变量</span>
                        </div>

                        <div class="form-group">
                            <label>非详情页分享logo:</label>

                            <input type="file" class="form-control fileupload" value="{{ $vote->other_share_logo }}">
                            <span class="help-block">支持jpg和png格式</span>
                            <div class="img-div" data-name="other_share_logo">
                                <input type='hidden' name='other_share_logo' value='{{ $vote->other_share_logo }}'/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>二维码logo:</label>

                            <input type="file" class="form-control fileupload" value="{{ $vote->qr_code_logo }}">
                            <span class="help-block">支持jpg和png格式</span>
                            <div class="img-div" data-name="qr_code_logo">
                                <input type='hidden' name='qr_code_logo' value='{{ $vote->qr_code_logo }}'/>
                            </div>
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