<!-- 2018.08.10义诊 -->
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
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/stylev1.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="mara-head"> </div>
    <div class="count-down mrg-t15 hide">
        <span class="count-tilte">—&nbsp;倒计时&nbsp;—</span>
        <div class="count-down mrg-t1">
            <span class="count-dd"></span><span class="day-coma"> :</span>
            <span class="count-hh"></span><span> :</span>
            <span class="count-mm"></span><span> :</span>
            <span class="count-ss"></span>
        </div>
    </div>
    <div class="top-title">
        义诊名医
       {{-- <span>抢号规则</span>--}}
    </div>
    <div class="main-content">
        @foreach($candidates as $key => $candidate)
            <div class="doc-item">
                <a class="doc-img" href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $candidate->id]) }}?id={{ Input::get('id') }}">
                    <img src="<?php if($candidate->pic_url==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo $qiniu_cdn_path.'/storage/'.$candidate->pic_url;}?>">
                </a>
                <div class="doc-info">
                    <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $candidate->id]) }}?id={{ Input::get('id') }}">
                        <div class="doc-name">{{ $candidate->name }} <span>{{ $candidate->department }}</span></div>
                        <div class="doc-hos">{{ $candidate->hospital }}</div>
                    </a>
                    <div class="btuns">
                        @if (explode('@', $candidate->registration_left_num)[0] != '')
                        <div class="grabnum-btn" data-id="{{ $candidate->id }}" data-time="sw">
                            <i class="icon-num"></i> 上午<span>(余<span class="regis-num">{{ explode('@', $candidate->registration_left_num)[0] }}</span>)</span>
                        </div>
                        @endif                        
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="support-info">
        <div class="support-item">
            <span class="support-title">活动时间：</span>
            <div class="support-detail">
                8月19日上午8：40至中午12点
            </div>
        </div>
        <div class="support-item">
            <span class="support-title">活动地点：</span>
            <div class="support-detail">
                成都市妇女儿童中心医院儿科大楼
            </div>
        </div>
    </div>
    <div style="height: .5rem"></div>
    <div class="tip-modal">
        <div class="tip-container">

            <div class="tip-text tip-s">抢号成功!</div>
            <div class="tip-text mrg">扫码进群获取市妇儿免费微坐诊及义诊当天医生信息</div>
            <div class="tip-img"><img src="{{ $qiniu_cdn_path.'/storage/'.$vote->qr_code_logo }}" width="100%"> </div>
            <div class="tip-close">关闭</div>
        </div>
    </div>

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
        $(function () {
            window.setInterval(getTimer,10);/!*设置不间断定时器执行getTimer函数*!/
            function getTimer() {
                var d ="{{ $vote->start_time }}";
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
                    $('.count-down').hide();
                }
                if (day == 00) {
                    $('.count-dd,.day-coma').hide();
                }
               $('.count-dd').text(day);
               $('.count-hh').text(hour);
               $('.count-mm').text(minute);
               $('.count-ss').text(second);

            }


        });

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 出现弹框
        var getRegisNumStatus = 0;
        var thisDocId = null;
        var thisTime = null;
        $('.grabnum-btn').click(function () {
            // 查看抢号时间到了没
            if ('<?php echo time();?>' < '<?php echo strtotime($vote->start_time);?>') {
                alert('时间未到，请稍后');
                return false;
            }
			// 查看抢号结束没
			if ('<?php echo time();?>' > '<?php echo strtotime($vote->end_time);?>') {
                alert('抢号已结束');
                return false;
            }

            // 查看还有号没有，ajax实时获取
            if(getRegisNumStatus == 1){
                return false;
            }

            var id = $(this).data('id');
            var time = $(this).data('time');
            thisDocId = id;
            thisTime = time;
            $.ajax({
                type: "POST",
                url: "{{ route('home.vote.postDoSthByType' . Input::get('id')) }}?id={{ Input::get('id') }}",
                dataType : "json",
                data: {id: id, type: 2, time: time},
                beforeSend: function () {
                    loading('请稍后');
                    getRegisNumStatus = 1;
                },
                complete: function () {
                    loading(false);
                    getRegisNumStatus = 0;
                },
                success: function(data){
                    if (data != -1) {
                        if (data < 1) {
                            alert('抢光啦');
                        } else {
                            $('.success-modal').show();
                        }
                    } else {
                        alert('服务器忙');
                    }
                }
            });
        });
        $('.success-modal').click(function () {
            $(this).hide();
        });
        function closeRules() {
            $('.rule_box').addClass('box_hide');
        }
        $('.alert-success-content').click(function () {
            event.stopPropagation();
        });
        $('.tip-close').click(function () {
            $('.tip-modal').hide();
        });

        // 提交表单
        var submintVoteStatus = 0;
        function closeSubmit() {
            if(submintVoteStatus == 1){
                return false;
            }

            var name = $('#yizhen2-name').val().trim();
            var phone = $('#yizhen2-phone').val().trim();
            if (! name) {
                alert('姓名不能为空');
                return false;
            }
            if (! phone) {
                alert('手机号不能为空');
                return false;
            }
            if (! checkMobile(phone)) {
                alert('手机号格式错误');
                return false;
            }

            $.ajax({
                type: "POST",
                url: "{{ route('home.vote.postDoSthByType' . Input::get('id')) }}?id={{ Input::get('id') }}",
                dataType : "json",
                data: {name: name, phone: phone, id: thisDocId, type: 1, vote_id: '{{ Input::get('id') }}', time: thisTime},
                beforeSend: function () {
                    loading('请稍后');
                    submintVoteStatus = 1;
                },
                complete: function () {
                    loading(false);
                    submintVoteStatus = 0;
                },
                success: function(data){
                    if (data == -2) {
                        alert('有人比你快了一步抢到');
                    } else if(data == -4) {
                        alert('一个微信号只能抢一个号');
                    } else if(data == -5) {
                        alert('时间未到，请稍后');
                    } else if(data > -1) {
                        //alert('抢号成功');
                        $('.tip-modal').show();
                        for (var i = 0;i < $('.grabnum-btn').length;i++) {
                            if (thisDocId == $($('.grabnum-btn')[i]).data('id')) {
                                $($($('.grabnum-btn')[i])).find('.regis-num').text(data);
                            }
                        }
                    } else {
                        alert('服务器忙');
                    }
                    $('.success-modal').hide();
                }
            });
        }

    </script>
@endsection