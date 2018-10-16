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
        .info_top{
            top: 340px;
            position: absolute;
            background: transparent;
            text-align: center;
        }
        .info-part01{
            background: transparent;
            min-height: 420px;
        }
        .info-part01.list_item .head-img {
            /* top: 0; */
            width: 280px;
            height: 280px;
            border-radius: 20px;
            left: 235px;
            border: 5px solid #e3fcf1;
        }
        .info-part01.list_item .title{
            width: 100%;
            left: 0;
            height: 100px;
            top: 320px;
            color: #fff;
        }

        .info-part01.list_item .title .title-first{
            max-width: 100%;
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
        section.footer_info.info-vote{
            top: 780px;
        }
        .info-main {
            /*background: #e0d0b7;*/
            position: absolute;
            margin-bottom: 80px;
            width: 690px;
            padding: 20px 30px 0 30px;
        }
        .top-970{
            top: 970px;
        }
        .info-main-part{
            color: #38675e;
            font-size: 28px;
            margin-bottom: 50px;
        }
        .info-main-title{
            color: #fff;
            font-size: 30px;
            line-height: 69px;
            width: 100%;
            background: url("{{ $qiniu_cdn_path }}/images/vote/5/red-con.png") no-repeat top center ;
            text-align: center;
            display: inline-block;
        }
        .info-main-details{
            background: #e3fcf1;
            padding: 60px 30px 30px 30px;
            margin-top: -30px;
            border-radius: 20px;
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

        .main_btn_box_main{
            width: 690px;
            border:0;
            background: rgba(111,201,184,0.95);
        }
        .main_btn_box-title {
            color: #fff;
            font-size: 60px;
            background: url(../../../images/vote/5/vote-bg.png) no-repeat center center;
            height: 141px;
            line-height: 141px;
            text-align: center; 
            margin-top: 10px;
        }
        .main_btn_box-title b{
            font-size: 60px;
        }
        .main_btn_box_main .msg_box{
            padding:10px 30px 40px 30px;
        }
        p.gift-title {
            width: 695px;
            height: 133px;
            background: url(../../../images/vote/5/gift-bg.png) no-repeat;
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
    </style>
@endsection

@section('content')
    <section class="top_box clearfix">
        <img src="{{ $qiniu_cdn_path }}/images/vote/5/top10.jpg" width="100%">
        <img src="{{ $qiniu_cdn_path }}/images/vote/5/info-bg2.png" width="100%">
    </section>

    <section class="info_top list_box clearfix">
        <div class="info-part01 list_item">
            <div class="head-img"><img src="<?php if($candidate->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$candidate->pic_url;}?>"/></div>
            <div class="title">
                <p class="title-first">
                    <span class="xm">{{ $candidate->name }}</span>
                    <span class="zc">{{ $candidate->title }}</span>
                </p>
                <p>
                    <span class="yy">{{ $candidate->of_hos }}</span>
                    <span class="yy">{{ $candidate->of_dep }}</span>
                </p>
            </div>
    </section>

    <section class="footer_info info-vote box_hide">
        <p>已有 <span class="num">{{ $candidate->num }}</span> 人为TA投票</p>
        <a href="javascript:void(0);"><div class="main_btn">投TA一票</div></a>
    </section>

    <section class="info-main clearfix"><!--专家时去掉‘top-970’-->
        <div class="info-part02 info-main-part">
            <div class="info-main-title">擅长</div>
            <p class="info02 info-main-details">{{ $candidate->goodat }}</p>
        </div>
        <div class="info-part03 info-main-part">
            <div class="info-main-title">坐诊时间</div>
            <p class="info03 info-main-details">{{ $candidate->schedule_time }}</p>
        </div>
        <div class="info-part04 info-main-part">
            <div class="info-main-title">医生简介</div>
            <p class="info04 info-main-details">{{ $candidate->desc }}</p>
        </div>
    </section>
    <!--投票成功-->
    <section class="main_btn_box clearfix box_hide">
        <div class="main_btn_box_main clearfix" style=" max-height: 1000px;overflow: scroll;">
            <div class="msg_box">
                <p class="main_btn_box-title"><b id="after_vote_msg"></b></p>
                <p class="gift-title"></p>
                <div class="gift-info ">
                <div class="swiper-container"><!--swiper容器[可以随意更改该容器的样式-->
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/health/circle/detail.do?circleId=17&code_=001PB6Yk0NtCQj1pFzYk0zfYXk0PB6Yw&state=circleId=17"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg8.jpg"></a></div>
                        <div class="swiper-slide"><a href="http://yym.zhongsou.com/Cloudshare/index?keyword=&srpId=&url=http%253A%252F%252Fydy.zhongsou.com%252FWebApi%252Fcustom_detail%253FmongoId%253D5a5dff0cb385242d4a55dbf0-11&token=e85c7f8c-37b2-4d0b-873c-f5a736aef671&pfAppName=com.chengdushangbao"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg6.jpg"></a></div>
                        <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=49"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg2.jpg"></a></div> 
                        <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=53"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg7.jpg"></a></div>  
                        <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=50"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg3.jpg"></a></div>
                        <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=51"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg4.jpg"></a></div>
                        <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=52"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg5.jpg"></a></div>
                    </div>
                    <div class="swiper-pagination" style="float: right"></div><!--分页器--> 
                    <!--<div class="swiper-button-prev"></div><!--前进按钮-->  
                    <!--<div class="swiper-button-next"></div><!--后退按钮-->  
                </div>
                    <!--<a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=49"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg2.jpg"></a>
                    <a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=50"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg3.jpg"></a>
                    <a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=51"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg4.jpg"></a>
                    <a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=52"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg5.jpg"></a>-->
                </div>
            </div>
        </div>
        <div class="close_box main_btn_box_close">关闭</div>

    </section>

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
            // 投票成功
            $(".main_btn_box").removeClass('box_hide');
            $('#after_vote_msg').text(data.msg);
            //tusi(data.msg);
            } else if (data.code == 209) {
            // 先关注
            afterCheckCaptcha();
            $('.footer_nav_gz2 a').click();
            } else if (data.code == 210) {
            // session失效
            afterCheckCaptcha();
            tusi("请再试一次");
            setTimeout(function(){
            window.location.href = '{{ $reloadUrl }}';
            },1888);
            } else if (data.code == 211) {
            // 验证码错误
            $('#captcha_code').val('');
            $(".main_btn_box").removeClass('box_hide');
            $('#after_vote_msg').text(data.msg);
            //tusi(data.msg);
            } else if (data.code == 202) {
            // 投票未开始或者已经结束
            afterCheckCaptcha();
            $(".main_btn_box").removeClass('box_hide');
            $('#after_vote_msg').text(data.msg);
            tusi(data.msg);
            }else {
            afterCheckCaptcha();
            $(".main_btn_box").removeClass('box_hide');
            $('#after_vote_msg').text(data.msg);
            //tusi(data.msg);
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
                link: '{{ $shareInfo['shareUrl'] }}', // 分享链接
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
                link: '{{ $shareInfo['shareUrl'] }}', // 分享链接
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

            //投票成功
            $(document).on('click', '.main_btn', function () {
            $(".main_btn_box").removeClass('box_hide');
            //banner图滚动效果
                var mySwiper = new Swiper(".swiper-container",{
                    direction:"horizontal",/*横向滑动*/
                    loop:true,/*形成环路（即：可以从最后一张图跳转到第一张图*/
                    pagination:".swiper-pagination",/*分页器*/
                    //prevButton:".swiper-button-prev",/*前进按钮*/
                    //nextButton:".swiper-button-next",/*后退按钮*/
                    autoplay:3000/*每隔3秒自动播放*/
                });
            });

        });
    </script>
@endsection
