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
        .time{
            font-size: 26px;
            color: 
        }
        .mzy-phb .list_item .head-img{
            border: solid 1px #e0d0b7;
            left: 0px;
            background: #ede7f3;
        }
        .mzy-phb .list_item .title {
            left: 80px;
            width: 340px;
        }
        .list_item .title .xm {
            font-size: 28px;
            margin-right: 15px;
            margin-left: 10px;
            overflow: initial;
        }
        .list_item .title p span{
            color: #896a39;
            max-width: 220px;
        }
        .mzy-phb .list_item .title .title-first {
            display: flex;
            line-height: 92px;
            margin-top: 0;
        }
        .mzy-phb .list_item .ps {
            width: 160px;
            right: 210px;
            font-weight: normal;
            font-size: 26px;
           /* color: #896a39;*/
        }
        .time{
            font-size: 22px;
            color: #896a39;
            line-height: 92px;
            right: 0;
            position: absolute;
        }
    </style>
@endsection

@section('content')
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/1/log-banner2.jpg" width="100%"></section>
    
    <section class="select_section">
        <section class="phb_box clearfix" name ="0">
            <div class="phb_box_table mzy-phb clearfix">
                @foreach($logLists as $logList)
                <div class="list_item">
                    <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$logList->doctor_id]).'?id='.$id.'&type=0' }}">
                        <div class="head-img"><img src="<?php if($logList->doctor_avatar==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$logList->doctor_avatar;}?>" /></div>
                        <div class="title">
                            <p class="title-first">
                                <span class="xm">{{ $logList->doctor_name }}</span>
                                <span class="zc">{{ $logList->doctor_title }}</span>
                            </p>

                        </div>
                        <div class="ps">
                            投票成功
                        </div>
                        <div class="time">{{ date('Y-m-d H:i',$logList->times) }}</div>
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
