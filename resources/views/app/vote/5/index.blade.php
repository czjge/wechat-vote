@extends('layouts.home')


<?php $footer = 'app.vote.'.$id.'.footer';?>
<?php $modal = 'app.vote.'.$id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle2.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    {{--<link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">--}}
    <style>
        .list_item .title .xm{
            overflow: initial;
        }
        .mzy-phb .list_item{
            height: 110px;
        }
        .mzy-phb .list_item .head-img{
            width: 90px;
            height: 90px;
            /*border: solid 1px #e0d0b7;*/
            left: 0px;
            background: #ede7f3;
        }
        .mzy-phb .list_item .title {
            left: 95px;
        }
        
        .mzy-phb .list_item .title p span{
            color: #896a39;
            max-width: 200px;
        }
        .mzy-phb .list_item .title .xm {
            font-size: 30px;
            margin-right: 15px;
            margin-left: 10px;
            font-weight: bold;
        }
        .mzy-phb .list_item .title .title-first {
            display: flex;
            line-height: 110px;
            margin-top: 0;
        }
        .phb_box{
            margin-top: 30px;
        }
        .zj-yy{
            font-size: 26px;
            max-width: 290px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: absolute;
            right: 0;
            line-height: 110px;
            color: #896a39;
        }
        .order-tips{
            color: #896a39;
            font-size: 24px;
            margin-top: -20px;
        }
        .tongji_box{
            
        }
        .list_box {
            padding-bottom: 5px;
        }
        .top30{
            margin-top:30px;
        }
        .pages li span{
            background: #5eb0a0;
        }
    </style>
@endsection

@section('content')

    <section class="top_box clearfix">
        <img src="{{ $qiniu_cdn_path }}/images/vote/5/index-bg.jpg" width="100%">
        <a href="javascript:void(0);"><span class="rule_info" style="z-index:70;">活动<br>规则</span></a>
        <div class="tongji_box clearfix">
            <ul class="clearfix">
                <li>
                    <p>榜单成员</p>
                    <p>{{ $candidatesNum }}</p>
                </li>
                <li>
                    <p>投票总数</p>
                    <p>{{ $votesNum }}</p>
                </li>
                <li>
                    <p>访问总数</p>
                    <p>{{ $vote->clicks }}</p>
                </li>
            </ul>
        </div>
    </section>

    <section class="select_section">
       
        <div class="box_search box_hide"><a href="#">取消搜索</a></div>
        <div class="box_select">
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=0" @if(Input::get('type')==='0')class="active"@endif >儿科西医榜</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=1" @if(Input::get('type')==1)class="active"@endif >儿科中医榜</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=2" @if(Input::get('type')==2)class="active"@endif >评审专家</a>
        </div>
        <section class="list_box clearfix show" id="">
            <div id="list_box">
                
                @for ($i = 0; $i < ceil(count($candidates)/2); $i++)
                <div class="list_box_bg">

                    <div class="list_item index_list_item list-item-right <?php if($candidates[$i*2]->type==2){echo 'top30';}?>">
                        <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$candidates[$i*2]->id]) }}?id={{ $id }}">
                            <div class="head-img"><img src="<?php if($candidates[$i*2]->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$candidates[$i*2]->pic_url;}?>"/></div>
                            <div class="title">
                                <p class="title-first">
                                    <span class="xm">{{ $candidates[$i*2]->name }}</span>
                                    <span class="zc">{{ $candidates[$i*2]->title }}</span>
                                </p>
                            </div>
                            <div class="msg_box <?php if($candidates[$i*2]->type==2){echo 'box_hide';}?>">
                                <label>
                                    <span class="num">{{ $candidates[$i*2]->num }}</span>票
                                </label>
                                <div class="btn_box">给Ta投票</div>
                            </div>
                        </a>
                    </div>

                    @if(count($candidates)%2==1&&$i==(ceil(count($candidates)/2)-1))

                    @else
                        <div class="list_item index_list_item list-item-left <?php if($candidates[$i*2+1]->type==2){echo 'top30';}?>">
                            <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$candidates[$i*2+1]->id]) }}?id={{ $id }}">
                                <div class="head-img"><img src="<?php if($candidates[$i*2+1]->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$candidates[$i*2+1]->pic_url;}?>"/></div>
                                <div class="title">
                                    <p class="title-first">
                                        <span class="xm">{{ $candidates[$i*2+1]->name }}</span>
                                        <span class="zc">{{ $candidates[$i*2+1]->title }}</span>
                                    </p>
                                </div>
                                <div class="msg_box <?php if($candidates[$i*2+1]->type==2){echo 'box_hide';}?>">
                                    <label>
                                        <span class="num">{{ $candidates[$i*2+1]->num }}</span>票
                                    </label>
                                    <div class="btn_box">给Ta投票</div>
                                </div>
                            </a>
                        </div>
                    @endif

                </div>
                @endfor

            </div>
        </section>
    </section>

    <section class="select_section">
        <div class="pages clearfix">
            {!! $paginator->appends([
                'keywords' => Input::get('keywords'),
                'id' => Input::get('id'),
                'type' => Input::get('type'),
            ])->render(new App\Extensions\boolawuiThreePresenter($paginator)) !!}
        </div>
    </section>

    <section class="banner_section">
        <span class="tips">今日推荐</span>
        <div class="banner-content">
            <div class="swiper-container"><!--swiper容器[可以随意更改该容器的样式-->
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/health/circle/detail.do?circleId=17"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg8.jpg"></a></div>
                    <div class="swiper-slide"><a href="http://yym.zhongsou.com/Cloudshare/index?keyword=&srpId=&url=http%253A%252F%252Fydy.zhongsou.com%252FWebApi%252Fcustom_detail%253FmongoId%253D5a5dff0cb385242d4a55dbf0-11&token=e85c7f8c-37b2-4d0b-873c-f5a736aef671&pfAppName=com.chengdushangbao"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg6.jpg"></a></div>
                    <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=49"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg2.jpg"></a></div>
                    <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=53"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg7.jpg"></a></div> 
                    <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=50"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg3.jpg"></a></div>
                    <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=51"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg4.jpg"></a></div>
                    <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/healthcard/projectDetail.do?projectId=52"><img src="{{ $qiniu_cdn_path }}/images/vote/5/gg5.jpg"></a></div>
                </div>
                <div class="swiper-pagination" style="float: right"></div><!--分页器--> 
                <!--<div class="swiper-button-prev"></div><!--前进按钮-->  
                <!--<div class="swiper-button-next"></div><!--后退按钮-->  
            </div>
        </div>
    </section>
    <section class="zzs_section box_hide">
        <img src="{{ $qiniu_cdn_path }}/images/vote/5/gg1.png">
    </section>
    <section class="select_section_2 index_section" style="margin-top:0;">
        <p>主办单位：成都商报社、成都商报四川名医<br>指导单位：四川省中医药学会儿科专委会、成都中医药学会(中医儿科专业委员会)</p>
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

            //var listType = '{{ Input::get('type') }}';
            //$('.select_section .box_select').children().eq(listType == 0 ? 0 : (listType == 1?1:2)).addClass('active').siblings('a').removeClass('active');

            //$('.box_select2')[0].scrollLeft = $(".box_select2_panel .active")[0].offsetLeft - 30;
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
            {{--$('.register-btn').on('click', function () {--}}
                {{--window.location.href = "{{ route('home.vote.getRegister'.$id) }}?id={{ Input::get('id') }}";--}}
            {{--});--}}

            //banner图滚动效果
            var mySwiper = new Swiper(".swiper-container",{  
                direction:"horizontal",/*横向滑动*/  
                loop:true,/*形成环路（即：可以从最后一张图跳转到第一张图*/  
                pagination:".swiper-pagination",/*分页器*/  
                //prevButton:".swiper-button-prev",/*前进按钮*/  
                //nextButton:".swiper-button-next",/*后退按钮*/  
                autoplay:4000/*每隔3秒自动播放*/  
            })  
        });
    </script>
@endsection
