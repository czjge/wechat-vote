<!-- 大美医者 -->
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
    <div class="mara-head"> <div class="act-rule"></div></div>
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
        
        <!-- captcha -->
        @if($vote->captcha_status == 1)
            <div class="yanzhengcode" style="display: none;">
                <img src="{{ route('base.getCaptcha') }}" onclick="javascript:this.src='{{ route('base.getCaptcha') }}?'+Math.random()" id="captcha_img"/>
                <input type="text" name="captcha_code" id="captcha_code" placeholder="请输入验证码"/>
                <input type="button" value="确定" id="captcha_code_btn"/>
            </div>
        @endif
        
        @foreach($candidates as $key => $candidate)
        <div class="votes-item">
            <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $candidate->id]) }}?id={{ Input::get('id') }}">
                <div class="votes-avatar">
                    <img src="<?php if($candidate->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo $qiniu_cdn_path.'/storage/'.$candidate->pic_url;}?>"/>
                </div>
               <div class="votes-name">{{ $candidate->name }}</div>
               <div class="votes-depart">{{ $candidate->hospital }}</div>
               <div class="votes-num">已有<span>{{ $candidate->num }}</span>票</div>
            </a>
            <div class="votes-btn" data-url="{{ $candidate->ajax_vote_url }}">给Ta点赞</div>

        </div>
        @endforeach

    </div>
    <div class="support-info">
        <span class="color-red">- 主办单位 -</span>
        <span>中共成都市委宣传部</span>
        <span>成都市精神文明建设办公室</span>
        <span>成都市卫生和计划生育委员会</span>
    </div>
    <div style="height: .5rem"></div>

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
                            thisBtn.prev().find('.votes-num span').text(data.vote_num);
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

        // 搜索
        $(document).on('click', '.footer-search', function () {
            $(window).scrollTop(0);
            $(".search_box").removeClass('box_hide');
        });
        $(document).on('click', '.search_box', function () {
            $(".search_box").addClass('box_hide');
        });
        $(document).on('click', '.search_box_main', function (event) {
            event.stopPropagation(); //阻止事件冒泡
        });
        $('.act-rule').click(function () {
            $('.rule_box').removeClass('box_hide');
        });
        $('.close_box').click(function () {
            $('.rule_box').addClass('box_hide');
        });

        // 关注二维码
        var shareGuideFlag = 0;
        function showShareGuide(){
            if (shareGuideFlag == 1) {
                return;
            }
            $('body').append('<div id="share_guide_box" onclick="hideShareGuide();" style="position:fixed;z-index:999;left:0px;top:0px;width:100%;height:100%;background-color: rgba(0,0,0,0.8);text-align:right;" ontouchmove="return true;" ><img src="'+imagespath+'/jkcd_qrcode.jpg" width="100%"></div>');
            shareGuideFlag = 1;
        }
        function hideShareGuide(){
            $("#share_guide_box").remove();
            shareGuideFlag = 0;
        }

    </script>
@endsection