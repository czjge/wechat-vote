@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle3.css?v=2" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">
	<style>
		.rule_box .msg_box {
			min-height: 800px;
			overflow: scroll;
			height: 600px;
		}
		a.btn-bm {
			color: #433101;
			font-size: 36px;
			background: #ebb752;
			width: 540px;
			height: 80px;
			line-height: 80px;
			border-radius: 40px;
			position: absolute;
			bottom: 210px;
			left: 105px;
		}
		.margin--90 {
			margin-top: -70px;
		}
		.info_box p a {
			font-style: italic;
			font-size: 30px;
			color: #ebb752;
			/* width: 100%; */
			float: left;
			margin-left: 36px;
		}
        .ask-info {
            color: #ebb752;
            text-decoration: underline;
            position: absolute;
            top: 15px;
            right: 180px;
            z-index: 70;
            font-style: italic;
        }
        .swiper-pagination-bullet{
            background: #fff;
        }
        section.banner_section img{
            border: solid 10px #ebb752;
        }
        .margin--360{
            margin-top: -360px;
        }
        .margin--350{
            margin-top: -350px;
        }
        .tongji_box{
            bottom: 320px;
        }
        
        .position-r{position: relative}
        .mask-content{position: fixed;top: 0;left: 0; width:100%;height:100%;/*background: rgba(0,0,0,.75)*/;z-index: 99999999;background: url("{{ $qiniu_cdn_path }}/images/vote/15/bg.jpg") no-repeat;background-size: 100% 100%}
        .mask-header{width:100%;height: 44px;}
        .header-time{position: absolute;top:10px;right:30px;font-size: 24px;color: #f0b847;}
        .header-time span{padding-left: 6px;}
        .title-content{width:100%;text-align:center;font-family: "Arial","Microsoft YaHei","黑体","宋体",sans-serif;color: #f0b847;margin-top: 300px;font-size: 24px;letter-spacing: 1px}
        .logo-img{display: inline-block}
        .title-content span{vertical-align: 30%}
        .count-img{display: block;width:60%;margin: 40px auto}
        .count-item{width:150px;height: 150px;border: 4px solid #f0b847;border-radius: 50%;margin: 40px auto;text-align: center;line-height: 150px;}
        .count-item span{display: inline-block; font-size: 60px;font-family: Verdana;color: #f0b847;text-align: center;}
        .count-item small{font-size: 28px;padding-left: 2px}
        .title-img{display: inline-block; width:70%;}
	</style>
@endsection

@section('content')

    <section class="top_box clearfix">
        <img src="{{ $qiniu_cdn_path }}/images/vote/{{ $vote->id }}/index-banner-zz.jpg" width="100%">
        <a href="https://sojump.com/jq/15329453.aspx"><span class="ask-info">寻医问药行为万人大调查</span></a>
        <a href="#"><span class="shop_info box_hide">活动商城</span></a>
        <a href="javascript:void(0);"><span class="rule_info">活动规则</span></a>
        <div class="tongji_box clearfix">
            <ul class="clearfix">
                <li>
                    <p>榜单成员</p>
                    <p>{{ $candidatesNum }}</p>
                    <!--<p>???</p>-->
                </li>
                <li>
                    <p>点赞总数</p>
                    <p>{{ $votesNum?$votesNum:0 }}</p>
                    <!--<p>0</p>-->
                </li>
                <li>
                    <p>访问总数</p>
                    <p>{{ $vote->clicks }}</p>
                </li>
            </ul>
        </div>
        <p class="slogan_tips box_hide">现在，开启“品牌之路”</p>
        <a class="btn-bm box_hide" href="{{ route('home.vote.getRegister'.Input::get('id')) }}?id={{ Input::get('id') }}&type=0">征集通道</a>
    </section>

    <section class="time_box clearfix box_hide">
        投票时间：{{ date('Y年m月d日', strtotime($vote->start_time)) }}-{{ date('m月d日', strtotime($vote->end_time)) }}
    </section> 
    
    <section class="banner_section  margin--350">
        <a href="http://s2.rabbitpre.com/m/3rqUfERuB?lc=3&sui=dl3aK2IG" class="box_hide"><img src="{{ $qiniu_cdn_path }}/images/vote/15/banner2.jpg" class=""></a>
        <span class="tips" style="z-index:70;">今日福利</span>
        <div class="swiper-container"><!--swiper容器[可以随意更改该容器的样式-->  
            <div class="swiper-wrapper"> 
                <div class="swiper-slide"><a href="https://cms.scmingyi.com/jkbydbd/189.jhtml"><img src="{{ $qiniu_cdn_path }}/images/vote/15/banner9.jpg"></a></div>
                <div class="swiper-slide"><a href="<?php echo route('home.vote.getRank'.$id).'?id='.$id.'&type=4'; ?>"><img src="{{ $qiniu_cdn_path }}/images/vote/15/banner7_1.jpg"></a></div>
                <div class="swiper-slide"><a href="<?php echo route('home.vote.getRank'.$id).'?id='.$id.'&type=1'; ?>"><img src="{{ $qiniu_cdn_path }}/images/vote/15/banner8.jpg"></a></div>
                <div class="swiper-slide"><a href="<?php echo route('home.vote.getInfo'.$id,['cid'=>5161]).'?id='.$id.'&type=71'; ?>"><img src="{{ $qiniu_cdn_path }}/images/vote/15/banner6.jpg"></a></div>
                <div class="swiper-slide"><a href="<?php echo route('home.vote.getRank'.$id).'?id='.$id.'&type=15'; ?>"><img src="{{ $qiniu_cdn_path }}/images/vote/15/banner3_1.jpg"></a></div>
                <div class="swiper-slide"><a href="<?php echo route('home.vote.getRank'.$id).'?id='.$id.'&type=6'; ?>"><img src="{{ $qiniu_cdn_path }}/images/vote/15/banner4_1.jpg"></a></div>
                <div class="swiper-slide"><a href="<?php echo route('home.vote.getRank'.$id).'?id='.$id.'&type=14'; ?>"><img src="{{ $qiniu_cdn_path }}/images/vote/15/banner5_1.jpg"></a></div>
            </div><!--784开始不一样-->
            <div class="swiper-pagination" style="float: right"></div><!--分页器--> 
            <!--<div class="swiper-button-prev"></div><!--前进按钮-->  
            <!--<div class="swiper-button-next"></div><!--后退按钮-->  
        </div> 
    </section>

    <section class="tab_box box_hide">
        <div class="box_select box_hide">
            <a href="" class="">药企</a>
            <a href="" class="">药店</a>
            <a href="" class="">药品</a>
        </div>
    </section>
    <section class="select_section">
         <div class="box_select2 box_hide">
            <div class="box_select2_panel">
                <a href="" class=""></a>
            </div>
        </div>
        <section class="list_box clearfix show" id="doctor_list">
            <div id="list_box">
                @foreach($brands as $brand)
                <div class="list_item index_list_item">
                    <a href="<?php
//                        if (strtotime($vote->start_time) > time() || time() > strtotime($vote->end_time)) {
//                            echo 'javascript:void(0)';
//                        } else {
                            echo route('home.vote.getRank'.$id).'?id='.$id.'&type='.$brand->id;
//                        }
                    ?>">
                        <div class="head-img">
                            @if($brand->b_log)
                            <img src='{{ $qiniu_cdn_path }}/storage/log/{{ $brand->b_log }}?v=2'/>
                            @else
                            <img src='/images/vote/15/header.png'/>
                            @endif
                        </div>
                        <div class="title">
                            <p class="title-first">
                                <span class="xm">{{ $brand->name }}</span>
                            </p>                            
                        </div>
                        <div class="msg_box">
                            <label><span class="num">{{ $brand->num }}</span> 赞</label>
                            <label><span class="num">{{ $brand->yaodian }}</span> 家药店</label>
                            <div class="btn_box box_hide">
                                @if (strtotime($vote->start_time) > time())
                                    未开始
                                @elseif (time() > strtotime($vote->end_time))
                                    已结束
                                @else
                                    为TA点赞
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="pages clearfix">
                {!! $paginator->appends([
                    'id' => Input::get('id'),
                ])->render(new App\Extensions\boolawuiThreePresenter($paginator)) !!}
            </div>
        </section>
    </section>
    <section class="common_title clearfix  box_hide" id="prize">
        <div class="common_title_main clearfix">
            <i></i>
            <span>活动规则</span>
            <span></span>
        </div>
    </section>
    <section class="info_box clearfix">
        <div class="content_box_main clearfix">
            <p>发起单位<br>成都商报、成都商报四川名医</p>
            <p>注意：若有药店连锁企业批量上传资料，欢迎联系<span>cdsbscmy@sina.com</span>，或咨询热线<span><a href="tel:028-69982575">028-69982575（工作日） </a></span> <span><a href="tel:18583795519"> 18583795519</a></span></p>
        </div>
    </section>

    <div class="mask-content">
        <div class="mask-header position-r">
            <div class="header-time">跳过<span id="mes">3</span>秒</div>
        </div>
        <div class="title-content">
            <div class="logo-img"><img src="{{ $qiniu_cdn_path }}/images/vote/15/logo.png" width="80"></div>
            <div class="title-img"><img src="{{ $qiniu_cdn_path }}/images/vote/15/title.png" width="100%"></div>
        </div>
        <div class="count-content">
            <div class="count-img"><img src="{{ $qiniu_cdn_path }}/images/vote/15/countdown.png" width="100%"></div>
            <div class="count-item"></div>
        </div>
    </div>

    <div style="display: none;"><script src="https://s13.cnzz.com/z_stat.php?id=1263058209&web_id=1263058209" language="JavaScript"></script></div>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js?v=2" type="text/javascript"></script>
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

            var listType = '{{ \Illuminate\Support\Facades\Input::get('type') }}';
            $('.select_section .box_select').children().eq(listType == 0 ? 0 : (listType == 1?1:2)).addClass('active').siblings('a').removeClass('active');
            //$('.box_select2')[0].scrollLeft = $(".box_select2_panel .active")[0].offsetLeft - 30;
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
        
        var now = new Date();
        function GetServerTime()  //倒计时天数
        {
            var urodz = new Date("8/19/2017 00:00:00");//设定倒计时的时间
            now.setTime(now.getTime()+250);
            days = (urodz - now) / 1000 / 60 / 60 / 24;
            daysRound = Math.floor(days);
            hours = (urodz - now) / 1000 / 60 / 60 - (24 * daysRound);
            hoursRound = Math.floor(hours);
            minutes = (urodz - now) / 1000 /60 - (24 * 60 * daysRound) - (60 * hoursRound);
            minutesRound = Math.floor(minutes);
            seconds = (urodz - now) / 1000 - (24 * 60 * 60 * daysRound) - (60 * 60 * hoursRound) - (60 * minutesRound);
            secondsRound = Math.round(seconds);
            daysRound = daysRound;
            if(daysRound >= 0) {
                var html='';
                html+='<span id="days">'+ daysRound + '<small>天</small>' +'</span>';
                $('.count-item').html('').append(html)
            }
        }
        setInterval("GetServerTime()",1000);
        GetServerTime();
        var i = 3;
        var intervalid;
        intervalid = setInterval("fun()", 1000);
        function fun() {   //跳过3秒
            if (i == 0) {
                $('.mask-content').hide();
                clearInterval(intervalid);
            }
            $("#mes").html(i);
            i--;
        }

        $('.header-time').click(function () {
           $('.mask-content').hide();
        })
    </script>
@endsection
