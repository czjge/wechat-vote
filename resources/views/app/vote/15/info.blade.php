@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('selfmeta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle3.css?v=2" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">
    <style>
        body{background: #fff;}
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
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/{{ $candidate->vote_id }}/rank-banner-zz.jpg" width="100%"></section>

    <section class="info_top list_box clearfix">
        <div class="info-part01 list_item">
            <div class="head-img">
                @if($candidate->pic_url)
                <img src='{{ $qiniu_cdn_path }}/storage/{{ $candidate->pic_url }}?v=2'/>
                @else
                    @if($brand->b_log)
                     <img src='{{ $qiniu_cdn_path }}/storage/log/{{ $brand->b_log }}?v=2'/>
                    @else
                    <img src='/images/vote/15/header.png'/>
                    @endif
                @endif
            </div>
            <div class="title">
                <p class="title-first">
                    <span class="xm">{{ $candidate->name }}</span>
                </p>
                <p>
                    <span class="yy">{{ $candidate->address }}</span>
                </p>
            </div>

            <!-- captcha -->
            @if($vote->captcha_status == 1)
            <div class="yanzhengcode" style="display: none;">
                <img src="{{ route('base.getCaptcha') }}" onclick="javascript:this.src='{{ route('base.getCaptcha') }}?'+Math.random()" id="captcha_img"/>
                <input type="text" name="captcha_code" id="captcha_code" placeholder="请输入验证码"/>
                <input type="button" value="确定" id="captcha_code_btn"/>
            </div>
            @endif

        </div>
    </section>

    <section class="info-main clearfix">
        <div class="info-part02">
            <p class="info1">
                @if($candidate->desc)
                    {{ $candidate->desc }}
                @else
                    {{ $brand->desc }}
                @endif
                
            </p>
        </div>
    </section>
    <section class="footer_info">
        <p>已有<span class="num">{{ $candidate->num }}</span>人为TA点赞</p>
        <div class="main_btn">
            @if (strtotime($vote->start_time) > time())
                未开始
            @elseif (time() > strtotime($vote->end_time))
                已结束
            @else
                为TA点赞
            @endif
        </div>
    </section>
    <section class="review-info">
        <div class="info-5 review-panel">
            <div class="info-title">
                <span>评论({{$commetNumber}})</span>
                <a href="javascript:void(0);" class="to-review-box"><i></i>写评论</a>
            </div>
            <ul id="comment_ul">
                <volist name="commentInfo" id="comment">
                    @foreach($comment as $key => $item)
                    <li>
                        <div class="myhead-img" style="background-image: url({{ $item->headimgurl }});"></div>
                        <div class="review-text">
                            <p><span class="review-name">{{ $item->name }}</span><span class="review-time"><?php echo date('Y-m-d H:i:s',$item->comment_time)  ;?></span></p>
                            <label class="">{{ $item->comment }}</label>
                        </div> 
                    </li>
                    @endforeach
                </volist>
            </ul>
<!--            <span id="addmore" class="add-more">点击加载全部</span><input type="hidden" id="commentpage" value="1">-->
            @if ($commetNumber>10 && $type!=1)
            <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$candidate->id]).'?id='.$id.'&type=1' }}">点击加载全部</a>
            @endif
        </div>
    </section>
    
    <section class="review_box clearfix box_hide">
        <div class="review_main clearfix">
            <div class="review">
                <textarea placeholder="请在这里输入您的评论" id="commentContent" maxlength=300></textarea>
                <div class="row">
                    <input type="button" id="form_cancel" value="取消" class="col-30 goback button button-fill button-big bg-gray color-666"/>
                    <input type="button" id="commnet_submit" value="提交" class="col-70 button button-fill button-big color-blue"/>
                    <input type="button" id="commnet_submits" value="提交中" class="col-70 button button-fill button-big color-blue box_hide"/>
