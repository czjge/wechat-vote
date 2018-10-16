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
        .info-part01{
            margin: 20px 0 10px 0;
        }
    </style>
@endsection

@section('content')
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/16/rank-banner2.jpg?v=2" width="100%"></section>

    <section class="info_top list_box clearfix">
        <div class="swiper-container"><!--swiper容器[可以随意更改该容器的样式-->  
            <div class="swiper-wrapper">  
                <div class="swiper-slide"><img <?php if($candidate->type>0){echo 'style="height: 100%;"';}?> src='<?php echo $candidate->pic_url ? (strpos($candidate->pic_url, 'http')===false ? $qiniu_cdn_path.'/storage/'.$candidate->pic_url : $candidate->pic_url) : $qiniu_cdn_path.'/images/default_doc_avatar.jpg';?>?v=2'/></div>  
                <div class="swiper-slide"><img <?php if($candidate->type>0){echo 'style="height: 100%;"';}?> src='<?php echo $candidate->pic_url2 ? (strpos($candidate->pic_url2, 'http')===false ? $qiniu_cdn_path.'/storage/'.$candidate->pic_url2 : $candidate->pic_url2) : $qiniu_cdn_path.'/images/default_doc_avatar.jpg';?>?v=2'/></div>
            </div>  
            <div class="swiper-pagination" style="float: right"></div><!--分页器-->  
            <!--<div class="swiper-button-prev"></div><!--前进按钮-->  
            <!--<div class="swiper-button-next"></div><!--后退按钮-->  
        </div> 

        <div class="info-part01 list_item">
        <!--<div class="head-img"><img <?php if($candidate->type==1){echo 'style="height: 100%;"';}?> src='<?php echo $candidate->pic_url ? (strpos($candidate->pic_url, 'http')===false ? $qiniu_cdn_path.'/storage/'.$candidate->pic_url : $candidate->pic_url) : $qiniu_cdn_path.'/images/default_doc_avatar.jpg';?>'/></div>-->
            <div class="title">
                @if(($candidate->type)>0)
                <p class="title-first">
                    <span class="xm">{{ $candidate->of_hospital }}</span>
                </p>
                <p>
                    <span class="yy">{{ $district }}</span>
                </p>
                <p>
                    <span class="yy"></span>
                </p>
                @else
                <p class="title-first">
                    <span class="xm">{{ $candidate->of_dep }}</span>
                </p>
                <p>
                    <span class="yy">{{ empty($candidate->of_hospital) ? $candidate->address : $candidate->of_hospital }}</span>
                </p>
                <p>
                    <span class="yy"></span>
                </p>
                @endif
            </div>

            <!-- captcha -->
            @if($vote->captcha_status == 1)
            <div class="yanzhengcode" style="display: none;">
                <img src="{{ route('base.getCaptcha') }}" onclick="javascript:this.src='{{ route('base.getCaptcha') }}?'+Math.random()" id="captcha_img"/>
                <input type="text" name="captcha_code" id="captcha_code" placeholder="请输入验证码"/>
                <input type="button" value="确定" id="captcha_code_btn"/>
            </div>
            @endif

            <div class="msg_box">
                <label><span class="num">{{ $candidate->num }}</span>票</label>

                @if(strtotime($vote->start_time) > time())
                    <div class="btn_box">未开始</div>
                @elseif(strtotime($vote->end_time) > time())

                    @if($candidate->status==2)
                        <div class="btn_box">被锁定</div>
                    @elseif($vote->captcha_status==1)
                        <div class="tp_btn1 btn_box">投TA一票</div>
                    @else
                        <div class="tp_btn2 btn_box">投TA一票</div>
                    @endif

                @else
                    @if($candidate->rank!=2)
                    <a href="{{ route('home.form.getForm'.$candidate->vote_id,['cid'=>$candidate->id,'id'=>$candidate->vote_id]) }}">
                        <div class="btn_box">预签约</div>
                    </a>
                    @else
                    <div class="btn_box">已结束</div>
                    @endif
                @endif
            </div>
        </div>
    </section>

    <section class="info-main clearfix">
        <div class="info-part02">
            <p class="info1">{{ $candidate->desc }}</p>
        </div>
    </section>
    <section class="footer_info">
        <p>已有<span class="num">{{ $candidate->num }}</span>人为TA投票</p>
        <div class="main_btn box_hide">投TA一票</div>
        @if($candidate->rank!=2)
        <a href="{{ route('home.form.getForm'.$candidate->vote_id,['cid'=>$candidate->id,'id'=>$candidate->vote_id]) }}">
            <div class="sign_btn box_hide">家庭医生预签约</div>
        </a>
        @endif
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
                    $('.footer_nav_gz a').click(); return false;
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
                            tusi(data.msg);
                        } else if (data.code == 209) {
                            afterCheckCaptcha();
                            $('.footer_nav_gz a').click();
                        } else if (data.code == 210) {
                            afterCheckCaptcha();
                            tusi("请再试一次");
                            setTimeout(function(){
                                window.location.href = '{{ $reloadUrl }}';
                            },1888);
                        } else if (data.code == 211) {
                            $('#captcha_code').val('');
                            tusi(data.msg);
                        } else if (data.code == 202) {
                            afterCheckCaptcha();
                            tusi(data.msg);
                        }else {
                            afterCheckCaptcha();
                            tusi(data.msg);
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

        });
    </script>
@endsection
