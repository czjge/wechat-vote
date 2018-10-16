<!-- 糖友征文 -->
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
@endsection

@section('content')
    <div class="mara-head"> </div>
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
    <div class="mara-votes">
        <div class="votes-content">
            @foreach($candidates as $key => $candidate)
                <div class="votes-item">
                    <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $candidate->id]) }}?id={{ Input::get('id') }}">
                        <div class="votes-avatar">
                            {{--<div class="sub-name two-ellipsis">你涨工资了吗？13地发布2018年企业工资指导线</div>
                            <div class="art-info three-ellipsis">中新经纬客户端9月6日电(王永乐) 说起涨工资，今年你调了吗？截至目前，至少已有13个省份发布了2018年企业工资指导线，为企业给员工涨工资提供了参考依据。</div>
--}}
                            <div class="sub-name two-ellipsis">{{ $candidate->article_title }}</div>
                            <div class="art-info three-ellipsis">{{ $candidate->article_content_start }}</div>
                            <div class="votes-name ellipsis">作者：{{ $candidate->name }}</div>
                        </div>
                        <div class="votes-num">已有<span>{{ $candidate->num }}</span>票</div>
                    </a>
                    <div class="votes-btn" data-url="{{ $candidate->ajax_vote_url }}">给Ta点赞</div>
                </div>
            @endforeach
        </div>
        <div class="votes-page">
            <div class="page-btn prev {{ ($candidates->currentPage() == 1) ? ' forbid' : '' }}">
                <a @if($candidates->currentPage() != 1)href="{{ $candidates->url($candidates->currentPage()-1) }}&id={{ Input::get('id') }}"@endif>上一页</a>
            </div>
            <div class="page-num">{{ $candidates->currentPage() }}/{{ ceil($candidates->total()/config('home.pageNum')) }}</div>
            <div class="page-btn next {{ ($candidates->currentPage() == $candidates->lastPage()) ? ' forbid' : '' }}">
                <a @if($candidates->currentPage() != $candidates->lastPage())href="{{ $candidates->url($candidates->currentPage()+1) }}&id={{ Input::get('id') }}"@endif>下一页</a>
            </div>
        </div>
    </div>
    <div class="mara-recommend"><img src="{{ $qiniu_cdn_path }}/images/vote/19/logo.png"> </div>
    <div class="swiper-container mara-swipper"><!--swiper容器[可以随意更改该容器的样式-->
        <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="https://yi.scmingyi.com/scmy_web/health/circle/detail.do?circleId=17"><img src="{{ $qiniu_cdn_path }}/images/vote/18/point-invite.png"></a></div>
        </div><!--784开始不一样-->
        <div class="swiper-pagination" style="float: right"></div><!--分页器-->
        <!--<div class="swiper-button-prev"></div><!--前进按钮-->
        <!--<div class="swiper-button-next"></div><!--后退按钮-->
    </div>
    <p class="mara-support">主办单位：成都商报四川名医</p>
    <div class="diabetes-rule"><span>活动<br>规则</span></div>
    <div class="phone-mask">
        <div class="phone-con">
            <div class="ph-content">
                <p>请输入您的抽奖手机号码</p>
                <input type="number" class="ph-input">
                <div class="ph-btn">确定</div>
            </div>
        </div>
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
            function doVote(e) {

                if(submintVoteStatus == 1){
                    return false;
                }

                if('{{ $subscribe }}' !== '1'){
                    //$('.footer_nav_gz a').click(); return false;
                    showShareGuide();
                    return false;
                }

                var thisBtn = $(e);
                var ajaxVoteUrl = $(e).data('url');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('home.vote.postDoSthByType' . Input::get('id')) }}?id={{ Input::get('id') }}",
                    dataType : "json",
                    data: {type: 4, id: '{{ Input::get('id') }}'},
                    beforeSend: function () {
                        loading('请稍后');
                        submintVoteStatus = 1;
                    },
                    complete: function () {
                        loading(false);
                        submintVoteStatus = 0;
                    },
                    success: function(data){
                        if (! data) {
                            $(e).attr('id', 'vote');
                            $('.phone-mask').show();
                            return false;
                        }

                        if ('{{ $vote->captcha_status }}' == 1 && captchaShowStatus == 0) {
                            $('.yanzhengcode').css('display', 'block');
                            captchaShowStatus = 1;
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
                                    //$('.num').text(data.vote_num);
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





                    }
                });

            }
            function doVote1() {
                var thisBtn = $('#vote');
                var ajaxVoteUrl = $('#vote').data('url');


                if ('{{ $vote->captcha_status }}' == 1 && captchaShowStatus == 0) {
                    $('.yanzhengcode').css('display', 'block');
                    captchaShowStatus = 1;
                    return false;
                }

                if(submintVoteStatus == 1){
                    return false;
                }

                if('{{ $subscribe }}' !== '1'){
                    //$('.footer_nav_gz a').click(); return false;
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
                            //$('.num').text(data.vote_num);
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
            }
            $('.votes-btn').click(function () {
                doVote(this);
            });

            function afterCheckCaptcha () {
                if ('{{ $vote->captcha_status }}' == 1) {
                    $('#captcha_img').attr('src', '{{ route("base.getCaptcha") }}?'+Math.random());
                    $('.yanzhengcode').css('display', 'none');
                    captchaShowStatus = 0;
                    $('#captcha_code').val('');
                }
            }

            // wechat jssdkConfig.
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



        var mySwiper = new Swiper(".swiper-container",{
            direction:"horizontal",/*横向滑动*/
            loop:true,/*形成环路（即：可以从最后一张图跳转到第一张图*/
            pagination:".swiper-pagination",/*分页器*/
            //prevButton:".swiper-button-prev",/*前进按钮*/
            //nextButton:".swiper-button-next",/*后退按钮*/
            autoplay:4000/*每隔3秒自动播放*/
        });
        // 搜索
        $('.footer-search').click(function () {
            $(window).scrollTop(0);
            $(".search_box").removeClass('box_hide');
        });
        $('.search_box').click(function () {
            $(".search_box").addClass('box_hide');
        });

        $('.search_box_main').click(function () {
            event.stopPropagation(); //阻止事件冒泡
        });

        $('.diabetes-rule').click(function () {
            $('.rule_box').removeClass('box_hide');
        });
        // 关注二维码
        var shareGuideFlag = 0;
        function showShareGuide(){
            if (shareGuideFlag == 1) {
                return;
            }
            $('body').append('<div id="share_guide_box" onclick="hideShareGuide();" style="position:fixed;z-index:999;left:0px;top:0px;width:100%;height:100%;background-color: rgba(0,0,0,0.8);text-align:right;" ontouchmove="return true;" ><img src="'+imagespath+'/scmy_qrcode.jpg" width="100%"></div>');
            shareGuideFlag = 1;
        }
        function hideShareGuide(){
            $("#share_guide_box").remove();
            shareGuideFlag = 0;
        }
        // 首次投票填写手机号码
        var submintMobileStatus = 0;
        $('.ph-btn').click(function () {
            if(submintMobileStatus == 1){
                return false;
            }

            var mobile = $('.ph-input').val().trim();
            if (mobile == '') {
                tusi('请填写手机号码');
                return false;
            }
            if (! checkMobile(mobile)) {
                tusi('请填写正确的手机号码');
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('home.vote.postDoSthByType' . Input::get('id')) }}?id={{ Input::get('id') }}",
                dataType : "json",
                data: {mobile: mobile, type: 3, id: '{{ Input::get('id') }}'},
                beforeSend: function () {
                    loading('请稍后');
                    submintMobileStatus = 1;
                },
                complete: function () {
                    loading(false);
                    submintMobileStatus = 0;
                },
                success: function(e){
                    if (e == 1) {
                        tusi('提交成功');
                        setTimeout(function(){
                            doVote1();
                            $('#vote').removeAttr('id');
                            $('.phone-mask').hide();
                        }, 1888);
                    }
                }
            });

        });
        $('.phone-mask').click(function () {
            $(this).hide();
        });
        $('.ph-content').click(function () {
            event.stopPropagation(); //阻止事件冒泡
        });

    });

    function closeRules() {
        console.log(1111)
        $('.rule_box').addClass('box_hide');
    }
    </script>
@endsection