<!--                        <a href="#" id="form_cancel" class="col-30 goback button button-fill button-big bg-gray color-666">取消</a>
                    <a href="#" id="form_submit" class="col-70 button button-fill button-big color-blue">提交</a>-->
                </div>
            </div>
        </div>
        <div class="close_box count_down_close_box"></div>
    </section>
    <div style="display: none;"><script src="https://s13.cnzz.com/z_stat.php?id=1263058209&web_id=1263058209" language="JavaScript"></script></div>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js?v=2" type="text/javascript"></script>
    <script type="application/javascript">
        // 写评论
        $(document).on('click', '#form_cancel', function () {
                $(".review_box").addClass('box_hide');
        });
        $(document).on('click', '.to-review-box', function () {
                $(window).scrollTop(0);
                $(".review_box").removeClass('box_hide');
                var a = '<?php if (strtotime($vote->start_time) > time() || time() > strtotime($vote->end_time)) {
                                        echo 1;
                                    } else {
                                        echo 2;
                                    }
                            ?>';
                if (a==1) {
                    tusi("投票未开始或已结束，不可评论");
                }
        });
        
        $(function () {
            var submintVoteStatus = 0;
            var captchaShowStatus = 0;
            $('.tp_btn2,.tp_btn1,#captcha_code_btn,.main_btn').click(function () {

                var a = '<?php if (strtotime($vote->start_time) > time() || time() > strtotime($vote->end_time)) {
                                        echo 1;
                                    } else {
                                        echo 2;
                                    }
                            ?>';
                if (a==1) {
                    tusi("投票未开始或已结束");
                    return false;
                }

                if ('{{ $vote->captcha_status }}' == 1 && captchaShowStatus == 0) {
                    $('.yanzhengcode').css('display', 'block');
                    captchaShowStatus = 1;
                    return false;
                }

                if(submintVoteStatus == 1){
                    return false;
                }

                if('{{ $subscribe }}' !== '1'){
                    $('.footer_nav_gz a').click(); return false;
                }

                var ajaxVoteUrl = "{{ $ajaxVoteUrl }}&type={{ $type }}";
                if ('{{ $vote->captcha_status }}' == 1) {
                    if ($('#captcha_code').val() == '') {
                        tusi("请输入验证码");return;
                    }
                    ajaxVoteUrl = "{{ $ajaxVoteUrl }}&captcha_code="+$('#captcha_code').val();
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
                            $('.num').text(data.vote_num);
                            tusi(data.msg);
                        } else if (data.code == 209) {
                            afterCheckCaptcha();
                            $('.footer_nav_gz a').click();
                        } else if (data.code == 210) {
                            afterCheckCaptcha();
                            tusi("请再试一次");
                            setTimeout(function(){
                                window.location.href = '{{ $reloadUrl }}&type={{ $type }}';
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
            
            $('#commnet_submit').click(function () {
                var a = '<?php if (strtotime($vote->start_time) > time() || time() > strtotime($vote->end_time)) {
                                        echo 1;
                                    } else {
                                        echo 2;
                                    }
                            ?>';
                if (a==1) {
                    tusi("投票未开始或已结束，不可评论");
                    return false;
                }
                
                if(submintVoteStatus == 1){
                    return false;
                }
                
                if('{{ $subscribe }}' !== '1'){
                    $('.footer_nav_gz a').click(); return false;
                }
                
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var ajaxCommentUrl = "{{ $ajaxCommentUrl }}&type={{ $type }}";
                var comment = $('#commentContent').val();
                
                if($.trim(comment)==''){
                    tusi("评论内容不能为空");
                    return false;
                }
                
                $.ajax({
                    type: "POST",
                    url: ajaxCommentUrl,
                    dataType : "json",
                    data: {'comment':comment},
                    beforeSend: function () {
                        loading('请稍后');
                        submintVoteStatus = 1;
                        $("#commnet_submit").hide();
                        $("#commnet_submits").show();
                    },
                    complete: function () {
                        loading(false);
                        submintVoteStatus = 0;
                    },
                    success: function(data){
                        if (data.code == 200) {
                            tusi(data.msg);
                            setTimeout(function(){
                                window.location.href = '{{ $reloadUrl }}&type={{ $type }}';
                            },1888);
                        }else {
                            tusi(data.msg);
                            tusi("请再试一次");
                            setTimeout(function(){
                                window.location.href = '{{ $reloadUrl }}&type={{ $type }}';
                            },1888);
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
                    link: '{!! $shareInfo['shareUrl'] !!}', // 分享链接
                    //imgUrl: '{{ asset($shareInfo['shareLogo']) }}', // 分享图标
                    imgUrl: '<?php if(strpos($shareInfo['shareLogo'], 'http')===false){echo asset('storage/'.$shareInfo['shareLogo']);}else{echo $shareInfo['shareLogo'];}?>', // 分享图标
                    success: function () {
                    },
                    cancel: function () {
                    }
                });

                wx.onMenuShareAppMessage({
                    title: '{!! $shareInfo['shareTitle'] !!}', // 分享标题
                    desc: '{!! $shareInfo['shareDesc'] !!}', // 分享描述
                    link: '{!! $shareInfo['shareUrl'] !!}', // 分享链接
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
@endsection
