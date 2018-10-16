@extends('layouts.home')


<?php $footer = 'app.vote.'.$id.'.footer';?>
<?php $modal = 'app.vote.'.$id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle2.css?v=2" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css"> 
@endsection

@section('content')
    <section class="top_box clearfix">
        <img src="{{ $qiniu_cdn_path }}/images/vote/16/index-banner3.jpg?v=2" width="100%">
        <a href="javascript:void(0);"><span class="rule_info" style="z-index:70;">预签约规则</span></a>
        <div class="tongji_box clearfix">
            <ul class="clearfix">
                <li>
                    <p>榜单成员</p>
                    <p>{{ $candidatesNum }}</p>
					<!--<p>222</p>-->
                </li>
                <li>
                    <p>投票总数</p>
                    <p>{{ $votesNum }}</p>
					<!--<p>0</p>-->
                </li>
                <li>
                    <p>访问总数</p>
                    <p>{{ $vote->clicks }}</p>
                </li>
            </ul>
        </div>
        <a class="top_box_btn box_hide" href="https://mp.scmingyi.com/form/register?id=13">推荐上传资料</a>
    </section>
    <section class="banner_section">
        <img src="{{ $qiniu_cdn_path }}/images/vote/16/banner15.jpg">
        <span class="tips box_hide" style="z-index:70;">今日推荐</span>
        <div class="swiper-container box_hide"><!--swiper容器[可以随意更改该容器的样式-->  
            <div class="swiper-wrapper">
                <div class="swiper-slide"><a href="{{ route('home.vote.getInfo'.$id, ['cid'=>644]).'?id='.$id }}"><img src="{{ $qiniu_cdn_path }}/images/vote/16/banner4.jpg?v=4"></a></div>  
                <div class="swiper-slide"><a href="{{ route('home.vote.getInfo'.$id, ['cid'=>393]).'?id='.$id }}"><img src="{{ $qiniu_cdn_path }}/images/vote/16/banner12.jpg?v=4"></a></div>
                <div class="swiper-slide"><a href="{{ route('home.vote.getInfo'.$id, ['cid'=>693]).'?id='.$id }}"><img src="{{ $qiniu_cdn_path }}/images/vote/16/banner6.jpg?v=4"></a></div> 
                <div class="swiper-slide"><a href="{{ route('home.vote.getInfo'.$id, ['cid'=>441]).'?id='.$id }}"><img src="{{ $qiniu_cdn_path }}/images/vote/16/banner7.jpg?v=4"></a></div>
                <div class="swiper-slide"><a href="{{ route('home.vote.getInfo'.$id, ['cid'=>497]).'?id='.$id }}"><img src="{{ $qiniu_cdn_path }}/images/vote/16/banner8.jpg?v=4"></a></div>				
                <div class="swiper-slide"><a href="{{ route('home.vote.getInfo'.$id, ['cid'=>411]).'?id='.$id }}"><img src="{{ $qiniu_cdn_path }}/images/vote/16/banner9.jpg?v=4"></a></div>
                <div class="swiper-slide"><a href="{{ route('home.vote.getInfo'.$id, ['cid'=>399]).'?id='.$id }}"><img src="{{ $qiniu_cdn_path }}/images/vote/16/banner10.jpg?v=4"></a></div>
                <div class="swiper-slide"><a href="{{ route('home.vote.getInfo'.$id, ['cid'=>837]).'?id='.$id }}"><img src="{{ $qiniu_cdn_path }}/images/vote/16/banner11.jpg?v=4"></a></div>
            </div><!--784开始不一样-->
            <div class="swiper-pagination" style="float: right"></div><!--分页器--> 
            <!--<div class="swiper-button-prev"></div><!--前进按钮-->  
            <!--<div class="swiper-button-next"></div><!--后退按钮-->  
        </div> 
              
    </section>
    <section class="select_section">
        @if(\Illuminate\Support\Facades\Input::get('keywords'))
        <div class="box_search"><a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=0">取消搜索</a></div>
        @else
        <div class="box_select">
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=0" class="active">家庭医生团队</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=1">社区卫生中心</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=2">乡镇卫生院</a>
        </div>
        <div class="box_select2">
            <div class="box_select2_panel">
            @if($type==2)
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=6" class="<?php if($title==6){echo 'active';} ?>">高新区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=7" class="<?php if($title==7){echo 'active';} ?>">天府新区</a>
            @else
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=6" class="<?php if($title==6||$title<1){echo 'active';} ?>">高新区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=7" class="<?php if($title==7){echo 'active';} ?>">天府新区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=1" class="<?php if($title==1){echo 'active';} ?>">锦江区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=2" class="<?php if($title==2){echo 'active';} ?>">青羊区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=3" class="<?php if($title==3){echo 'active';} ?>">金牛区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=4" class="<?php if($title==4){echo 'active';} ?>">武侯区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=5" class="<?php if($title==5){echo 'active';} ?>">成华区</a>
            @endif
            
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=8" class="<?php if($title==8){echo 'active';} ?>">龙泉驿区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=9" class="<?php if($title==9){echo 'active';} ?>">青白江区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=10" class="<?php if($title==10){echo 'active';} ?>">新都区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=11" class="<?php if($title==11){echo 'active';} ?>">温江区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=12" class="<?php if($title==12){echo 'active';} ?>">双流区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=18" class="<?php if($title==18){echo 'active';} ?>">郫都区</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=22" class="<?php if($title==22){echo 'active';} ?>">简阳市</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=13" class="<?php if($title==13){echo 'active';} ?>">都江堰市</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=14" class="<?php if($title==14){echo 'active';} ?>">彭州市</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=15" class="<?php if($title==15){echo 'active';} ?>">邛崃市</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=16" class="<?php if($title==16){echo 'active';} ?>">崇州市</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=17" class="<?php if($title==17){echo 'active';} ?>">金堂县</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=21" class="<?php if($title==21){echo 'active';} ?>">新津县</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=19" class="<?php if($title==19){echo 'active';} ?>">大邑县</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type={{$type}}&title=20" class="<?php if($title==20){echo 'active';} ?>">蒲江县</a>
            </div>
        </div>
        @endif
        <section class="list_box clearfix show" id="doctor_list">
            <div id="list_box">
                @if(count($candidates) == 0)
                <p class="list_box_none" style="margin-left: -13px;">暂无数据</p>
                @else
                @foreach($candidates as $candidate)
                <div class="list_item index_list_item">
                    <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$candidate->id]).'?id='.$id }}">
                    <div class="head-img"><img src='{{ $qiniu_cdn_path }}/storage/{{ $candidate->pic_url }}?v=2'/></div>
                        <div class="title">
                            <p class="title-first">
                                @if(($candidate->type)>0)
                                <span class="xm">{{ $candidate->of_hospital }}</span>
                                @else
                                <span class="xm">{{ $candidate->of_dep }}</span>
                                @endif
                            </p>                            
                        </div>
                        <div class="msg_box">
                            <label>
                                <span class="num">
                                    @if(($candidate->num)>=100000)
                                    <?php echo number_format(($candidate->num)/10000, 1); ?>万
                                    @else
                                    {{ $candidate->num }}
                                    @endif
                                </span>票
                            </label>

                            <div class="btn_box">
                                @if (strtotime($vote->start_time) > time())
                                    未开始
                                @elseif (time() > strtotime($vote->end_time))
                                    @if($candidate->rank!=2)
                                        预签约
                                    @else
                                        已结束
                                    @endif
                                @else
                                    投票及预签约
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                @endif
            </div>
            <div class="pages clearfix box_hide">
                {!! $paginator->appends([
                    'id' => \Illuminate\Support\Facades\Input::get('id'),
                    'keywords' => \Illuminate\Support\Facades\Input::get('keywords'),
                    'type' => \Illuminate\Support\Facades\Input::get('type'),
                    'rank' =>\Illuminate\Support\Facades\Input::get('rank'),
                    'title'=>\Illuminate\Support\Facades\Input::get('rank'),
                ])->render(new App\Extensions\boolawuiThreePresenter($paginator)) !!}
            </div>
        </section>
    </section>
    <section class="select_section_2 index_section" style="margin-top:0;">
        
        <div class="info_content box_hide">
            <div class="text_title">
                    支持单位
            </div>
            <div class="content_box">
                <img src="{{ $qiniu_cdn_path }}/images/vote/16/info-logo.jpg" width="100%">
            </div>
        </div>
        <p style="margin-top:0;">主办单位：成都市卫生和计划生育委员<br>协办单位：成都商报四川名医</p>


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

            var listType = '{{ \Illuminate\Support\Facades\Input::get('type') }}';
            $('.select_section .box_select').children().eq(listType == 0 ? 0 : (listType == 1?1:2)).addClass('active').siblings('a').removeClass('active');
            $('.box_select2')[0].scrollLeft = $(".box_select2_panel .active")[0].offsetLeft - 30;
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
