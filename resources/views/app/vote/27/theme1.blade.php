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
            <a class="a-content" href="https://mp.weixin.qq.com/s?__biz=MzAwNzI3ODg5NQ==&mid=2653328495&idx=3&sn=1c38a5f153ee1b5a5da1873e5e5b1deb&chksm=80d2ac2fb7a525396cc3ceaf56c97063555d6298899ed8257b974987751b8b3addad81bc431a&token=627092018&lang=zh_CN#rd">
                <p class="new-title">下一个“名医大V ”诞生在你手中！第六届金口碑好医生投票启动</p>
                <p class="new-subtitle">2018年8月30日</p>
            </a>
        </li>
        <li>
            <a class="a-content" href="https://mp.weixin.qq.com/s?__biz=MzAwNzI3ODg5NQ==&mid=2653328541&idx=3&sn=5a0cd8723d113f034554bb8ac611f65c&chksm=80d2acddb7a525cbb09a7e850328599a47d851d6722c88c1f670dc11790b6b47323366502fa7&token=627092018&lang=zh_CN#rd">
                <p class="new-title">全城13万人次关注这件事！这份口碑打造的就医攻略，集合全成都的好医生~</p>
                <p class="new-subtitle">2018年9月1日</p>
            </a>
        </li>
        <li>
            <a class="a-content" href="https://mp.weixin.qq.com/s?__biz=MzAwNzI3ODg5NQ==&mid=2653328675&idx=2&sn=c2ad6971b44683e9eb2c2184bdaac1fd&chksm=80d2ad63b7a52475559c075e7483051adee7338ad888378895b739d45f55b954b146d1f207cf&token=627092018&lang=zh_CN#rd">
                <p class="new-title">“全川健康教育医生联盟”来了！320位医生，做你的健康智囊</p>
                <p class="new-subtitle">2018年9月7日</p>
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
