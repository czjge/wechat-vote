@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle2.css" rel="stylesheet" type="text/css">
    {{--<link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">--}}
    <style>
        .phb_box{
            margin-top: -200px;
        }
        .box_select{
            margin-top: 30px;
        }
        .mzy-phb .list_item .head-img{
            left: 80px;
            background: #ede7f3;
        }
        .mzy-phb .list_item .title {
            left: 160px;
            width: 345px;
        }
        .list_item .title .xm {
            font-size: 28px;
            margin-right: 15px;
            margin-left: 10px;
            font-weight: bold;
            overflow: initial;
        }
        .mzy-phb .list_item .title .title-first {
            display: flex;
            line-height: 92px;
            margin-top: 0;
        }
        .mzy-phb .list_item .ps {
            width: 170px;
            right: 0px;
            font-weight: normal;
        }
        .mzy-phb .list_item .ps .num {
            padding-right: 0px;
        }
        .mzy-phb .list_item .pm{
            font-size: 28px;
            padding: 5px 12px;
        }
        .left-sec-con {
            width: 220px;
            height: auto;
            float: left;
            color: #999;
        }
        .left-sec-con.wid-auto {
            width: auto;
            min-width: 60px;
        }
        .rank-num {
            display: block;
            font-size: 46px;
            font-style: italic; 
            margin-top: 7px;
        }
        .rank-top {
            display: block;
            font-size: 26px;
            font-style: italic;
            margin-top: -15px;
        }
        .mzy-phb .list_item:nth-child(1) .left-sec-con, .mzy-phb .list_item:nth-child(2) .left-sec-con,.mzy-phb .list_item:nth-child(3) .left-sec-con {
            /*background-image: linear-gradient(45deg, #f3385a, #fd9808);*/
            color: #f44d55;
        }
    </style>
@endsection

@section('content')
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/4/rank-banner.jpg" width="100%"></section>
    
    <section class="select_section">
        <section class="phb_box clearfix">
            <div class="phb_box_table mzy-phb clearfix">
                @foreach ($rankList as $key => $item)
                    <div class="list_item">
                        <a href="{{ route('home.vote.getInfo'.$vote->id, ['cid'=>$item->id]) . '?id=' . $vote->id }}">
                            <div class="left-sec-con wid-auto">
                                <span class="rank-num"><?php if($key<9){echo '0';}?>{{ $key+1 }}</span>
                                <span class="rank-top">top</span>
                            </div>
                             <div class="head-img"><img src='{{ $qiniu_cdn_path }}/images/vote/{{ $vote->id }}/cover/index/{{ $item->no }}.jpg'/></div>
                            <div class="title">
                                <p class="title-first">
                                    <span class="xm">{{ $item->name }}</span>
                                    <span class="yy">{{ $item->of_dep }}</span>
                                </p>
                            </div>
                            <div class="ps">
                                <span class="num">{{ $item->num }}</span> 票
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    </section>
   
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
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
