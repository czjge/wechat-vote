@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle2.css?v=2" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">
    <style>
        body{
            background: #f9f5ef;
        }
        .box_select{
            margin-top: 30px;
        }
        .mzy-phb .list_item .head-img{
            left: 85px;
            border: solid 1px #e0d0b7;
            background: #ede7f3;
        }
        .mzy-phb .list_item .title {
            left: 170px;
            width: 340px;
        }
        .list_item .title .xm {
            font-size: 28px;
            margin-right: 15px;
            margin-left: 10px;
            font-weight: bold;
            overflow: initial;
        }
        .list_item .title p span{
            color: #896a39;
        }
        .mzy-phb .list_item .title .title-first {
            display: flex;
            line-height: 92px;
            margin-top: 0;
        }
        .mzy-phb .list_item .ps {
            width: 160px;
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
        .mzy-phb .list_item:nth-child(1) .pm, .mzy-phb .list_item:nth-child(2) .pm,.mzy-phb .list_item:nth-child(3) .pm {
            background: #cd121e;
        }
    </style>
@endsection

@section('content')
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/3/rank-banner2.jpg" width="100%"></section>
    
    <section class="select_section">
        <!--<div class="box_select">
            <a class="<?php if($type==0){ echo "active";} ?>"  href="{{ route('home.vote.getRank'.$vote->id) }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=0">家庭医生团队</a>
            <a class="<?php if($type==1){ echo "active";} ?>"  href="{{ route('home.vote.getRank'.$vote->id) }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=1">社区卫生中心</a>
            <a class="<?php if($type==2){ echo "active";} ?>"  href="{{ route('home.vote.getRank'.$vote->id) }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=2">乡镇卫生院</a>
        </div>-->
        <section class="phb_box clearfix" name ="0">
            <div class="phb_box_table mzy-phb clearfix">
                @foreach($rankList as $key => $item)
                <div class="list_item">
                    <a href="{{ $item->url }}">
                        <div class="pm">{{ $key+1 }}</div>
                        <div class="head-img"><img src='<?php echo $item->pic_url ? 'http://qiniu.langzoo.com'. $item->pic_url : $qiniu_cdn_path.'/images/default_doc_avatar.jpg';?>?v=1'/></div>
                         <!--<div class="head-img"><img src='/images/vote/header.jpg'/></div>-->
                        <div class="title">
                            <p class="title-first">
                                <span class="xm">{{ $item->name }}</span>
                                <span class="zc">{{ $item->title }}</span>
                            </p>

                            <!--<p class="title-first"><span class="xm">???</span></p>-->
                            <!--<p><span class="yy">{{ $item->of_hospital }}</span></p>-->
                        </div>
                        <div class="ps">
                            @if($item->status==2)
                                <span class="sd"></span>
                            @else
                                <span class="num">{{ $item->num }}</span> 票
                            @endif
                        </div>
                        <!--<div class="ps"><span class="num">0</span> 票</div>-->
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
