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
    <link href="/css/vote/{{ $vote->id }}/webuploader.css" rel="stylesheet" type="text/css">
    <link href="/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <style>
        .footer_main{display: none}
    </style>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="main-head"></div>
    <div class="reg-container">
        <form id="reg-form" method="post" enctype="multipart/form-data" name="">
            <input type="hidden" name="id" value="{{ $vote->id }}"/>
            <input type="hidden" id="file_max_size" value="{{ $vote->photo_size }}"/>
            <input type="hidden" name="pic_url" value=""/>
            <input type="hidden" name="sex" value=""/>
            <div class="reg-item" style="margin-top: .2rem">
                <span class="icon-point">*</span>
                <span class="reg-title">宝贝姓名</span>
                <input type="text" class="name-input" placeholder="请输入宝贝的真实姓名" name="name">
            </div>
            <div class="reg-item">
                <span class="icon-point">*</span>
                <div class="reg-sex">
                    <div class="select-box selected"></div>
                    <span>小帅哥</span>
                </div>
                <div class="reg-sex mrg-l4">
                    <div class="select-box"></div>
                    <span>小美女</span>
                </div>
            </div>
            <div class="reg-item">
                <div class="name-content">
                    <span class="icon-point">*</span>
                    <span class="reg-title">联系方式</span>
                </div>
                <input type="number" class="name-input" placeholder="请输入家长的手机号码" name="tel">
            </div>
            <div class="reg-item mrg-t3">
                <span class="icon-point">*</span>
                <span class="reg-title">个性签名</span>
                <div class="reg-textarea">
                    <textarea placeholder="我想对宝贝说..." name="desc"></textarea>
                </div>
            </div>
            <div class="reg-item" style="height: 4.5rem;">
                <span class="icon-point">*</span>
                <span class="reg-title">上传照片</span>
                <div id="uploader" class="wu-example">
                    <div class="queueList">
                        <div id="dndArea" class="placeholder">
                            <div id="filePicker" class="webuploader-container">
                                <i class="icon-add"></i>
                               {{-- <div class="webuploader-pick"><i class="icon-add"></i> </div>--}}
                                <div id="rt_rt_1cd41osjv11uq16a8u5mhhe1ei51" style="position: absolute; top: 0px; left: 180px; width: 168px; height: 44px; overflow: hidden; bottom: auto; right: auto;">
                                    <input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*">
                                    <label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <ul class="filelist"></ul></div>
                    <div class="statusBar" style="display:none;">
                        <div class="progress" style="display: none;">
                            <span class="text">0%</span>
                            <span class="percentage" style="width: 0%;"></span>
                        </div><div class="info hide">共0张（0B），已上传0张</div>
                        <div class="btns">
                            <div id="filePicker2" class="webuploader-container">
                                {{--<div class="webuploader-pick">继续添加</div><div id="rt_rt_1cd41osk3n41r548e2sdjcde6" style="position: absolute; top: 0px; left: 0px; width: 1px; height: 1px; overflow: hidden;"><input type="file" name="file" class="webuploader-element-invisible" multiple="multiple" accept="image/*"><label style="opacity: 0; width: 100%; height: 100%; display: block; cursor: pointer; background: rgb(255, 255, 255);"></label></div></div>--}}
                            <div class="uploadBtn state-pedding">开始上传</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-sure">确定</div>
        </form>
    </div>
@endsection

@section('selfjs')
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/webuploader1.js?id=1" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script1.js?id=1" type="text/javascript"></script>

    <script>
        uploadImg(); //图片上传
        $('.reg-sex').click(function () {
            $(".select-box").removeClass('selected');
            $(this).find('.select-box').addClass('selected');
        });

        var submintVoteStatus = 0;
        $(".btn-sure").click( function () {
            if(submintVoteStatus == 1){
                return false;
            }

            var name = $("[name=name]").val().trim();
            var tel = $('[name=tel]').val().trim();
            var sex = $('.mrg-l4').find('.select-box').hasClass('selected') ? 1 : 0;
            $('#reg-form').find('[name=sex]').val(sex);
            var desc = $("[name=desc]").val().trim();
            var picUrl = $('[name=pic_url]').val();

            if(name == ""){
                tusi("宝贝姓名不能为空");
                return false;
            }
            if(tel == ''){
                tusi("联系方式不能为空");
                return false;
            }
            if (! checkMobile(tel)){
                tusi("联系方式格式不对");
                return false;
            }
            if (desc == '') {
                tusi("宝贝宣言不能为空");
                return false;
            }
            if (picUrl == '') {
                tusi("请上传宝贝靓照");
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('home.vote.getDoRegister' . Input::get('id')) }}?id={{ Input::get('id') }}",
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
                        tusi("报名成功");
                        setTimeout(function(){window.location="{{ route('home.vote.getIndex' . Input::get('id')) }}?id={{ Input::get('id') }}";}, 1888);
                    }else if(msg == 2){
                        tusi("报名成功，请等待管理员审核…");
                        setTimeout(function(){window.location="{{ route('home.vote.getIndex' . Input::get('id')) }}?id={{ Input::get('id') }}";}, 1888);
                    }else{
                        tusi("报名失败");
                        //setTimeout(function(){document.location.reload();}, 1888);
                    }
                }
            });
        });
    </script>
@endsection
