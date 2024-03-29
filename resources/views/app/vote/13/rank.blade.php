@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/rank-banner.jpg" width="100%"></section>
    
    <section class="select_section">
        <div class="box_select">
            <a class="active"  data-name="0">个人</a>
            <a class=""  data-name="1">团队</a>
            <a class=""  data-name="2">企业</a>
        </div>
        <section class="phb_box clearfix" name ="0">
            <div class="phb_box_table mzy-phb clearfix">
                @foreach($rankList['doc'] as $key => $item)
                <div class="list_item">
                    <!--<a href="{{ $item->url }}">-->
                        <div class="pm">{{ $key+1 }}</div>
                        <!--<div class="head-img"><img <?php if($item->type==1){echo 'style="height: 100%;"';}?> src='<?php echo $item->pic_url ? (strpos($item->pic_url, 'http')===false ? $qiniu_cdn_path.'/storage/'.$item->pic_url : $item->pic_url) : $qiniu_cdn_path.'/images/default_doc_avatar.jpg';?>'/></div>-->
                         <div class="head-img"><img src='/images/vote/header.jpg'/></div>
                        <div class="title">
                            <!--<p class="title-first"><span class="xm">{{ $item->name }}</span>@if($item->status==2)<span class="sd">锁定中</span>@endif</p>-->
                            <p class="title-first"><span class="xm">???</span></p>
                            <!--<p><span class="yy">{{ $item->of_hospital }}</span></p>-->
                        </div>
                        <!--<div class="ps"><span class="num">{{ $item->num }}</span> 票</div>-->
                        <div class="ps"><span class="num">0</span> 票</div>
                    <!--</a>-->
                </div>
                @endforeach
            </div>
        </section>
        <section class="phb_box clearfix" style="display: none;"  name ="1">
            <div class="phb_box_table mzy-phb clearfix">
                @foreach($rankList['hos'] as $key => $item)
                <div class="list_item">
                    {{--<a href="{{ $item->url }}">--}}
                        <div class="pm">{{ $key+1 }}</div>
                        <div class="head-img"><img src='/images/vote/header.jpg'/></div>
                        <div class="title">
                            {{--<p class="title-first"><span class="xm">{{ $item->name }}</span>@if($item->status==2)<span class="sd">锁定中</span>@endif</p>--}}
                            {{--<p><span class="yy">{{ $item->rank }}</span></p>--}}
                            <p class="title-first"><span class="xm">???</span></p>
                        </div>
                        <div class="ps"><span class="num">{{ $item->num }}</span> 票</div>
                    {{--</a>--}}
                </div>
                @endforeach
            </div>
        </section>
    </section>

    <div style="display: none;"><script src="https://s95.cnzz.com/z_stat.php?id=1261112422&web_id=1261112422" language="JavaScript"></script></div>
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
                    desc: '{{ $shareInfo['shareDesc'] }}', // 分享描述
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
            $(document).on('click','.select_section .box_select a', function(event) {
                var name = this.dataset.name;
                var box = $(".phb_box[name="+name+"]");
                $(this).addClass('active').siblings('a').removeClass('active');
                $(box).show().siblings('.phb_box').hide();
            });
        });
    </script>
@endsection
