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
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="mara-head">
        <div class="mara-rules"></div>
    </div>
    <div class="mara-board">
        <div class="board-logo"></div>
        <div class="board-content">

            <div class="board-item">
                <div class="board-name">榜单总数</div>
                <div class="board-num">{{ $candidatesNum }}</div>
            </div>
            <i class="board-line"></i>
            <div class="board-item">
                <div class="board-name">投票总数</div>
                <div class="board-num">{{ $votesNum }}</div>
            </div>
            <i class="board-line"></i>
            <div class="board-item">
                <div class="board-name">浏览总数</div>
                <div class="board-num">{{ $vote->clicks }}</div>
            </div>

        </div>
    </div>
    <div class="mara-votes">
        <div class="votes-content">

            @foreach($candidates as $key => $candidate)

                    <div class="votes-item">
                        <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $candidate->id]) }}?id={{ Input::get('id') }}">
                            <div class="votes-avatar">
                                <img src="<?php if($candidate->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo $qiniu_cdn_path.'/storage/'.$candidate->pic_url;}?>">
                            </div>
                            <div class="votes-name">{{ $candidate->name }}</div>
                            <div class="votes-num">{{ $candidate->num }}票</div>
                            <div class="votes-btn"><i class="icon-kid"></i> 给Ta投票</div>
                        </a>
                    </div>

            @endforeach

        </div>
        <div class="votes-page">
            <div class="page-btn prev {{ ($candidates->currentPage() == 1) ? ' forbid' : '' }}">
                <a @if($candidates->currentPage() != 1)href="{{ $candidates->url($candidates->currentPage()-1) }}&id={{ Input::get('id') }}"@endif>上一页</a>
            </div>
            <div class="page-num">{{ $candidates->currentPage() }}/{{ ceil($candidates->total()/config('home.pageNum')) }}</div>
            <div class="page-btn next {{ ($candidates->currentPage() == $candidates->lastPage()) ? ' forbid' : '' }}">
                <a @if($candidates->currentPage() != $candidates->lastPage())href="{{ $candidates->url($candidates->currentPage()+1) }}&id={{ Input::get('id') }}"@endif>下一页</a>
            </div>
        </div>
    </div>
    <div class="mara-recommend"><img src="{{ $qiniu_cdn_path }}/images/vote/17/logo-recommen.png"> </div>
    <div class="swiper-container mara-swipper"><!--swiper容器[可以随意更改该容器的样式-->
        <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="https://red.cdsbscmy.com/index.php/Enroll/WEnroll/index.html?id=4"><img src="{{ $qiniu_cdn_path }}/images/vote/17/ad2.png"></a></div>
            <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/health/circle/detail.do?circleId=17"><img src="{{ $qiniu_cdn_path }}/images/vote/17/ad3.jpg"></a></div>
        </div><!--784开始不一样-->
        <div class="swiper-pagination" style="float: right"></div><!--分页器-->
        <!--<div class="swiper-button-prev"></div><!--前进按钮-->
        <!--<div class="swiper-button-next"></div><!--后退按钮-->
    </div>
    <p class="mara-support">主办单位：成都商报社、成都商报四川名医</p>
    <div class="mara-reg"></div>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.jquery.min.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
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
        var mySwiper = new Swiper(".swiper-container",{
            direction:"horizontal",/*横向滑动*/
            loop:true,/*形成环路（即：可以从最后一张图跳转到第一张图*/
            pagination:".swiper-pagination",/*分页器*/
            //prevButton:".swiper-button-prev",/*前进按钮*/
            //nextButton:".swiper-button-next",/*后退按钮*/
            autoplay:4000/*每隔3秒自动播放*/
        });

        $('.mara-rules').click(function () {
            $('.rule_box').removeClass('box_hide');
        });

        
        $('.mara-rules').click(function () {
            $('.rule_box').removeClass('box_hide');
        })


        function closeRules() {
            $('.rule_box').addClass('box_hide');
        }

        $('.mara-reg').click(function () {
            window.location.href = '{{ route("home.vote.getRegister" . Input::get('id')) }}?id={{ Input::get('id') }}';
        });

    </script>
@endsection