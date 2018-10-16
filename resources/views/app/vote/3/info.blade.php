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
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle2.css?v=2" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">
    <style>
        body{
            background: #e0d0b7;
        }
        .info_top{
            top: 100px;
            position: absolute;
            background: transparent;
            text-align: center;
        }
        .info-part01{
            background: transparent;
            min-height: 350px;
        }
        .info-part01.list_item .head-img {
            top: 0;
            width: 170px;
            height: 170px;
            border-radius: 85px;
            left: 290px;
            border: 5px solid #f1e4d3;
        }
        .info-part01.list_item .title{
            width: 100%;
            left: 0;
            height: 100px;
            top: 200px;
        }
        
        .info-part01.list_item .title p{
            text-align: center;
        }
        .info-part01.list_item .title p span{
            display: inline;
            font-size: 28px;
        }
        .info-part01.list_item .title p span.xm{
            font-size:32px;
        }
        .info-main {
            /*background: #e0d0b7;*/
            top: 600px;
            position: absolute;
            margin-bottom: 80px;
            width: 660px;
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
    </style>
@endsection

@section('content')
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/2/bg2.jpg" width="100%"></section>
    @if($type==0)
    <section class="info_top list_box clearfix">
        <div class="info-part01 list_item">
        <div class="head-img"><img src='<?php echo $candidate->pic_url ? 'http://qiniu.langzoo.com/'. $candidate->pic_url : $qiniu_cdn_path.'/images/default_doc_avatar.jpg';?>'/></div>
            <div class="title">
                <p class="title-first">
                    <span class="xm">{{ $candidate->name }}</span>
                    <span class="zc">{{ $candidate->title }}</span>
                </p>
                <p>
                    <span class="yy">{{ $candidate->of_hospital }}</span>
                    <span class="yy">{{ $candidate->of_dep }}</span>
                </p>
            </div>
    </section>
    
    <section class="footer_info info-vote">
        <p>已有<span class="num">{{ $candidate->num }}</span>人为TA投票</p>
        @if($candidate->status==0)
        <div class="main_btn">投TA一票</div>
        @endif
    </section>
    
    <section class="info-main clearfix">
        <div class="info-part02 info-main-part">
            <div class="info-main-title">擅长</div>
            <p class="info02 info-main-details">{!! $candidate->shanchang !!}</p>
        </div>
        <div class="info-part03 info-main-part">
            <div class="info-main-title">坐诊时间</div>
            <p class="info03 info-main-details">{{ $candidate->schedule_time }}</p>
        </div>
        <div class="info-part04 info-main-part">
            <div class="info-main-title">医生简介</div>
            <p class="info04 info-main-details">{!! $candidate->desc !!}</p>
        </div>
    </section>
    
    @else
    <section class="info_top list_box clearfix">
        <div class="info-part01 list_item">
        <div class="head-img"><img src='<?php echo $candidate->doctor_avatar ? 'http://qiniu.langzoo.com'. $candidate->doctor_avatar : $qiniu_cdn_path.'/images/default_doc_avatar.jpg';?>'/></div>
            <div class="title">
                <p class="title-first">
                    <span class="xm">{{ $candidate->doctor_name }}</span>
                    <span class="zc">{{ $candidate->doctor_title }}</span>
                </p>
                <p>
                    <span class="yy">{{ $candidate->hospital }}</span>
                    <span class="yy">{{ $candidate->doctor_dep }}</span>
                </p>
            </div>
    </section>
    
    <section class="info-main top-420 clearfix">
        <div class="info-part02 info-main-part">
            <div class="info-main-title">擅长</div>
            <p class="info02 info-main-details">{!! $candidate->doctor_goodat !!}</p>
        </div>
        <div class="info-part03 info-main-part">
            <div class="info-main-title">坐诊时间</div>
            <p class="info03 info-main-details">{!! $candidate->schedule_time !!}</p>
        </div>
        <div class="info-part04 info-main-part">
            <div class="info-main-title">医生简介</div>
            <p class="info04 info-main-details">{!! $candidate->doctor_intro !!}</p>
        </div>
    </section>
   @endif
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.jquery.min.js" type="text/javascript"></script>
    <script type="application/javascript">
        $(function () {
            var submintVoteStatus = 0;
            var captchaShowStatus = 0;
            $('.tp_btn2,.tp_btn1,#captcha_code_btn,.main_btn').click(function () {
                if ('{{ $vote->captcha_status }}' == 1 && captchaShowStatus == 0) {
                    $('.yanzhengcode').css('display', 'block');
                    captchaShowStatus = 1;
                    return false;
                }
               
                if(submintVoteStatus == 1){
                    return false;
                }
               
                if('{{ $subscribe }}' !== '1'){
                    $('.footer_nav_gz2 a').click(); return false;
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

            //banner图滚动效果
            var mySwiper = new Swiper(".swiper-container",{  
                direction:"horizontal",/*横向滑动*/  
                loop:true,/*形成环路（即：可以从最后一张图跳转到第一张图*/  
                pagination:".swiper-pagination",/*分页器*/  
                //prevButton:".swiper-button-prev",/*前进按钮*/  
                //nextButton:".swiper-button-next",/*后退按钮*/  
                autoplay:3000/*每隔3秒自动播放*/  
            })  

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

        });
    </script>
@endsection
