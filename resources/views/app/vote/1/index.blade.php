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
    <style>
        .index_list_item .head-img{
            background: #ede7f3;
        }
        .list_item .title .xm{
            overflow: initial;
        }
        .box_select{
            margin-top: 30px;
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
        .vote_time,.vote-title,.tongji_box{
            z-index: 79;
        }
    </style>
@endsection

@section('content')
    <section class="top_box clearfix">
        <img src="{{ $qiniu_cdn_path }}/images/vote/1/index-bg.jpg" width="100%">
        <a href="javascript:void(0);"><span class="rule_info" style="z-index:70;">活动<br>规则</span></a>
        <p class="vote_time">9月25日~9月29日</p>
        <p class="vote-title">100&nbsp;&nbsp;/&nbsp;&nbsp;强&nbsp;&nbsp;/&nbsp;&nbsp;评&nbsp;&nbsp;/&nbsp;&nbsp;选&nbsp;&nbsp;/&nbsp;&nbsp;活&nbsp;&nbsp;/ &nbsp;&nbsp;动</p>
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
        
    </section>
    @if($type==0)
    <!--------------------------------------- 首页 -------------------------------------------->
    
    <section class="banner_section">
        <span class="tips" style="z-index:70;display: none;">今日推荐</span>
        <div class="banner-content">
            <!--<img src="{{ $qiniu_cdn_path }}/images/vote/16/banner15.jpg">-->
            
            <div class="swiper-container"><!--swiper容器[可以随意更改该容器的样式-->  
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><a href="https://cdsb.scmingyi.cn/vote/index?id=2&type=0"><img src="{{ $qiniu_cdn_path }}/images/vote/1/tuijian1.jpg"></a></div>  
                    <div class="swiper-slide"><a href="https://cdsb.scmingyi.cn/vote/index?id=2&type=1"><img src="{{ $qiniu_cdn_path }}/images/vote/1/tuijian2.jpg"></a></div>
                </div>
                <div class="swiper-pagination" style="float: right"></div><!--分页器--> 
                <!--<div class="swiper-button-prev"></div><!--前进按钮-->  
                <!--<div class="swiper-button-next"></div><!--后退按钮-->  
            </div>
        </div>
              
    </section>
    <section class="select_section">
        @if(\Illuminate\Support\Facades\Input::get('keywords'))
        <div class="box_search"><a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=0">取消搜索</a></div>
        
        <!--<div class="box_select box_hide">
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=0" class="active">家庭医生团队</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=1">社区卫生中心</a>
            <a href="{{ route('home.vote.getIndex'.$id) }}?id={{ $id }}&type=2">乡镇卫生院</a>
        </div>-->
        @endif
        <section class="list_box clearfix show" id="doctor_list">
            <img src="{{ $qiniu_cdn_path }}/images/vote/1/up-arrow.png" width="42px">
            <div id="list_box">
                @foreach($candidates as $candidate)
                <div class="list_item index_list_item">
                    <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$candidate->id]).'?id='.$id.'&type=0' }}">
                    <div class="head-img"><img src='<?php if($candidate->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$candidate->pic_url;}?>'/></div>
                        <div class="title">
                            <p class="title-first">
                                <span class="xm">{{ $candidate->name }}</span>
                                <span class="zc">{{ $candidate->title }}</span>
                            </p>                            
                        </div>
                        <div class="msg_box">
                            <label>
                                <span class="num">{{ $candidate->num }}</span>票
                            </label>

                            
                            @if($candidate->status==2)
                               
                            @else
                               <div class="btn_box">投Ta一票</div>
                            @endif
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

    <!-- 首页end -->
    @else
    <!--------------------------------------- 专家 -------------------------------------------->
    <section class="select_section3">
        <span class="tips" style="z-index:70;">专家评审团</span>
        <section class="phb_box clearfix" name ="0">
            <div class="phb_box_table mzy-phb clearfix">
                @foreach($candidates as $candidate)
                <div class="list_item">
                    <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$candidate->doctor_id]).'?id='.$id.'&type=1' }}">
                        <div class="head-img"><img src="<?php if($candidate->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$candidate->pic_url;}?>" /></div>
                        <div class="title">
                            <p class="title-first">
                                <span class="xm">{{ $candidate->doctor_name }}</span>
                                <span class="zc">{{ $candidate->doctor_title }}</span>
                            </p>

                        </div>
                        <div class="zj-yy">
                            {{ $candidate->hospital_name }}
                        </div> 
                        
                    </a>
                </div>
                @endforeach
            </div>
        </section>
        <p class="order-tips">以上均以姓名拼音为序</p>
    </section>
    
    <!-- 专家end -->
    @endif
    <section class="select_section_2 index_section" style="margin-top:0;">
        <p style="margin-top:0;">主办单位：成都商报、成都商报四川名医</p>
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
                autoplay:4000/*每隔3秒自动播放*/  
            })  
        });
    </script>
@endsection
