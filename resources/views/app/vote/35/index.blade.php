<!-- 消防员 -->
@extends('layouts.home')


<?php $footer = 'app.vote.'.$id.'.footer';?>
<?php $modal = 'app.vote.'.$id.'.modal';?>

@section('selfmeta')
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
    <style>
        .modal-box-main{height: 465px;margin-top: 60px;}
        .count-num{ margin-bottom: .2rem;}
        .yanzhengcode{
            position: fixed;
            z-index: 999;
            width: 600px;
            border: 10px solid #e2e2e2;
            left: 70px;
            top: 50%;
            margin-top: -150px;
            box-shadow: 10px 0px 40px 0px rgba(0,0,0,0.5);
            background: #fff;
        }
        .yanzhengcode img{
            width: 300px;
            margin-left: 10px;
            padding: 0;
            margin-top: 40px;
            margin-bottom: 15px;
        }
        .yanzhengcode input{
            width: 500px;
            height: 80px;
            margin-bottom: 15px;
            margin-top: 20px;
            font-size: 32px;
        }
        .yanzhengcode input:last-child {
            margin-bottom: 40px;
            background: #EFAD2D;
            color: #fff;
            border-radius: 40px;
        }
    </style>
@endsection

@section('content')
    <div class="banner"></div>
    <div class="mara-board">
        <div class="board-content">
            <div class="board-item">
                <div class="board-name">榜单总数</div>
                <div class="board-num">{{ $candidatesNum }}</div>
            </div>
            <i class="board-line"></i>
            <div class="board-item">
                <div class="board-name">点赞总数</div>
                <div class="board-num">{{ $votesNum }}</div>
            </div>
            <i class="board-line"></i>
            <div class="board-item">
                <div class="board-name">浏览总数</div>
                <div class="board-num">{{ $vote->clicks }}</div>
            </div>
        </div>
    </div>
    <div class="votes-content">

        @foreach($candidates as $key => $candidate)
        <div class="votes-item">
            <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $candidate->id]) }}?id={{ Input::get('id') }}">
                <div class="votes-avatar">
                    <img src="@if(''==$candidate->pic_url) {{ $qiniu_cdn_path }}/images/default_doc_avatar.jpg @elseif(false !== strpos($candidate->pic_url, 'https')) {{ $candidate->pic_url }} @else {{ $qiniu_cdn_path }}/storage/{{ $candidate->pic_url }} @endif"/>
                </div>
                <div class="votes-name">{{ $candidate->name }}</div>
                <div class="votes-depart ellipsis">{{ $candidate->address }}</div>
            </a>
            <div class="votes-bot clearfix">
                <div class="votes-num ellipsis"><span>{{ $candidate->num }}票</span></div>
                <div class="votes-btn" data-url="">给Ta点赞</div>
            </div>
        </div>
        @endforeach

    </div>
    <div class="votes-page">
        <div class="page-btn prev {{ ($candidates->currentPage() == 1) ? ' forbid' : '' }}">
            <a @if($candidates->currentPage() != 1)href="{{ $candidates->appends(['keywords' => Input::get('keywords')])->url($candidates->currentPage()-1) }}&id={{ Input::get('id') }}"@endif>上一页</a>
        </div>
        <div class="page-num">{{ $candidates->currentPage() }}/{{ ceil($candidates->total()/config('home.pageNum')) }}</div>
        <div class="page-btn next {{ ($candidates->currentPage() == $candidates->lastPage() || $candidates->lastPage() == 0) ? ' forbid' : '' }}">
            <a @if($candidates->currentPage() != $candidates->lastPage() && $candidates->lastPage() != 0)href="{{ $candidates->appends(['keywords' => Input::get('keywords')])->url($candidates->currentPage()+1) }}&id={{ Input::get('id') }}"@endif>下一页</a>
        </div>
    </div>
    <div class="mara-subsupport"><strong>活动地点</strong>：预选-全省各消防大队、支队</br><span>总决赛-成都</span></div>
    <div class="mara-subsupport mrg"><strong>主办单位</strong>：四川省消防总队</div>
    <div style="height: .5rem"></div>
    <div class="act-btn"></div>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.jquery.min.js" type="text/javascript"></script>
    <script type="application/javascript">
        $(function () {
            var submintVoteStatus = 0;
            var captchaShowStatus = 0;
            $('.votes-btn').click(function () {
                var thisBtn = $(this);
                var ajaxVoteUrl = $(this).data('url');

                if ('{{ $vote->captcha_status }}' == 1 && captchaShowStatus == 0) {
                    $('.yanzhengcode').css('display', 'block');
                    captchaShowStatus = 1;
                    return false;
                }

                if(submintVoteStatus == 1){
                    return false;
                }

                if('{{ $subscribe }}' !== '1'){
                    showShareGuide();
                    return false;
                }

                if ('{{ $vote->captcha_status }}' == 1) {
                    if ($('#captcha_code').val() == '') {
                        tusi("请输入验证码");return;
                    }
                    ajaxVoteUrl = ajaxVoteUrl + "&captcha_code="+$('#captcha_code').val();
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "GET",
                    url: ajaxVoteUrl,
                    dataType : "json",
                    data: "",
                    beforeSend: function () {
                        loading('请稍后');
                        submintVoteStatus = 1;
                    },
                    complete: function () {
                        loading(false);
                        submintVoteStatus = 0;
                    },
                    success: function(data){
                        if (data.code == 200) {
                            afterCheckCaptcha();
                            thisBtn.prev().find('span').text(data.vote_num);
                            tusi(data.msg);
                        } else if (data.code == 209) {
                            afterCheckCaptcha();
                            $('.footer_nav_gz a').click();
                        } else if (data.code == 210) {
                            afterCheckCaptcha();
                            tusi("请再试一次");
                            setTimeout(function(){
                                window.location.href = '{{ $reloadUrl }}';
                            },1888);
                        } else if (data.code == 211) {
                            $('#captcha_code').val('');
                            tusi(data.msg);
                        } else if (data.code == 202) {
                            afterCheckCaptcha();
                            tusi(data.msg);
                        }else {
                            afterCheckCaptcha();
                            tusi(data.msg);
                        }
                    }
                });


            });

            function afterCheckCaptcha () {
                if ('{{ $vote->captcha_status }}' == 1) {
                    $('#captcha_img').attr('src', '{{ route("base.getCaptcha") }}?'+Math.random());
                    $('.yanzhengcode').css('display', 'none');
                    captchaShowStatus = 0;
                    $('#captcha_code').val('');
                }
            }

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

        });
    </script>
    <script>
        $(function () {
            //window.setInterval(getTimer,10);/!*设置不间断定时器执行getTimer函数*!/
            function getTimer() {
                {{--{{ $vote->start_time }}--}}
                var d = '{{ $vote->start_time }}';
                var s = d.replace(/-/g, "/");
                var endtime=new Date(s);  /!*定义结束时间*!/
                var nowtime=new Date();/!*获取当前时间*!/
                var cha=endtime.getTime()-nowtime.getTime();/!*得到它们相差的时间*!/
                var day=Math.floor(cha/1000/60/60/24); /!*划分出时分秒*!/
                var hour=Math.floor(cha/1000/60/60%24);
                var minute=Math.floor(cha/1000/60%60);
                var second=Math.floor(cha/1000%60);
                if (day <= 9 && day >=0) day = '0' + day;
                if (minute <= 9 && minute >=0) minute = '0' + minute;
                if (second <= 9 && second >=0) second = '0' + second;
                if (hour <= 9 && hour>=0) hour = '0' + hour;
                if (nowtime >= endtime){
                    $('.count-content').hide();
                }
                var sday = day.toString().split('',2);
                var shour = hour.toString().split('',2);
                var smin = minute.toString().split('',2);
                var secs = second.toString().split('',2);
                $('.day1').text(sday[0]);
                $('.day2').text(sday[1]);
                $('.hour1').text(shour[0]);
                $('.hour2').text(shour[1]);
                $('.min1').text(smin[0]);
                $('.min2').text(smin[1]);
                $('.sec1').text(secs[0]);
                $('.sec2').text(secs[1]);


            }


        });
        /*var mySwiper = new Swiper(".swiper-container",{
            direction:"horizontal",/!*横向滑动*!/
            loop:true,/!*形成环路（即：可以从最后一张图跳转到第一张图*!/
            pagination:".swiper-pagination",/!*分页器*!/
            //prevButton:".swiper-button-prev",/!*前进按钮*!/
            //nextButton:".swiper-button-next",/!*后退按钮*!/
            autoplay:4000/!*每隔3秒自动播放*!/
        });*/
        // 搜索
        $('.footer-search').click(function () {
            $(window).scrollTop(0);
            $(".search_box").removeClass('box_hide');
        });
        $('.search_box').click(function () {
            $(".search_box").addClass('box_hide');
        })
        $('.search_box_main').click(function () {
            event.stopPropagation(); //阻止事件冒泡
        });

        $('.act-btn').click(function () {
            $('.report_box').removeClass('box_hide')
        })
        function closeRules() {
            $('.report_box').addClass('box_hide');
        }
        // 关注二维码
        var shareGuideFlag = 1;
        function showShareGuide(){
            if (shareGuideFlag == 1) {
                return;
            }
            $('body').append('<div id="share_guide_box" onclick="hideShareGuide();" style="position:fixed;z-index:80;left:0px;top:0px;width:100%;height:100%;background-color: rgba(0,0,0,0.8);text-align:right;" ontouchmove="return true;" ><img src="'+imagespath+'/vote/34/yf-code.jpg" width="100%"></div>');
            shareGuideFlag = 1;
        }
        function hideShareGuide(){
            $("#share_guide_box").remove();
            shareGuideFlag = 0;
        }
        //点赞
        $('.zan-i').click(function () {
            console.log('zan')
        })
    </script>
@endsection