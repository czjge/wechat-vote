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
            min-height: 400px;
            border-radius: 0;
            left: 0;
            position: relative;
            border:0;
            padding-bottom: 10px;
            background: url(../../../images/vote/4/info-bg.jpg) no-repeat;
        }
        .info-part01.list_item .head-img img{
            width: 520px;
            border: 20px solid #fff;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.2);
            margin-top: 30px;
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
            width: 690px;
            padding: 0 30px;
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
            width: 100%;
            margin-bottom: 20px;
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
    </style>
@endsection

@section('content')

    <section class="info_top list_box clearfix">
        <div class="info-part01 list_item">
            <div class="head-img">
                @if ($candidate->has_video==0)
                    <img src='{{ $qiniu_cdn_path }}/images/vote/{{ $id }}/cover/info/{{ $candidate->no }}.jpg'/>
                @else
                    {{--<embed src="{{ $qiniu_cdn_path }}/videos/{{ $candidate->no }}.mp4" autostart="true" loop="true" width="750" height="450" >--}}
                    <video src="{{ config('home.huaXiSongVideoUrl') }}{{ $candidate->no }}.mp4" id="videoBox" controls="controls" autoplay="autoplay" loop="loop" width="750" height="450"></video>
                @endif
                <p style="font-size: 20px;color: #999;margin-top: 15px;text-align: left;text-indent: 100px;">建议WIFI环境观看/收听，土豪随意</p>
            </div>
            @if ($candidate->has_video==0)
                <audio style="display:none" id="musicBox" controls="controls" autoplay="autoplay" loop="loop"></audio>
            @endif
            <div class="title">
                <p class="title-first">
                    <span class="xm">{{ $candidate->name }}</span>
                    <span class="ks">{{ $candidate->of_dep }}</span>
                </p>
                <p>
                    <!--作词作曲：--><span class="cq-name">{{ $candidate->composer }}</span>
                </p>
                <p>演唱者：<span class="yc-name">{{ $candidate->singer }}</span></p>
            </div>
            @if ($candidate->has_video==0)
                <div class="play pp-btn box_hide"></div><!-- 播放 -->
                <div class="pause pp-btn"></div><!-- 暂停 -->
            @endif
        </div>
    </section>

    <section class="info-main clearfix">
        <div class="info-part02">
            <p class="info1 info1-hide">{!! $candidate->desc !!}</p>
            <p class="info1-all">点击查看全部歌词</p>
        </div>
    </section>
    
    <section class="footer_info info-vote">
        <p>已有<span class="num">{{ $candidate->num }}</span>人为TA投票</p>
        <div class="main_btn"></div>
    </section>

    <section class="review-info">
        <div class="info-5 review-panel">
            <div class="info-title">
                <span>评论({{ $comment_number }})</span>
                <a href="javascript:void(0);" class="to-review-box"><i></i>写评论</a>
            </div>
            <ul id="comment_ul">
                <volist name="commentInfo" id="comment">
                    @foreach ($comment_list as $item)
                        <li>
                            <div class="myhead-img" style="background-image: url('{{ $item->headimgurl }}')"></div>
                            <div class="review-text">
                                <p><span class="review-name">{{ $item->name }}</span><span class="review-time">{{ date('Y:m:d H:i', $item->comment_time) }}</span></p>
                                <label class="">{{ $item->comment }}</label>
                            </div>
                        </li>
                    @endforeach
                </volist>
            </ul>
            @if ($comment_number>10&&$type!=1)
                <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$candidate->id]).'?id='.$id.'&type=1' }}">点击加载全部</a>
            @endif
        </div>
    </section>
    
    <section class="review_box clearfix box_hide" style="z-index: 70">
        <div class="review_main clearfix">
            <div class="review">
                <textarea placeholder="请在这里输入您的评论" id="commentContent" maxlength=300></textarea>
                <div class="row">
                    <input type="button" id="form_cancel" value="取消" class="col-30 goback button button-fill button-big bg-gray color-666"/>
                    <input type="button" id="commnet_submit" value="提交" class="col-70 button button-fill button-big color-blue"/>
                    <input type="button" id="commnet_submits" value="提交中" class="col-70 button button-fill button-big color-blue box_hide"/>
                    <!--<a href="#" id="form_cancel" class="col-30 goback button button-fill button-big bg-gray color-666">取消</a>
                    <a href="#" id="form_submit" class="col-70 button button-fill button-big color-blue">提交</a>-->
                </div>
            </div>
        </div>
        <div class="close_box count_down_close_box"></div>
    </section>

