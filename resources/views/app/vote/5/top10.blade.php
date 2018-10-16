@extends('layouts.home')

<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

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
            margin-top: 20px;
        }
        .box_select{
            margin-top: 30px;
        }
        .mzy-phb .list_item .head-img{
            left: 110px;
        }
        .mzy-phb .list_item .title {
                left: 195px;
                width: 340px;
                color: #38675e;
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
            float: left;
            color: #5eb0a0;
            width: 89px;
            height: 89px;
            background: #fff;
            border: dashed;
            border-radius: 10px;
        }
        .left-sec-con.wid-auto {
            
            min-width: 60px;
        }
        .rank-num {
            display: block;
            font-size: 36px;
            line-height: 0px;
            margin-top: 15px;
            line-height: 30px;
            font-style: italic;
        }
        .rank-top {
            font-size: 26px;
            font-style: italic;
            margin-top: -15px;
        }
        mzy-phb .list_item:nth-child(1) .left-sec-con, .mzy-phb .list_item:nth-child(2) .left-sec-con,.mzy-phb .list_item:nth-child(3) .left-sec-con {
            /*background-image: linear-gradient(45deg, #f3385a, #fd9808);
            color: #ff386f;*/
        }
        .box_select{
            width:450px;
        }
        .box_select a{
            width: 50%;
        }
        .phb_box_table{
            margin-bottom: 20px;
        }
    </style>
@endsection

@section('content')
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/5/top10.jpg" width="100%"></section>
    
    <section class="select_section">
        <div class="box_select">
            <a href="{{ route('home.vote.getRank'.$id) }}?id={{ $id }}&type=2" @if(Input::get('type')==2)class="active"@endif >西医TOP10</a>
            <a href="{{ route('home.vote.getRank'.$id) }}?id={{ $id }}&type=3" @if(Input::get('type')==3)class="active"@endif >中医TOP10</a>
        </div>
        <section class="phb_box clearfix">
            <div class="phb_box_table mzy-phb clearfix">

                    @foreach($rankList as $key => $item)
                    <div class="list_item">
                        <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$item->id]) }}?id={{ $id }}<?php if(Input::get('type')==2||Input::get('type')==3){echo "&show=1";}?>">
                            <div class="left-sec-con wid-auto">
                                <span class="rank-num">10</span>
                                <span class="rank-top">top</span>
                            </div>
                             <div class="head-img"><img src='<?php if($item->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$item->pic_url;}?>'/></div>
                            <div class="title">
                                <p class="title-first">
                                    <span class="xm">{{ $item->name }}</span>
                                    <span class="yy">{{ $item->title }}</span>
                                </p>
                            </div>
                            <div class="ps box_hide">
                                <span class="num">{{ $item->num }}</span> 票
                            </div>
                        </a>
                    </div>
                    @endforeach


            </div>
        </section>
        <p style="color:#fff; font-size:26px;">以上均以姓名拼音为序</p>
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
