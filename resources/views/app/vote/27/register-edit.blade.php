@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('selfmeta')
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    {{--<link href="/css/vote/{{ $vote->id }}/webuploader.css" rel="stylesheet" type="text/css">--}}
    <link href="/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <style>
        .footer_main{display: none}
    </style>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="head-content"><div class="rules"></div> </div>

    <form id="reg-form">

    <ul class="main-content clearfix edit">

        <input type="hidden" name="id" value="{{ $vote->id }}"/>
        <input type="hidden" id="file_max_size" value="{{ $vote->photo_size }}"/>
        <input type="hidden" name="pic_url" value="{{ $candidate->pic_url }}"/>
        <input type="hidden" name="cid" value="{{ $candidate->id }}"/>

        <li>
            <span class="li-title">姓名</span>
            <div class="li-right"><input class="li-input" type="text" placeholder="请输入您的姓名" name="name" value="{{ $candidate->name }}"></div>
        </li>
        <li>
            <span class="li-title">手机</span>
            <div class="li-right"><input class="li-input" type="number" placeholder="请输入您的手机号（选填）" name="mobile" value="{{ $candidate->tel }}"></div>
        </li>
        <li>
            <span class="li-title">性别</span>
            <div class="li-right">
                <select class="li-select" name="sex">
                    <option value="0" @if($candidate->sex == 0) selected @endif>女</option>
                    <option value="1" @if($candidate->sex == 1) selected @endif>男</option>
                </select>
            </div>
        </li>
        <li>
            <span class="li-title">职称</span>
            <div class="li-right"><input class="li-input" type="text" placeholder="请输入您的职称" name="tit" value="{{ $candidate->tit }}"></div>
        </li>
        <li>
            <span class="li-title">科室</span>
            <div class="li-right"><input class="li-input" type="text" placeholder="请输入您的科室" name="dep" value="{{ $candidate->dep }}"></div>
        </li>
        <li>
            <span class="li-title">医院</span>
            <div class="li-right"><input class="li-input" type="text" placeholder="请输入医院名称" name="hos" value="{{ $candidate->hos }}"></div>
        </li>
        <li>
            <span class="li-title long">医生简介</span>
            <div class="li-box">
                <textarea class="li-profile" name="desc">{{ $candidate->desc }}</textarea>
                <div class="li-border"></div>
            </div>
        </li>
        <li>
            <span class="li-title long">头像</span>
            <div class="img-preview">
                <img src="{{ $qiniu_cdn_path }}/storage/{{ $candidate->pic_url }}" width="100%" class="img1">
                <div id="uploader" class="wu-example">
                    <div class="queueList">
                        <div id="dndArea" class="placeholder">
                            <div id="filePicker" class="webuploader-container">
                                <div class="webuploader-pick"><i class="icon-add"></i> </div>
                                <div id="rt_rt_1cd41osjv11uq16a8u5mhhe1ei51" style="position: absolute; top: 0px; left: 180px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;">
                                    <input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*">
                                    <label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <ul class="filelist"></ul>
                    </div>
                    <div class="statusBar" style="display:none;">
                        <div class="progress" style="display: none;">
                            <span class="text">0%</span>
                            <span class="percentage" style="width: 0%;"></span>
                        </div>
                        <div class="info hide">共0张（0B），已上传0张</div>
                        <div class="btns hide">
                            <div id="filePicker2" class="webuploader-container">
                                <div class="webuploader-pick hide">继续添加</div>
                                <div id="rt_rt_1cd41osk3n41r548e2sdjcde6" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div>
                            </div>
                            <div class="uploadBtn state-pedding">开始上传</div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>

    </form>

    <div class="save-btn">提交</div>
    <div style="height: 20px"></div>
@endsection

@section('selfjs')
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/webuploader.js?id=1" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js?id=1" type="text/javascript"></script>

    <script>
        uploadImg(); //图片上传
//        $('.reg-sex').click(function () {
//            $(".select-box").removeClass('selected');
//            $(this).find('.select-box').addClass('selected');
//        });

        var submintVoteStatus = 0;
        $(".save-btn").click( function () {
            if(submintVoteStatus == 1){
                return false;
            }

            var name = $("[name=name]").val().trim();
            var mobile = $('[name=mobile]').val().trim();
            var sex = $('[name=sex]').val();
            var title = $('[name=tit]').val().trim();
            var department = $('[name=dep]').val().trim();
            var hospital = $('[name=hos]').val().trim();
            var desc = $("[name=desc]").val().trim();
            var picUrl = $('[name=pic_url]').val();

            if(name == ""){
                tusi("姓名不能为空");
                return false;
            }
            if(mobile != ''){
                if (! checkMobile(mobile)) {
                    tusi('手机格式不正确');
                    return false;
                }
            }
            if (title == '') {
                tusi("职称不能为空");
                return false;
            }
            if (department == '') {
                tusi("科室不能为空");
                return false;
            }
            if (hospital == '') {
                tusi("医院不能为空");
                return false;
            }
            if (desc == '') {
                tusi("医生简介不能为空");
                return false;
            }
            if (picUrl == '') {
                tusi("头像不能为空");
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('home.vote.getDoRegisterEdit' . Input::get('id')) }}?id={{ Input::get('id') }}",
                data: $('#reg-form').serialize(),
                beforeSend: function () {
                    loading('请稍后');
                    submintVoteStatus = 1;
                },
                complete: function () {
                    loading(false);
                    submintVoteStatus = 0;
                },
                success: function(msg){
                    if(msg == 1){
                        tusi("修改成功");
                        setTimeout(function(){document.location.reload();}, 1888);
                        //setTimeout(function(){window.location="{{ route('home.vote.getIndex' . Input::get('id')) }}?id={{ Input::get('id') }}";}, 1888);
                    }else if(msg == 2){
                        tusi("修改成功，请等待管理员审核…");
                        setTimeout(function(){document.location.reload();}, 1888);
                        //setTimeout(function(){window.location="{{ route('home.vote.getIndex' . Input::get('id')) }}?id={{ Input::get('id') }}";}, 1888);
                    }else{
                        tusi("修改失败");
                        setTimeout(function(){document.location.reload();}, 1888);
                    }
                }
            });
        });
    </script>
    <script>
        $('.rules').click(function () {
            $('.rule_box').removeClass('box_hide');
        });
        function closeRules() {
            $('.rule_box').addClass('box_hide');
        }
    </script>
@endsection
