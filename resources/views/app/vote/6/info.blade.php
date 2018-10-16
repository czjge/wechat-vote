@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('selfmeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle2.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    {{--<link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">--}}
    <style>
        .info_top{
            background: transparent;
            text-align: center;
        }
        .info-part01{
            background: transparent;
            min-height: 350px;
            height: auto;
        }
        .info-part01.list_item .head-img {
            top: 0;
            width: 750px;
            height: auto;
            min-height: 774px;
            border-radius: 0;
            left: 0;
            position: relative;
            border:0;
            padding-bottom: 0px;
            background: url(../../../images/vote/6/info-bg.jpg) no-repeat;
        }
        .info-part01.list_item .head-img img{
            width: 640px;
            height: 360px;
            border: 10px solid #fff;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.2);
            margin-top: 30px;
            position: relative;
        }
        .info-part01.list_item .head-img video{
            width: 90%;
            border: 10px solid #fff;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.2);
            margin-top: 20px;
            position: relative;
        }
        .info-part01.list_item .title{
            width: 690px;
            left: 0px;
            top: 10px;
            position: relative;
        }
        .info-part01.list_item .title p{
            text-align: left;
        }
        .info-part01.list_item .title p span{
            display: inline;
            font-size: 28px;
        }
        .info-part01.list_item .title p span.xm{
            font-size:32px;
        }
        .info-part01.list_item .title p span.yy,.info-part01.list_item .title p span.ks{
            color: #666;
        }
        .info-part01.list_item .title p:nth-child(2),.info-part01.list_item .title p span.cq-name{
            color:#f44d55;
        }
        .info-part01.list_item .title p:last-child,.info-part01.list_item .title p span.yc-name{
            color:#69bc36;
        }
        .info-part01.list_item .title p span.yc-name{
            white-space: normal;
        }
        .info-main {
            width: 630px;
            padding: 80px 30px 20px 30px;
            background: #ffe1cc;
            margin: 0 30px;
            color: #333;
            margin-top: -62px;
            margin-bottom: 40px;
        }
        .info-main-part{
            color: #896a39;
            font-size: 28px;
            margin-bottom: 50px;
        }
        .info-main-title{
            color: #e5c175;
            font-size: 30px;
            line-height: 60px;
            width: 100%;
            background: url("{{ $qiniu_cdn_path }}/images/vote/1/index-small-con.png") no-repeat top center ;
            text-align: center;
            display: inline-block;
        }
        .info-main-details{
            background: #f1e4d3;
            padding: 60px 30px 30px 30px;
            margin-top: -30px;
            border-radius: 10px;
        }
        .info-main-details.info03{
            text-align: center;
        }
        .yanzhengcode{
            position: fixed;
            z-index: 999;
            width: 600px;
            border: 10px solid #e2e2e2;
            left: 70px;
            top: 50%;
            margin-top: -150px;
            box-shadow: 10px 0px 40px 0px rgba(0,0,0,0.5);
            background: #fff;
        }
        .yanzhengcode img{
            width: 300px;
            margin-left: 10px;
            padding: 0;
            margin-top: 40px;
            margin-bottom: 15px;
        }
        .yanzhengcode input{
            width: 500px;
            height: 80px;
            margin-bottom: 15px;
            margin-top: 20px;
            font-size: 32px;
        }
        .yanzhengcode input:last-child {
            margin-bottom: 40px;
            background: #EFAD2D;
            color: #fff;
            border-radius: 40px;
        }
        .swiper-container-horizontal>.swiper-pagination-bullets{
            bottom: 10px;
        }
        .top-420{
            top:420px;
        }
        section.footer_info.info-vote{
            position: relative;
            top: 0;
            height: auto;
            width: 690px;
            margin-bottom: 0px;
            /*background: #ffe1cc;*/
            margin:-100px 30px 0 30px;
            padding-bottom: 20px;
        }
        .footer_info .main_btns{
            width: 500px;
            height: 78px;
            line-height: 78px;
            background-image: -webkit-linear-gradient(to right, #3e79f0, #2851a4);
            background: #cd121e;
            color: #fff;
            margin-left: 125px;
            border-radius: 40px;
            margin-top: 15px;
        }
        .pp-btn{
            width: 200px;
            height: 200px;
            position: absolute;
            right: 50px;
            top: 350px;
            z-index: 10;
        }
        .play{
            background: url("{{ $qiniu_cdn_path }}/images/vote/4/play-btn.png") no-repeat top center ;
        }
        .pause{
            background: url("{{ $qiniu_cdn_path }}/images/vote/4/pause-btn.png") no-repeat top center ;
        }
        .title-first{
            color: #ffe1cc;
            margin-top: 5px;
        }
        .title-first .xm{
            font-size: 32px;
            font-weight: bold;
            margin-right: 5px;
        }

        .main_btn_box_main{
            width: 690px;
            border:0;
            /*background: rgba(111,201,184,0.95);*/
            background: url(../../../images/vote/6/index-body.jpg);
        }
        .main_btn_box-title {
            color: #fff;
            font-size: 60px;
            background: url(../../../images/vote/6/vote-bg.png) no-repeat center center;
            height: 141px;
            line-height: 141px;
            text-align: center; 
            margin-top: 10px;
        }
        .main_btn_box-title b{
            font-size: 50px;
        }
        .main_btn_box_main .msg_box{
            padding:10px 30px 40px 30px;
        }
        p.gift-title {
            width: 695px;
            height: 133px;
            background: url(../../../images/vote/6/gift-bg.png) no-repeat;
            margin-left: -32px;
            margin-top: 40px;
            position: relative;
        }
        .gift-info{
            background: #fff;
            width: 540px;
            margin-left: 17px;
            border-radius: 20px;
            padding: 30px;
            margin-top: -180px;
            padding-top: 120px;
        }
        .gift-info a {
            margin-top: 30px;
        }
        .box_select{
            width:450px;
        }
        .box_select a{
            width: 50%;
        }
        .gift-info a img{
            border-radius: 20px;
        }
        .info-part02{
            min-height: 180px;
            text-align: left;
        }
        .footer_info p{
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')

    <section class="info_top list_box clearfix">
        <div class="info-part01 list_item">
            <div class="head-img">
                <video src="{{ $qiniu_cdn_path }}/storage/{{ $candidate->video_url }}" id="videoBox" controls="controls" loop="loop" poster="{{ $qiniu_cdn_path }}/images/vote/6/1.jpg"></video>
                <p class="title-first">
                    <span class="xm">{{ $candidate->name }}</span>
                    <span class="ks">{{ $candidate->of_hos }}院长</span>
                </p>
                <p style="font-size: 20px;color: rgba(255,255,204,.4);margin-top: 8px;text-align: center;">建议WIFI环境观看/收听，土豪随意</p>
            </div>
        </div>
    </section>

    <section class="footer_info info-vote">
        <!--<p>已有 <span class="num">{{ $candidate->num }}</span> 个祝福</p>-->
        @if(time() < strtotime('2018-2-15 00:00:00'))
            <p><span class="num">2018年2月15日7点开始领红包</span></p>
        @else
            <a href="javascript:void(0)" id="redpack_btn"><div class="main_btn">领 红 包</div></a>
        @endif
    </section>

    <section class="info-main clearfix">
        <div class="info-part02">
            <p class="info2">
                @if($candidate->desc=='')
                    {{ $wish_words }}
                @else
                    {!! $candidate->desc !!}
                @endif
            </p>
        </div>
    </section>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.jquery.min.js" type="text/javascript"></script>
    <script type="application/javascript">
            // vote
            var submintVoteStatus = 0;
            var captchaShowStatus = 0;
            $('.tp_btn2,.tp_btn1,#captcha_code_btn').click(function () {
                if ('{{ $vote->captcha_status }}' == 1 && captchaShowStatus == 0) {
                    $('.yanzhengcode').css('display', 'block');
                    captchaShowStatus = 1;
                    return false;
                }
               
                if(submintVoteStatus == 1){
                    return false;
                }
               
                if('{{ $subscribe }}' !== '1'){
                    //$('.footer_nav_gz2 a').click(); return false;
                }
               
                var ajaxVoteUrl = "{{ $ajaxVoteUrl }}";
                if ('{{ $vote->captcha_status }}' == 1) {
                    if ($('#captcha_code').val() == '') {
                        tusi("请输入验证码");return;
                    }
                    ajaxVoteUrl = "{{ $ajaxVoteUrl }}&captcha_code="+$('#captcha_code').val();
                }
               
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
				
		        $('.main_btn').hide();
               
                $.ajax({
                    type: "GET",
                    url: ajaxVoteUrl,
                    dataType : "json",
                    data: "",
                    beforeSend: function () {
                        loading('请稍后');
                        submintVoteStatus = 1;
                    },
                    complete: function () {
                        loading(false);
                        submintVoteStatus = 0;
                    },
                    success: function(data){
                        if (data.code == 200) {
                            afterCheckCaptcha();
                            $('.num').text(data.vote_num);
                            $('.main_btn').show();	
                            tusi(data.msg);
                        } else if (data.code == 209) {
                            afterCheckCaptcha();
                            $('.footer_nav_gz2 a').click();
                        } else if (data.code == 210) {
                            afterCheckCaptcha();
                            tusi("请再试一次");
                            setTimeout(function(){
                                window.location.href = '{{ $reloadUrl }}';
                            },1888);
                        } else if (data.code == 211) {
                            $('#captcha_code').val('');
                            tusi(data.msg);
                            $('.main_btn').show();
                        } else if (data.code == 202) {
                            afterCheckCaptcha();
                            tusi(data.msg);
                            $('.main_btn').show();
                        }else {
                            afterCheckCaptcha();
                            tusi(data.msg);
                            $('.main_btn').show();
                        }
                    }
                });


            });

            function afterCheckCaptcha () {
                if ('{{ $vote->captcha_status }}' == 1) {
                    $('#captcha_img').attr('src', '{{ route("base.getCaptcha") }}?'+Math.random());
                    $('.yanzhengcode').css('display', 'none');
                    captchaShowStatus = 0;
                    $('#captcha_code').val('');
                }
            }

            

            // wechat jssdkConfig.
            wx.config({
                debug: false,
                appId: '{{ $wxJssdkConfig->appId }}',
                timestamp: '{{ $wxJssdkConfig->timestamp }}',
                nonceStr: '{{ $wxJssdkConfig->nonceStr }}',
                signature: '{{ $wxJssdkConfig->signature }}',
                jsApiList: ['hideAllNonBaseMenuItem', 'showMenuItems', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ']
            });
            wx.ready(function () {

                // 隐藏所有非基础按钮接口
                wx.hideAllNonBaseMenuItem();

                // 批量显示功能按钮接口
                wx.showMenuItems({
                    menuList: ['menuItem:share:appMessage','menuItem:share:timeline']
                    // 发送给朋友                 // 分享到朋友圈
                });

                wx.onMenuShareTimeline({
                    title: '{!! $shareInfo['shareTitle'] !!}', // 分享标题
                    link: '{!! $shareInfo['shareUrl'] !!}', // 分享链接
                    //imgUrl: '{{ asset($shareInfo['shareLogo']) }}', // 分享图标
                    imgUrl: '<?php if(strpos($shareInfo['shareLogo'], 'http')===false){echo asset('storage/'.$shareInfo['shareLogo']);}else{echo $shareInfo['shareLogo'];}?>', // 分享图标
                    success: function () {
                    },
                    cancel: function () {
                    }
                });

                wx.onMenuShareAppMessage({
                    title: '{!! $shareInfo['shareTitle'] !!}', // 分享标题
                    desc: '{!! $shareInfo['shareDesc'] !!}', // 分享描述
                    link: '{!! $shareInfo['shareUrl'] !!}', // 分享链接
                    //imgUrl: '{{ asset($shareInfo['shareLogo']) }}', // 分享图标
                    imgUrl: '<?php if(strpos($shareInfo['shareLogo'], 'http')===false){echo asset('storage/'.$shareInfo['shareLogo']);}else{echo $shareInfo['shareLogo'];}?>', // 分享图标
                    type: 'link', // 分享类型,music、video或link，不填默认为link
                    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                    success: function () {
                    },
                    cancel: function () {
                    }
                });
            });

            // 每天8:00-23:59:59可以抽红包
            $('#redpack_btn').click(function () {
                {{--if ('{{ $redpack_url }}'==false) {--}}
                    {{--tusi('2月15号8点开始');--}}
                    {{--return false;--}}
                {{--}--}}

                if (parseInt('{{ time() }}') < parseInt('{{ strtotime($vote->start_time) }}')) {
                    tusi('2月15号7点开始');
                    return false;
                }

                var myDate = new Date();//获取系统当前时间
                var todayHour = myDate.getHours();
                if (todayHour<7) {
                    tusi('7点后开始抽红包');
                    return false;
                }

                window.location.href = '{!! $redpack_url !!}';
            });
    </script>
@endsection
