<!-- 2018好医生 -->
@extends('layouts.home')


<?php $footer = 'app.vote.'.$id.'.footer';?>
<?php $modal = 'app.vote.'.$id.'.modal';?>

@section('selfmeta')
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
@endsection

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/js/jquery-1.11.3.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/js/html2canvas.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/js/canvas2image.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/swiper/swiper.min.js" type="text/javascript"></script>
    <link href="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/swiper/swiper.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
    <style>
        .footer_main{display: none}
    </style>
@endsection

@section('content')
    <section class="toup"  id="t1">
        <div class="swipers ind-swiper">
            <a href="javascript:;" class="jion"></a>
        </div>

        <div class="code-mask"><img src="{{ $qiniu_cdn_path }}/images/scmy_qrcode.jpg" width="100%"> </div>
    </section>
    <section class="toup" id="t2">
        <div class="swipers">
            <!-- 上下 -->
            <h3 class="title">抑郁倾向测试</h3>
            <h1 class="subtitle">抑郁自评量表（SDS）</h1>
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">1、我感到情绪沮丧，郁闷</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">2、我觉得一天中最好的时光是早上</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score1" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score1" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score1" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score1" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">3、我要哭或想哭</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score2" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score2" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score2" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score2" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">4、我夜间睡眠不好</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score3" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score3" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score3" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score3" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">5、我吃得跟平常一样多</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score4" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score4" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score4" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score4" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">6. 我与异性密切接触时和以往一样感到愉快</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score5" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score5" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score5" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score5" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">7. 我发觉我的体重在下降</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score6" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score6" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score6" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score6" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">8. 我为便秘而烦恼</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score7" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score7" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score7" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score7" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">9. 我的心跳比平时快</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score8" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score8" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score8" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score8" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">10. 我无缘无故感到疲劳</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score9" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score9" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score9" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score9" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">11. 我的头脑和平常一样清晰</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score10" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score10" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score10" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score10" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">12. 我觉得经常做的事情并没有困难</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score11" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score11" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score11" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score11" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">13. 我坐立不安，难以保持平静</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score12" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score12" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score12" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score12" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">14. 我对未来感到有希望</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score13" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score13" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score13" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score13" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">15. 我比平常容易生气激动</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score14" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score14" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score14" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score14" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">16. 我觉得做出决定是容易的</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score15" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score15" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score15" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score15" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">17. 我觉得有人需要我，自己是个有用的人</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score16" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score16" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score16" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score16" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">18. 我的生活很有意义</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score19" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score19" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score19" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score19" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">19. 我认为如果我死了，别人会生活得更好</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score17" value="1"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score17" value="2"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score17" value="3"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score17" value="4"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="scores">
                            <div class="f">20. 我仍旧喜爱自己平时喜爱的东西</div>
                            <div class="choose">
                                <div class="input"><label><input type="radio" name="score18" value="4"/><span>A. 没有或很少时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score18" value="3"/><span>B. 小部分时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score18" value="2"/><span>C. 相当多时间</span></label></div>
                                <div class="input"><label><input type="radio" name="score18" value="1"/><span>D. 绝大部分或全部时间</span></label></div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="progress-con clearfix">
                    <div class="pro-bar"><span></span></div>
                    <div class="pro-num"><span id="number">1</span>/20</div>
                </div>
                <div class="submit">立即提交</div>
                <!--<div class="preNexts">
                    <div class="swiper-button-prev"><div class="pre"></div>上一题</div>
                    <div class="swiper-button-next"><div class="next"></div>下一题</div>
                </div>-->
            </div>
            <!-- 上下end -->
        </div>
        <div class="logo"><div class="logo-icon"></div> </div>
        <p class="tip">测试结果仅供参考</p>
    </section>
    <section class="toup" id="t3">
        <div class="share-page" id="simg">
            <div class="code-img"><img src="{{ $qiniu_cdn_path }}/images/vote/{{ $vote->id }}/code.png" width="100%"> </div>
            <div class="img-con"><div class="user-img"><img src="{{ $userImg }}"> </div></div>
        </div>
        <div class="save">长按图片保存我的结果图</div>
    </section>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
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

        });
    </script>
    <script>
        function convert2canvas() {

            var cntElem = $('#simg')[0];

            var shareContent = cntElem;//需要截图的包裹的（原生的）DOM 对象
            var width = shareContent.offsetWidth; //获取dom 宽度
            var height = shareContent.offsetHeight; //获取dom 高度
            var canvas = document.createElement("canvas"); //创建一个canvas节点
            var scale = 2; //定义任意放大倍数 支持小数
            canvas.width = width * scale; //定义canvas 宽度 * 缩放
            canvas.height = height * scale; //定义canvas高度 *缩放
            canvas.getContext("2d").scale(scale, scale); //获取context,设置scale
            var opts = {
                scale: scale, // 添加的scale 参数
                canvas: canvas, //自定义 canvas
                // logging: true, //日志开关，便于查看html2canvas的内部执行流程
                width: width, //dom 原始宽度
                height: height,
                useCORS: true // 【重要】开启跨域配置
            };
            html2canvas(shareContent, opts).then(function (canvas) {

                console.log(shareContent)
                var context = canvas.getContext('2d');
                // 【重要】关闭抗锯齿
                context.mozImageSmoothingEnabled = false;
                context.webkitImageSmoothingEnabled = false;
                context.msImageSmoothingEnabled = false;
                context.imageSmoothingEnabled = false;

                // 【重要】默认转化的格式为png,也可设置为其他格式
                var img = Canvas2Image.convertToJPEG(canvas, canvas.width, canvas.height);

                $('#simg').append(img);

                $(img).css({
                    "width": canvas.width / 2 + "px",
                    "height": canvas.height / 2 + "px",
                    "position": "absolute",
                    "top": 0,
                    "left": 0,
                }).addClass('f-full');

            });
        };
        var mySwiper  = new Swiper('.swiper-container', {
            pagination: '.swiper-pagination',
            nextButton: '.swiper-button-next',
            prevButton: '.swiper-button-prev',
            slidesPerView: 1,
            paginationClickable: true,
            allowSwipeToNext: false,
            allowSwipeToPrev: false,
            spaceBetween: 30,
            loop: false,
            onSlideChangeEnd:function(swiper){
                var index = swiper.activeIndex
                console.log(index)
                setTimeout(function(){
                    $('#number').text(index+1)
                },100);
                $('.logo').show();
                $('.submit').hide();
            },
            onReachEnd: function(swiper){
                $('.logo').hide();
                $('.submit').show();
                $('.tip').show()
            }
        });
        $("#t2,#t3").hide();
        $("a.jion").on("click",function(){
            if ('{{ $subscribe }}' !== '1'){  //提交前先判断是否关注了公众号
                $('.code-mask').show();
            }else {
                $("#t1").hide();
                $("#t2").show();
            }
        });
        $(".swiper-container label,.swiper-container input").click(function(){
            mySwiper.params.allowSwipeToNext = true;
            var this_active = $(this).parents(".swiper-slide").index()
            var pro= $('.pro-bar').find('span');
            setTimeout(function(){
                mySwiper.slideTo(this_active+1,1000)
            },500);
            var wid = (5 * (this_active+1));
            pro.animate({"width":wid + "%"},400);
            if ( this_active <= 18) {
                setTimeout(function(){
                    $('#number').text(this_active+2)
                },500);
            }
            setTimeout(function(){
                mySwiper.params.allowSwipeToNext = false;
            },1000);
        });
        $('.submit').click(function () {
            if ($("input[type=radio]:checked").length === 20){
                var num = 0;
                var len = $("input[type=radio]:checked");
                for (var i = 0; i < len.length; i++) {
                    var score = $('.swiper-slide').eq(i).find("input[type=radio]:checked");
                    num += parseInt(score.val());
                }
                console.log(num);
                if (num <= 42) { //正常
                    $('.share-page').addClass('normal')
                }else if(num>42 && num <=50) { //轻度抑郁
                    $('.share-page').addClass('mild')
                }else if(num>50 && num <=58) { //明显抑郁
                    $('.share-page').addClass('obvious')
                }else if (num > 58) { //重度抑郁
                    $('.share-page').addClass('server')
                };
                $('#t3').show();
                $('#t1, #t2').hide();
                convert2canvas();
            }else {
                alert('请完成全部选择')
            }
        });
        /*$('.submit').click(function () {
            if ('' !== '1'){  //提交前先判断是否关注了公众号
                $('.code-mask').show();
            }else {
                console.log($("input[type=radio]:checked").length);
                if ($("input[type=radio]:checked").length === 20){
                    var num = 0;
                    var len = $("input[type=radio]:checked");
                    for (var i = 0; i < len.length; i++) {
                        var score = $('.swiper-slide').eq(i).find("input[type=radio]:checked");
                        num += parseInt(score.val());
                    }
                    console.log(num);
                    if (num <= 42) { //正常
                        $('.share-page').addClass('normal')
                    }else if(num>42 && num <=50) { //轻度抑郁
                        $('.share-page').addClass('mild')
                    }else if(num>50 && num <=58) { //明显抑郁
                        $('.share-page').addClass('obvious')
                    }else if (num > 58) { //重度抑郁
                        $('.share-page').addClass('server')
                    };
                    $('#t3').show();
                    $('#t1, #t2').hide();
                }else {
                    alert('请完成全部选择')
                }
            }

        })*/

    </script>
@endsection