@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.jquery.min.js" type="text/javascript"></script>
    <script type="application/javascript">
         // 评论
        $(document).on('click', '#form_cancel', function () {
                $(".review_box").addClass('box_hide');
                $("#videoBox").removeClass('box_hide');
        });
        $(document).on('click', '.to-review-box', function () {
                $(window).scrollTop(0);
                $(".review_box").removeClass('box_hide');
                $("#videoBox").addClass('box_hide');
                var a = '<?php if (strtotime($vote->start_time) > time() || time() > strtotime($vote->end_time)) {
                                        echo 1;
                                    } else {
                                        echo 2;
                                    }
                            ?>';
                if (a==1) {
                    tusi("投票未开始或已结束，不可评论");
                }
        });

        $(function () {
            // comment
            var submintCommentStatus = 0;
            $('#commnet_submit').click(function () {
                var a = '<?php if (strtotime($vote->start_time) > time() || time() > strtotime($vote->end_time)) {
                    echo 1;
                } else {
                    echo 2;
                }
                    ?>';

                if (a==1) {
                    tusi("投票未开始或已结束，不可评论");
                    return false;
                }

                if(submintCommentStatus == 1){
                    return false;
                }

                if('{{ $subscribe }}' !== '1'){
                    $("#videoBox").addClass('box_hide');
                    $('.footer_nav_gz2 a').click(); return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var ajaxCommentUrl = "{{ $ajax_comment_url }}&type={{ $type }}";
                var comment = $('#commentContent').val()    ;

                if($.trim(comment)==''){
                    tusi("评论内容不能为空");
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: ajaxCommentUrl,
                    dataType : "json",
                    data: {'comment':comment},
                    beforeSend: function () {
                        loading('请稍后');
                        submintCommentStatus = 1;
                        $("#commnet_submit").hide();
                        $("#commnet_submits").show();
                    },
                    complete: function () {
                        loading(false);
                        submintCommentStatus = 0;
                    },
                    success: function(data){
                        if (data.code == 200) {
                            tusi(data.msg);
                            setTimeout(function(){
                                window.location.href = '{{ $reloadUrl }}&type={{ $type }}';
                            },1888);
                        }else {
                            tusi(data.msg);
                            tusi("请再试一次");
                            setTimeout(function(){
                                window.location.href = '{{ $reloadUrl }}&type={{ $type }}';
                            },1888);
                        }
                    }
                });
            });

            // vote
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
            });

            // wechat jssdkConfig.
            wx.config({
                debug: false,
                appId: '{{ $wxJssdkConfig->appId }}',
                timestamp: '{{ $wxJssdkConfig->timestamp }}',
                nonceStr: '{{ $wxJssdkConfig->nonceStr }}',
                signature: '{{ $wxJssdkConfig->signature }}',
                jsApiList: ['hideAllNonBaseMenuItem', 'showMenuItems', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ']
            });

            // 查看全部歌词
            $('.info1-all').click(function () {
                if ($('.info1').hasClass('info1-hide')) {
                    $('.info1').removeClass('info1-hide');
                    $('.info1-all').text('点击隐藏部分歌词');
                } else {
                    $('.info1').addClass('info1-hide');
                    $('.info1-all').text('点击查看全部歌词');
                }

            });

            // 音频播放
            var media = document.getElementById("musicBox");
//            $('#getTime').click(function () {
//                console.log(media.currentTime)
//            });
            $('.play').click(function () {
                $('.pause').removeClass('box_hide');
                $('.play').addClass('box_hide');
                media.play();
                return false;
            });
            $('.pause').click(function () {
                $('.play').removeClass('box_hide');
                $('.pause').addClass('box_hide');
                media.pause();
                return false;
            });
            wx.ready(function () {
                // 自动播放，循环播放
                if ('{{ $candidate->has_video }}'==0) {
                    media.src = "{{ config('home.huaXiSongAudioUrl') }}{{ $candidate->no }}.mp3";
                    media.play();
                }
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
