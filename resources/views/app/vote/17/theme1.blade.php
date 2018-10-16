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
        .footer_main{display: none}
    </style>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="theme-head"></div>
    {{--<div class="theme-tab">
        <a class="reg-href">参赛报名</a>
        <div class="tab-opt tab-index active">官方首页</div>
        <div class="tab-opt tab-activity">嘉年华活动</div>
        <div class="tab-opt tab-rules">赛事规程</div>
        <i class="icon-rarrow hide"></i>
    </div>--}}
    <div class="theme-tab">
        <a class="reg-href">参赛报名</a>
        {{--<div class="swiper-container theme-swipper"><!--swiper容器[可以随意更改该容器的样式-->
            <div class="swiper-wrapper">
                <div class="swiper-slide"><div class="tab-opt active">官方首页</div></div>
            </div><!--784开始不一样-->
            <div class="swiper-pagination" style="float: right"></div><!--分页器-->
            <!--<div class="swiper-button-prev"></div><!--前进按钮-->
            <!--<div class="swiper-button-next"></div><!--后退按钮-->
        </div>--}}
        <div class="tab-opt active">官方首页</div>
        <div class="tab-opt">嘉年华活动</div>
        <div class="tab-opt">赛事规程</div>

        <i class="icon-rarrow hide"></i>
    </div>
    <div class="tab-contents index-content clearfix">
        <div class="swiper-container theme-swipper"><!--swiper容器[可以随意更改该容器的样式-->
            <div class="swiper-wrapper">
                <div class="swiper-slide"><a href="https://mp.doctorofsc.cn/vote/index?id=17"><img src="{{ $qiniu_cdn_path }}/images/vote/17/ad1.png"></a></div>
                <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/health/circle/detail.do?circleId=17"><img src="{{ $qiniu_cdn_path }}/images/vote/17/ad3.jpg"></a></div>
            </div><!--784开始不一样-->
            <div class="swiper-pagination" style="float: right"></div><!--分页器-->
            <!--<div class="swiper-button-prev"></div><!--前进按钮-->
            <!--<div class="swiper-button-next"></div><!--后退按钮-->
        </div>
        <div class="count-content">
            <p>距离2018成都首届亲子mini马拉松赛：</p>
            <div class="count-time">
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
            <div class="theme-container">
                <div class="theme-long-con theme-org">
                    <p>主办单位：</p>
                    <p>成都商报、成都商报四川名医 </p>
                </div>
                <div class="run-logo-right"></div>
            </div>
            <div class="theme-container">
                <div class="theme-small-con theme-time">
                    <div class="theme-name">报名时间</div>
                    <div class="theme-start-time">05.14&nbsp;&nbsp;9:00</div>
                    <div class="theme-medi">至</div>
                    <div class="theme-start-time" style="margin-top: -2px">05.19&nbsp;&nbsp;18:00</div>
                </div>
                <div class="theme-small-con theme-time right">
                    <div class="theme-name">检录时间</div>
                    <div class="theme-start-time mrg-t15">2018.05.26</div>
                    <div class="theme-start-time" style="margin-top: 4px">8:00</div>
                </div>
            </div>
            <div class="theme-container">
                <div class="theme-long-con theme-location">
                    <p>秀丽东方景区</p>
                    <p>（成都市锦江区锦江大道湿地路） </p>
                </div>
                <div class="run-logo-left"></div>
            </div>
            <div class="theme-container">
                <div class="theme-small-con theme-events">
                    <p>迷你马拉松（5公里）</p>
                    <p>欢乐跑（2.5公里）</p>
                </div>
                <div class="theme-small-con theme-group right">
                    <p>A组（6岁及以下）</p>
                    <p>B组（7-9岁）</p>
                    <p>C组（10-12岁）</p>
                </div>
            </div>
            <div class="theme-container">
                <div class="theme-long-con theme-cost">
                    <p>报名费：101元</p>
                    <p>（含一位大人及一位小孩保险费） </p>
                </div>
                <div class="run-logo-right"></div>
            </div>
        </div>
        <div class="theme-block"></div>
        <div class="them-company">
            <div class="glong-line">首席合作伙伴</div>
            <div class="first-com company-item"><img src="{{ $qiniu_cdn_path }}/images/vote/17/company.png"> </div>
            <div class="glonger-line">指定医疗保障单位</div>
            <div class="first-com company-item" style="width: 5rem"><img src="{{ $qiniu_cdn_path }}/images/vote/17/company7.png"> </div>
            <div class="gra-line">合作伙伴</div>
            <div class="company-content">
                <div class="company-item"><img src="{{ $qiniu_cdn_path }}/images/vote/17/company1.png"> </div>
                <div class="company-item"><img src="{{ $qiniu_cdn_path }}/images/vote/17/company3.png"> </div>
                <div class="company-item"><img src="{{ $qiniu_cdn_path }}/images/vote/17/company4.png"> </div>
            </div>
            <div class="company-content">
                <div class="company-item"><img src="{{ $qiniu_cdn_path }}/images/vote/17/company5.png"></div>
                <div class="company-item"><img src="{{ $qiniu_cdn_path }}/images/vote/17/company6.png"></div>
                <div class="company-item"><img src="{{ $qiniu_cdn_path }}/images/vote/17/company2.png"></div>
            </div>
        </div>
        <div class="com-part"></div>
        <p class="mara-support mrg-t3" style="margin-bottom: 0">主办单位：成都商报社、成都商报四川名医</p>
        <p class="mara-support mrg-t15" style="margin-bottom: .1rem">&nbsp;咨询电话：<a href="tel:02869982575">028-69982575</a></p>
        <p class="mara-support" style="margin-bottom: .3rem;margin-top: .1rem">招商电话：<a href="tel:‭18583795519">‭18583795519</a></p>
        <div class="code-content">
            <div class="code-img"><img src="{{ $qiniu_cdn_path }}/images/vote/17/shangbao.jpg"></div>
            <div class="code-img"><img src="{{ $qiniu_cdn_path }}/images/vote/17/mingyi.jpg"></div>
        </div>
    </div>
    <div class="tab-contents second-content hide clearfix">
        {{--嘉年华活动--}}
    </div>
    <div class="tab-contents third-content  hideclearfix">
        {{--<p class="title"><b>2018成都首届亲子mini马拉松规程</b></p>
        <p class="subtitle">一、活动日期和地点</p>
        <p>时间：2018年5月26日（星期六）</p>
        <p>地点：秀丽东方园区</p>
        <p class="subtitle">二、活动项目</p>
        <p>迷你马拉松（5公里） </p>
        <p>欢乐跑（2.5公里） </p>
        <p class="subtitle">三、活动组别</p>
        <p>A组（6岁及以下）赛程：2.5KM</p>
        <p>B组（7-9岁）赛程：5KM</p>
        <p>C组（10-12岁）赛程：5KM </p>
        <p class="subtitle">四、起跑时间</p>
        <p>2018年5月26日 上午 9:00</p>
        <p class="subtitle">四、起跑时间</p>
        <p></p>--}}
    </div>
@endsection
@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.jquery.min.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script>
        var mySwiper = new Swiper(".swiper-container",{
            direction:"horizontal",/*横向滑动*/
            loop:true,/*形成环路（即：可以从最后一张图跳转到第一张图*/
            pagination:".swiper-pagination",/*分页器*/
            //prevButton:".swiper-button-prev",/*前进按钮*/
            //nextButton:".swiper-button-next",/*后退按钮*/
            autoplay: 4000/*每隔3秒自动播放*/
        });
        $('.tab-index').click(function () {
            $('.tab-opt').removeClass('active');
            $(this).addClass('active');
            $('.tab-contents').addClass('hide');
            $('.index-content').removeClass('hide');
        });
        $('.tab-activity').click(function () {
            $('.tab-opt').removeClass('active');
            $(this).addClass('active');
            $('.tab-contents').addClass('hide');
            $('.second-content').removeClass('hide');
        });
        $('.tab-rules').click(function () {
            $('.tab-opt').removeClass('active');
            $(this).addClass('active');
            $('.tab-contents').addClass('hide');
            $('.third-content').removeClass('hide');
        });

        $(function () {
            window.setInterval(getTimer,10);/!*设置不间断定时器执行getTimer函数*!/
            function getTimer() {
                var endtime=new Date("2018/05/26 08:00:00");  /!*定义结束时间*!/
                var nowtime=new Date();/!*获取当前时间*!/
                var cha=endtime.getTime()-nowtime.getTime();/!*得到它们相差的时间*!/
                var day=Math.floor(cha/1000/60/60/24); /!*划分出时分秒*!/
                var hour=Math.floor(cha/1000/60/60%24);
                var minute=Math.floor(cha/1000/60%60);
                var second=Math.floor(cha/1000%60);
                if (day <= 9) day = '0' + day;
                if (minute <= 9) minute = '0' + minute;
                if (second <= 9) second = '0' + second;
                if (hour <= 9) hour = '0' + hour;
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


        })


    </script>

@endsection
