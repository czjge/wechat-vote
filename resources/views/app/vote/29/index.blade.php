<!-- 2018好医生 -->
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
    <div class="mara-head"> <div class="act-rules"></div></div>

    <div class="mara-board">
        <div class="board-content">
            <div class="board-item">
                <div class="board-name">榜单成员</div>
                <div class="board-num">{{ $candidatesNum }}</div>
            </div>
            <div class="board-item">
                <div class="board-name">投票总数</div>
                <div class="board-num">{{ $votesNum }}</div>
            </div>
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
                            <img src="@if(''==$candidate->pic_url) {{ $qiniu_cdn_path }}/images/default_doc_avatar.jpg @elseif(false !== strpos($candidate->pic_url, 'https')) {{ $candidate->pic_url }} @else {{ $qiniu_cdn_path }}/storage/{{ $candidate->pic_url }} @endif"/>
                        </div>
                        <div class="votes-block">{{ $candidate->name }}<span>{{ $candidate->tit }}</span></div>
                        <div class="votes-block mrg-t0 clearfix">
                            <div class="votes-nums">{{ $candidate->num }}票</div>
                            <div class="votes-btn">给Ta投票</div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
        <div class="votes-page">
            <div class="page-btn prev {{ ($candidates->currentPage() == 1) ? ' forbid' : '' }}">
                <a @if($candidates->currentPage() != 1)href="{{ $candidates->appends(['keywords' => Input::get('keywords')])->url($candidates->currentPage()-1) }}&id={{ Input::get('id') }}"@endif>上一页</a>
            </div>
            <div class="page-num">{{ $candidates->currentPage() }}/{{ ceil($candidates->total()/config('home.pageNum')) }}</div>
            <div class="page-btn next {{ ($candidates->currentPage() == $candidates->lastPage()) ? ' forbid' : '' }}">
                <a @if($candidates->currentPage() != $candidates->lastPage())href="{{ $candidates->appends(['keywords' => Input::get('keywords')])->url($candidates->currentPage()+1) }}&id={{ Input::get('id') }}"@endif>下一页</a>
            </div>
        </div>

    </div>

    <div class="block"></div>
    <div class="mara-recommend"><img src="{{ $qiniu_cdn_path }}/images/vote/27/reco-bg.png"> </div>
    <div class="swiper-container mara-swipper"><!--swiper容器[可以随意更改该容器的样式-->
        <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/log?id=29&type=3&name=%E5%9B%9B%E5%B7%9D%E5%A4%A7%E5%AD%A6%E5%8D%8E%E8%A5%BF%E5%8C%BB%E9%99%A2"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos1.png"></a></div>
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/log?id=29&type=3&name=%E5%9B%9B%E5%B7%9D%E7%9C%81%E4%BA%BA%E6%B0%91%E5%8C%BB%E9%99%A2&from=singlemessage&isappinstalled=0"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos2.png"></a></div>
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/log?id=29&type=3&name=%E6%88%90%E9%83%BD%E4%B8%AD%E5%8C%BB%E8%8D%AF%E5%A4%A7%E5%AD%A6%E9%99%84%E5%B1%9E%E5%8C%BB%E9%99%A2"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos3.png"></a></div>
            {{--<div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/info/6284?id=27"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos4.jpg"></a></div>
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/log?id=27&type=3&name=%E6%88%90%E9%83%BD%E5%B7%9D%E8%9C%80%E8%A1%80%E7%AE%A1%E7%97%85%E5%8C%BB%E9%99%A2"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos5.jpg"></a></div>
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/log?id=27&type=3&name=%E6%88%90%E9%83%BD%E4%B8%AD%E7%A7%91%E7%94%B2%E7%8A%B6%E8%85%BA%E5%8C%BB%E9%99%A2"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos6.jpg"></a></div>
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/log?id=27&type=3&name=%E5%9B%9B%E5%B7%9D%E7%9C%81%E6%B3%8C%E5%B0%BF%E5%A4%96%E7%A7%91%E5%8C%BB%E9%99%A2"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos7.jpg"></a></div>

            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/info/6386?id=27"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos8.png"></a></div>
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/info/6342?id=27"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos9.png"></a></div>
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/info/6262?id=27"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos10.png"></a></div>
            <div class="swiper-slide"><a href="https://hys.scmingyi120.cn/vote/info/6392?id=27"><img src="{{ $qiniu_cdn_path }}/images/vote/27/hos11.png"></a></div> --}}
        </div><!--784开始不一样-->
        <div class="swiper-pagination" style="float: right"></div><!--分页器-->
        <!--<div class="swiper-button-prev"></div><!--前进按钮-->
        <!--<div class="swiper-button-next"></div><!--后退按钮-->
    </div>
    <p class="mara-support">主办单位: 成都商报</p>
    <p class="mara-support mrg-t1">承办单位: 成都商报四川名医</p>
    <p class="mara-support mrg-t1">指导单位: 四川省预防医学会</p>
    <div style="height:50px;"></div>
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

        var mySwiper = new Swiper(".swiper-container",{
            direction:"horizontal",
            loop:true,
            pagination:".swiper-pagination",
            //prevButton:".swiper-button-prev",/!*前进按钮*!/
            //nextButton:".swiper-button-next",/!*后退按钮*!/
            autoplay:3000
        });
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
        //活动规则
        $('.act-rules').click(function () {
            $('.act-rules-modal').removeClass('box_hide')
        });
        function closeRules() {
            $('.rule_box').addClass('box_hide');
        }

    </script>
@endsection