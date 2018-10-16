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
        .footer_main{display: block}
    </style>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection
<div class="th-head"><div class="board-head"></div> </div>
<div class="th-content">
    <div class="head-con clearfix">
        <i class="img-icon new-icon"></i>
        <span>活动资讯</span>
        <a class="more hide" href="newsList.html">
            <div class="img-icon arrowr-icon"></div>
            <span>更多</span>
        </a>
    </div>
    <ul class="main-item">
        <li>
            <a class="a-content" href="https://mp.weixin.qq.com/s/gyf074B7lsuTFPPXLAMqww">
                <p class="new-title">交出来！你遇到过哪些好医生？我们送他C位出道！</p>
                <p class="new-subtitle">2018.08.25</p>
            </a>
        </li>
        <li>
            <a class="a-content" href="https://mp.weixin.qq.com/s?src=11&timestamp=1535335623&ver=1085&signature=57NsylnOTCZMcAUzaV1KJx0zXno23lE9ngoKhkUYT4Z6VF9s*R45F5H9hEY1PW2jUj-mMSclxw7wtLhdxanyts1UlXteyRTygXUGGV8kPt0z6ryBj1t*pu0IWZIw5DbC&new=1">
                <p class="new-title">选出你心中的十强好医生！评选活动今日正式开始~</p>
                <p class="new-subtitle">四川名医</p>
            </a>
        </li>
        <li>
            <a class="a-content" href="https://mp.weixin.qq.com/s?src=11&timestamp=1535336623&ver=1085&signature=57NsylnOTCZMcAUzaV1KJx0zXno23lE9ngoKhkUYT4aR17G1DwHbn3pSkSovflSC7S*iIcfLQOsE2-adhfLuE*ElHSxxoYqHyDFR0o-tBRpHNX*ywAl1Lh7oR1fyIK4H&new=1">
                <p class="new-title">汇聚1000余病种，满足95%患者寻医需求，这个神器就差你这一票了！</p>
                <p class="new-subtitle">四川名医</p>
            </a>
        </li>
    </ul>
</div>
<div class="block"></div>
<div class="th-content">
    <div class="head-con clearfix">
        <i class="img-icon doc-icon"></i>
        <span>医生推荐</span>
        <a class="more hide" href="newsList.html">
            <div class="img-icon arrowr-icon"></div>
            <span>更多</span>
        </a>
    </div>
    <ul class="main-item">
        <li>
            <a class="a-content" href="https://mp.weixin.qq.com/s?src=11&timestamp=1535334821&ver=1085&signature=57NsylnOTCZMcAUzaV1KJx0zXno23lE9ngoKhkUYT4bX*jZ1OYiLniRYD2QEwJuWHBSRJ2g4k7I1NGn30mi1Xv1CgdZwjbvKWLdp*xgj8X*qPBsRd90z8yuSBzOFN23M&new=1">
                <p class="new-title">70岁婆婆手写两封信，要感谢这位好医生！</p>
                <p class="new-subtitle">四川名医</p>
            </a>
        </li>
        <li>
            <a class="a-content" href="https://mp.weixin.qq.com/s?src=11&timestamp=1535334821&ver=1085&signature=57NsylnOTCZMcAUzaV1KJx0zXno23lE9ngoKhkUYT4bNhDBM1Hcpo7ngWVAmLGBpszFOjsr8Eo8gqLphfwKxmB4oyHLuZ7wTt3PqRb36Inknygc-WNYXZDggnfioOSbp&new=1">
                <p class="new-title">好医生投票活动火爆，妇产科男神有话说！</p>
                <p class="new-subtitle">四川名医</p>
            </a>
        </li>
        <li>
            <a class="a-content" href="https://mp.weixin.qq.com/s?src=11&timestamp=1535334705&ver=1085&signature=57NsylnOTCZMcAUzaV1KJx0zXno23lE9ngoKhkUYT4Zlmk8bjVZM6v1t82*X8Mcwi4JCLSWt58BIkp9qkCLvSOiyI1Ts7VgyRqGW*WdrCYPymhE6fpU9bTsfbGL91lPX&new=1">
                <p class="new-title">【金口碑十强好医生语音版】冬天穿得少，受了寒会得风湿？周京国告诉你真相！</p>
                <p class="new-subtitle">四川名医</p>
            </a>
        </li>
    </ul>
</div>
<div style="height: 50px"></div>
@section('content')

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



    </script>

@endsection
