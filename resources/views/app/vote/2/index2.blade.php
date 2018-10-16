@extends('layouts.home')


<?php $footer = 'app.vote.'.$id.'.footer';?>
<?php $modal = 'app.vote.'.$id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css?v=3" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle2.css?v=3" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css"> 
    <style>
        .specialist-list{
            width: 100%;
        }
        p.name-order {
            text-align: right;
            margin-right: 30px;
            margin-bottom: 10px;
            color: #896a39;
            font-size: 24px;
        }
        .index_section {
            color: #896a39;
        }
        .select_section_2 {
            background: transparent;
        }
        .rank-img{
            position: relative;
        }
        .rank-img img{
            position: absolute;
        }
        .rank-name.font-s26.rank-name-ks{
            max-width: 160px;
            text-align: left;
        }
        .rank-name.font-s26.rank-name-yy{
            max-width: 250px;
        }

		.top-tab{padding:0;overflow: auto;}
        .top-tab-scroll{overflow: scroll;width: 1000px; padding: 0 30px;}
        .tab-con{width:100%;}
        .top-tab-con{width: 200px;}
    </style>
@endsection

@section('content')

    <section class="top_box clearfix">
        <img src="{{ $qiniu_cdn_path }}/images/vote/2/index-banner2.jpg?v=2" width="100%">
        <div class="top-tab">
            <div class="top-tab-scroll">
            <a class="top-tab-con box_hide" href="index?id=2&type=4">
                <div class="tab-con">
                    <span class="top-circle"></span><span class="top-text">十强榜</span><span class="top-circle"></span>
                </div>
            </a>
            <a class="top-tab-con" href="index?id=2&type=3">
                <div class="tab-con">
                    <span class="top-circle"></span><span class="top-text">百强榜</span><span class="top-circle"></span>
                </div>
            </a>
            <a class="top-tab-con" href="index?id=2&type=0">
                <div class="tab-con">
                    <span class="top-circle"></span><span class="top-text">院级榜单</span><span class="top-circle"></span>
                </div>
            </a>
            <a class="top-tab-con" href="index?id=2&type=1">
                <div class="tab-con">
                    <span class="top-circle"></span><span class="top-text">专科专病榜</span><span class="top-circle"></span>
                </div>
            </a>
			
            <a class="top-tab-con" href="index?id=2&type=2">
                <div class="tab-con active">
                    <span class="top-circle"></span><span class="top-text">专家评审团</span><span class="top-circle"></span>
                </div>
            </a>
			</div>
        </div>
        <a class="top-search position-r footer_nav_search" href="javascript:void(0);"><i class="top-search-icon search-icon"></i> <input type="text" class="top-search-input" placeholder="搜索专家" disabled></a>
        <p class="name-order box_hide">按姓氏排列</p>
    </section>

    <div>
    <section class="banner_section">
        <div class="section-content">
            <ul class="list-block specialist-list">

                @foreach ($retval as $item)
                    <li class="specialist-item clear">
                        <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$item->doctor_id]).'?id='.$id.'&type=2' }}" class="clear">
                            <div class="left-sec-con wid-auto">
                                <div class="rank-img wid-small"><img src="<?php if($item->doctor_avatar==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$item->doctor_avatar;}?>" ></div>
                            </div>
                            <div class="left-sec-con wid-auto mrg-t20">
                                <span class="rank-name">{{ $item->doctor_name }}</span><span class="rank-name rank-name-ks font-s26">{{ $item->doctor_title }}</span>
                            </div>
                            <div class="right-sec-con mrg-t24">
                                <span class="rank-name rank-name-yy font-s26">{{ $item->hospital_name }}</span>
                            </div>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
    </section>
    </div>

    <section class="select_section box_hide">
        <section class="list_box clearfix" id="doctor_list">
            <div id="list_box">
            </div>
            <div class="pages clearfix">

            </div>
        </section>
    </section>

    <section class="select_section_2 index_section">
        <p style="margin-top:0;">以上均以姓名拼音为序</p>
    </section>

    <section class="search_box clearfix box_hide">
        <div class="search_box_main clearfix">
            <div class="form_box">
                <form action="{{ route('home.vote.getIndex'.Input::get('id')) }}" id="search_form" method="get">
                    <table width="100%">
                        <tr>
                            <input type="hidden" name="id" value="{{ Input::get('id') }}"/>
                            <input type="hidden" name="type" value="{{ Input::get('type') }}"/>
                            <td width=""><input class="input_class" type="text" name="keywords" placeholder="请输入…"/></td>
                            <td width="140">
                                <input class="a_class id_search_btn" type="submit" value="搜索">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="msg_box"></div>
        </div>
        <div class="close_box search_close_box"></div>
    </section>

@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
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
            $('.top-tab-con').click(function () {
                $('.top-tab-con').find('.tab-con').removeClass('active');
                $(this).find('.tab-con').addClass('active');
                var index = $(this).index();
                $("div > .banner_section").eq(index).show().siblings().hide();//与li序列相同的ul显示，其他的ul隐藏
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

            /*$(document).on('click','.select_section_2 .box_select a', function(event) {
                var name = this.dataset.name;
                var box = $(".content_box[name="+name+"]");
                $(this).addClass('active').siblings('a').removeClass('active');
                $(box).show().siblings('.content_box').hide();
            });*/

            var listType = '{{ \Illuminate\Support\Facades\Input::get('type') }}';
            $('.select_section .box_select').children().eq(listType == 0 ? 0 : (listType == 1?1:2)).addClass('active').siblings('a').removeClass('active');
            $('.top-tab')[0].scrollLeft = $(".top-tab-scroll .active")[0].offsetLeft-30;
          //var mainContainer = $('.box_select2'),
          //scrollToContainer = mainContainer.find('.active');//滚动到<div id="thisMainPanel">中类名为son-panel的最后一个div处
          //scrollToContainer = mainContainer.find('.son-panel:eq(5)');//滚动到<div id="thisMainPanel">中类名为son-panel的第六个处
          //非动画效果
          //mainContainer.scrollLeft(
          //  scrollToContainer.offset().left - mainContainer.offset().left + mainContainer.scrollLeft()
         // );
          //动画效果
         // mainContainer.animate({
          //  scrollLeft: scrollToContainer.offset().left - mainContainer.offset().left + mainContainer.scrollLeft()
         // }, 1000);//2秒滑动到指定位置
        
            
            // in IOS, we cannot bind document event on none a markup.
            $('.register-btn').on('click', function () {
                window.location.href = "{{ route('home.vote.getRegister'.$id) }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}";
            });

            //banner图滚动效果
            var mySwiper = new Swiper(".swiper-container",{  
                direction:"horizontal",/*横向滑动*/  
                loop:true,/*形成环路（即：可以从最后一张图跳转到第一张图*/  
                pagination:".swiper-pagination",/*分页器*/  
                //prevButton:".swiper-button-prev",/*前进按钮*/  
                //nextButton:".swiper-button-next",/*后退按钮*/  
                autoplay:3000/*每隔3秒自动播放*/  
            })  
        });
    </script>
@endsection
