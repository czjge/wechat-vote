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
    <section class="top_box clearfix">
        <img src="{{ $qiniu_cdn_path }}/images/vote/index-banner.jpg" width="100%">
		<div class="count_down">
            活动开始还有<span id="t_d"></span>天 <span id="t_h"></span>小时 <span id="t_m"></span>分钟
        </div>
        <div class="tongji_box clearfix">
            <ul class="clearfix">
                <li>
                    <p>榜单成员</p>
                    <!--<p>{{ $candidatesNum }}</p>-->
					<p>???</p>
                </li>
                <li>
                    <p>投票总数</p>
                    <!--<p>{{ $votesNum }}</p>-->
					<p>0</p>
                </li>
                <li>
                    <p>访问总数</p>
                    <p>{{ $vote->clicks }}</p>
                </li>
            </ul>
        </div>
    </section>
    

    <!-- <section class="index_nav clearfix" style="height: 215px;text-align: left;">
        <div class="index_nav_btns clearfix"><b style="color: #ff0000">提示：</b>目前发现有个别候选人在投票过程中疑似刷票行为，主办方已关注此事并正在进行核查，现已锁定有关候选人的投票通道。为保证评选工作的公平、公开、公正，我们将严查刷票行为，一旦发现票数异常增长，系统将立即锁定该候选人投票通道！</div>
    </section> -->

    <!-- <section class="index_nav clearfix">
        <div class="index_nav_btns clearfix">
            <a href="{{ route('home.vote.getRank') }}?id={{ $vote->id }}">排行榜</a>
            <a href="#prize">活动背景</a>
            {{--<a href="#rule">投票规则</a>--}}
            <a href="{{ route('home.vote.getRegister') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}">我要报名</a>
        </div>
    </section> -->

    <!-- <section class="index_search_box clearfix">
        <div class="index_search_box_main clearfix">
            <div class="form_box">
                <form action="" id="search_form2" method="get">
                    <table width="100%">
                        <tr>
                            <input type="hidden" name="id" value="{{ \Illuminate\Support\Facades\Input::get('id') }}"/>
                            <td width=""><input class="input_class" type="text" name="keywords" value="{{ \Illuminate\Support\Facades\Input::get('keywords') }}" placeholder="请输入姓名搜索"/></td>
                            <td width="140">
                                <input class="a_class id_search_btn2" type="submit" value="搜索">
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </section> -->

    <!-- <section class="time_box clearfix">
        <div class="time_box_main clearfix">
            <span>投票时间：2016年9月13日-27日</span>
            <label>按姓氏排序</label>
        </div>
    </section> -->

    <section class="select_section">
        <div class="box_select">
            <!--<a href="{{ route('home.vote.getIndex') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=0" class="active">个人</a>
            <a href="{{ route('home.vote.getIndex') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=1">团队</a>-->
            <a href="{{ route('home.vote.getIndex') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=0" class="active">个人</a>
            <a href="{{ route('home.vote.getIndex') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=1">团队</a>
            <a href="{{ route('home.vote.getIndex') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=2">企业</a>
        </div>
        <section class="list_box clearfix show" id="doctor_list">
            <div id="list_box">
                @foreach($candidates as $candidate)
                <div class="list_item index_list_item">
                    <!--<a href="{{ route('home.vote.getInfo', ['cid'=>$candidate->id]) }}?id={{ $candidate->vote_id }}">-->
                        <!--<div class="head-img"><img src='<?php echo $candidate->pic_url ? (strpos($candidate->pic_url, 'http')===false ? $qiniu_cdn_path.'/storage/'.$candidate->pic_url : $candidate->pic_url) : $qiniu_cdn_path.'/images/vote/header.jpg';?>'/></div>-->
                        <div class="head-img"><img src='/images/vote/header.jpg'/></div>
                        <!--<div class="title">
                            <p class="title-first">
                                <span class="xm">{{ $candidate->name }}</span>
                                <span>{{ empty($candidate->title) ? "" : $candidate->title }}</span>
                                @if($candidate->status==2)<span class="sd">锁定中</span>@endif
                            </p>
                            <p>
                                <span>{{ empty($candidate->title) ? $candidate->rank : "" }}</span>
                                <span>{{ empty($candidate->of_hospital) ? $candidate->address : $candidate->of_hospital }}</span>
                            </p>
                        </div>
                        <div class="msg_box">
                            <label><span class="num">{{ $candidate->num }}</span> 票</label>
                            <div class="btn_box">投TA一票</div>
                        </div>
                        -->
                        <div class="title">
                            <p class="title-first">
                                <span class="xm">???</span>
                                <span>????</span>
                            </p>                            
                        </div>
                        <div class="msg_box">
                            <label><span class="num">0</span> 票</label>
                            <div class="btn_box">投TA一票</div>
                        </div>
                    <!--</a>-->
                </div>
                @endforeach
            </div>
            <div class="pages clearfix">
                {!! $paginator->appends([
                    'id' => \Illuminate\Support\Facades\Input::get('id'),
                    'keywords' => \Illuminate\Support\Facades\Input::get('keywords'),
                    'type' => \Illuminate\Support\Facades\Input::get('type'),
                ])->render(new App\Extensions\boolawuiThreePresenter($paginator)) !!}
            </div>
        </section>
    </section>

    <section class="select_section_2 index_section">
        <!--<div class="box_select">
            <a class="active"  data-name="0">活动背景</a>
            <a data-name="1">活动规则</a>
        </div>-->
        
        <div class="info_content">
            <img src="{{ $qiniu_cdn_path }}/images/vote/info-top.png">
            <div class="text_title">
                    活动<br>背景
            </div>
            <div class="content_box">
                <p class="text_content">
                    在中国营养界，有一群人一直在为“健康中国人”而努力，他们来自全国各个医院的临床营养科，是营养界的“学术领军人“，他们运用临床经验指导适用于不同人群的营养指南，促进国民健康水平的提升。
                </p>
                <p class="text_content">
                    为推动中国大营养事业的发展，中国老年医学学会与中国医药卫生文化学会将共同举办“首届中国营养风云榜”活动。这是一场营养的大行动，更是一场中国营养界发展的大事纪。通过首届中国营养风云榜的活动，全面展示全国各医院的营养科，提高临床营养学科在学术界的地位，增强学会的行业凝聚力，展示营养研发企业的实力，并向大众普及营养健康知识，提升全民的健康素养。
                </p>
            </div>
            <div class="text_title">
                    活动<br>规则
            </div>
            <div class="content_box" >
                <p class="text_content">1、每个微信ID每天在“中国老年医学学会营养与食品安全分会”和“成都商报四川名医”微信公众号上<span style="color:#ff0000;">分别有5票投票权限</span>，但这5票不能重复投给1名医生（团队/企业），需分散投给5名医生（团队/企业）。</p>
                <p class="text_content">2、两个平台分别会显示该平台收到的投票数量，候选人<span style="color:#ff0000;">最终的票数为两个平台投票数的总和</span>。</p>
                <p class="text_content">3、为最大限度保证评选公正，此次投票严禁刷票，一经发现，票数清零。</p>
                <p class="text_content">4、活动时间：{{ date('Y年m月d日', strtotime($vote->start_time)) }}~{{ date('m月d日', strtotime($vote->end_time)) }}</p>
            </div>
            <div class="text_title">
                    关于<br>活动
            </div>
            <div class="content_box">
                <p class="text_content">主办单位：中国老年医学学会</p>
                <p class="text_content text_content_indent">中国医药卫生文化协会</p>
                <p class="text_content">承办单位：中国老年医学学会营养与食品安全分会</p>
                <p class="text_content">执行单位：成都商报四川名医</p>
            </div>
            <img src="{{ $qiniu_cdn_path }}/images/vote/info-bottom.png">
        </div>

    </section>
    
    <!--<section class="footer_info">
        <div class="main_btn register-btn">我要推荐</div>
        <p>投诉通道：huangliqin@scmingyi.com</p>
    </section>-->

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

            $(document).on('click','.select_section_2 .box_select a', function(event) {
                var name = this.dataset.name;
                var box = $(".content_box[name="+name+"]");
                $(this).addClass('active').siblings('a').removeClass('active');
                $(box).show().siblings('.content_box').hide();
            });

            var listType = '{{ \Illuminate\Support\Facades\Input::get('type') }}';
            $('.select_section .box_select').children().eq(listType == 0 ? 0 : (listType == 1?1:2)).addClass('active').siblings('a').removeClass('active');

            // in IOS, we cannot bind document event on none a markup.
            $('.register-btn').on('click', function () {
                window.location.href = "{{ route('home.vote.getRegister') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}";
            });

            // var resizeImg =function(){
            //     var img_arr = $(".head-img img");
            //     for (var i in img_arr){
            //         $(img_arr[i]).removeAttr("width");
            //         $(img_arr[i]).removeAttr("height");
            //         var img_w = img_arr[i].width;
            //         var img_h = img_arr[i].height;
            //         console.log(img_w,img_h);
            //         if(img_w>img_h){
            //             $(img_arr[i]).css({
            //                 width: 'auto',
            //                 height: '100%'
            //             });
            //         }
            //     }
            // }
            // resizeImg();

            function getQueryString(name) {
                var reg = new RegExp('(^|&)' + name + '=([^&]*)(&|$)', 'i');
                var r = window.location.search.substr(1).match(reg);
                if (r != null) {
                    return unescape(r[2]);
                }
                return null;
            }
            if(getQueryString("type")==1 || getQueryString("type")==null){
                var img_arr = $(".head-img img");
                for (var i in img_arr){
                    $(img_arr[i]).css({
                        width: '100%',
                        height: '100%'
                    });
                }
            }

            setInterval(GetRTime, 1000);
        });
    </script>
@endsection
