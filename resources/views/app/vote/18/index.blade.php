<!-- mini马拉松 -->
@extends('layouts.home')


<?php $footer = 'app.vote.'.$id.'.footer';?>
<?php $modal = 'app.vote.'.$id.'.modal';?>

@section('selfmeta')
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
@endsection

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <style>
        .modal-box-main{height: 400px;margin-top: 100px;}
        .count-time{margin-top: .4rem}
        .count-num{box-shadow: 0px 0px 10px 2px rgba(162, 4, 13, 0.2); margin-bottom: .2rem;}
    </style>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="mara-head"> </div>
    <div class="mara-board">
        <div class="board-content">
            <div class="board-item">
                <div class="board-name">榜单总数</div>
                <div class="board-num">{{ $candidatesNum }}</div>
            </div>
            <i class="board-line"></i>
            <div class="board-item">
                <div class="board-name">点赞总数</div>
                <div class="board-num">{{ $votesNum }}</div>
            </div>
            <i class="board-line"></i>
            <div class="board-item">
                <div class="board-name">浏览总数</div>
                <div class="board-num">{{ $vote->clicks }}</div>
            </div>

        </div>
    </div>
    <div class="count-time hide">
        <div class="count-item">
            <p>Days</p>
            <div class="count-num day1"></div>
            <div class="count-num right day2"></div>
        </div>
        <div class="count-colon">:</div>
        <div class="count-item">
            <p>Hours</p>
            <div class="count-num hour1"></div>
            <div class="count-num right hour2"></div>
        </div>
        <div class="count-colon">:</div>
        <div class="count-item">
            <p>Minutes</p>
            <div class="count-num min1"></div>
            <div class="count-num right min2"></div>
        </div>
        <div class="count-colon">:</div>
        <div class="count-item">
            <p>Seconds</p>
            <div class="count-num sec1"></div>
            <div class="count-num right sec2"></div>
        </div>
    </div>
    <div class="mara-votes">
        <div class="votes-content">
            {{--<div class="votes-item">
                <a href="">
                    <div class="votes-avatar">
                        <img src="{{ $qiniu_cdn_path }}/images/vote/18/index/曾国军.png"/>
                    </div>
                   --}}{{-- <div class="votes-name"><span></span></div>--}}{{--
                    <div class="votes-num">我已影响<span>255555</span>人</div>
                   --}}{{-- <div class="votes-btn">给Ta点赞</div>--}}{{--
                </a>
            </div>--}}
            @foreach($candidates as $key => $candidate)

                    <div class="votes-item">
                        <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $candidate->id]) }}?id={{ Input::get('id') }}">
                            <div class="votes-avatar">
                                <img src="{{ $qiniu_cdn_path }}/images/vote/{{ Input::get('id') }}/index/{{ $candidate->name }}.png"/>
                            </div>
                            {{--<div class="votes-name">{{ $candidate->name }}<span>{{ $candidate->department }}</span></div>--}}
                            <div class="votes-num">我已影响<span>{{ $candidate->num }}</span>人</div>
                           {{-- <div class="votes-btn">给Ta点赞</div>--}}
                        </a>
                    </div>

            @endforeach

        </div>

    </div>
    {{--<div class="mara-recommend"><img src="{{ $qiniu_cdn_path }}/images/vote/18/logo.png"> </div>
    <div class="swiper-container mara-swipper"><!--swiper容器[可以随意更改该容器的样式-->
        <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/health/circle/detail.do?circleId=17"><img src="{{ $qiniu_cdn_path }}/images/vote/18/point-invite.png"></a></div>
        </div><!--784开始不一样-->
        <div class="swiper-pagination" style="float: right"></div><!--分页器-->
        <!--<div class="swiper-button-prev"></div><!--前进按钮-->
        <!--<div class="swiper-button-next"></div><!--后退按钮-->
    </div>--}}
    <p class="mara-support">主办方：成都市疾病预防控制中心</p>
    <p class="mara-subsupport">承办方：成都商报四川名医</p>
    <a href="javascript:void(0) " class="return-btn" style="right: .3rem">
        {{--<div class="index-icon"></div>--}}
        <p style="font-size: 11px;line-height: .4rem;padding-top: .1rem">活动<br>规则</p>
    </a>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.jquery.min.js" type="text/javascript"></script>
    <script type="application/javascript">
        $(function () {

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
                    imgUrl: '<?php if(strpos($shareInfo['shareLogo'], 'http')===false){echo asset('storage/'.$shareInfo['shareLogo']);}else{echo $shareInfo['shareLogo'];}?>', // 分享图标
                    //imgUrl: '{{ asset($shareInfo['shareLogo']) }}', // 分享图标
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
    <script>
        $(function () {
            window.setInterval(getTimer,10);/!*设置不间断定时器执行getTimer函数*!/
            function getTimer() {
                var d ="{{ $vote->start_time }}";
                var s = d.replace(/-/g, "/");
                var endtime=new Date(s);  /!*定义结束时间*!/
                var nowtime=new Date();/!*获取当前时间*!/
                var cha=endtime.getTime()-nowtime.getTime();/!*得到它们相差的时间*!/
                var day=Math.floor(cha/1000/60/60/24); /!*划分出时分秒*!/
                var hour=Math.floor(cha/1000/60/60%24);
                var minute=Math.floor(cha/1000/60%60);
                var second=Math.floor(cha/1000%60);
                if (day <= 9 && day >=0) day = '0' + day;
                if (minute <= 9 && minute >=0) minute = '0' + minute;
                if (second <= 9 && second >=0) second = '0' + second;
                if (hour <= 9 && hour>=0) hour = '0' + hour;
                if (nowtime >= endtime){
                    $('.count-time').hide();
                }
                var sday = day.toString().split('',2);
                var shour = hour.toString().split('',2);
                var smin = minute.toString().split('',2);
                var secs = second.toString().split('',2);
                $('.day1').text(sday[0]);
                $('.day2').text(sday[1]);
                $('.hour1').text(shour[0]);
                $('.hour2').text(shour[1]);
                $('.min1').text(smin[0]);
                $('.min2').text(smin[1]);
                $('.sec1').text(secs[0]);
                $('.sec2').text(secs[1]);


            }


        });
        /*var mySwiper = new Swiper(".swiper-container",{
            direction:"horizontal",/!*横向滑动*!/
            loop:true,/!*形成环路（即：可以从最后一张图跳转到第一张图*!/
            pagination:".swiper-pagination",/!*分页器*!/
            //prevButton:".swiper-button-prev",/!*前进按钮*!/
            //nextButton:".swiper-button-next",/!*后退按钮*!/
            autoplay:4000/!*每隔3秒自动播放*!/
        });*/
        // 搜索
        $('.footer-search').click(function () {
            $(window).scrollTop(0);
            $(".search_box").removeClass('box_hide');
        });
        $('.search_box').click(function () {
            $(".search_box").addClass('box_hide');
        })
        $('.search_box_main').click(function () {
            event.stopPropagation(); //阻止事件冒泡
        })
        $('.return-btn').click(function () {
            $('.rule_box').removeClass('box_hide');
        })

        function closeRules() {
            $('.rule_box').addClass('box_hide');
        }

    </script>
@endsection