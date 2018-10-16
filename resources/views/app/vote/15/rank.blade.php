@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle3.css?v=2" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">
    <style>
        .zz_box img{
            border: solid 10px #ebb752;
            border-radius: 20px;
            width: 670px;
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('content')
    <section class="top_box clearfix"><img src="{{ $qiniu_cdn_path }}/images/vote/{{ $vote->id }}/rank-banner-zz.jpg" width="100%"></section>
    @if($rank>1)
        @if($rank==3)
        <section class="brand-box clearfix margin--90">
            <div class="brand-title">
                <div class="head-img">
                    @if($brandList->b_log)
                    <img src='{{ $qiniu_cdn_path }}/storage/log/{{ $brandList->b_log }}?v=2'/>
                    @else
                    <img src='/images/vote/15/header.png'/>
                    @endif
                </div>
                <div class="title">
                    <p class="title-first">
                        <span class="xm">{{ $brandList->name }}</span>
                    </p>
                </div>
            </div>
            <div class="brand-info">
                <p>{{ $brandList->desc }}</p>
            </div>
        </section>
        @endif
        <section class="select_section brand-list">
            <section class="phb_box clearfix <?php if($rank==2){echo 'margin--120';} ?>"><!-- 搜索加margin--120 -->
                <div class="phb_box_table mzy-phb clearfix">
                    @foreach($rankList as $key => $item)
                    <div class="list_item">
                        <input type="hidden" id="cid" value="{{ $item->id }}"/>
                        <a href="{{ $item->url }}">
                            <div class="pm">{{ $key+1 }}</div>
                            <div class="title">
                                <p class="title-first"><span class="xm">{{ $item->name }}</span></p>
                            </div>
                        </a>
                        <div class="ps">
                            <label><span class="num" id="num{{ $item->id }}">{{ $item->num }}</span> 赞</label>
                            <div class="btn_box" onclick="fun('{{$item->id}}')">
                                @if (strtotime($vote->start_time) > time())
                                    未开始
                                @elseif (time() > strtotime($vote->end_time))
                                    已结束
                                @else
                                    为TA点赞
                                @endif
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
        </section>
    </section>
    <section class="zz_box clearfix"><a href="https://cms.scmingyi.com/jkbydbd/189.jhtml"><img src="{{ $qiniu_cdn_path }}/images/vote/{{ $vote->id }}/banner10.jpg"></a></section>
    @else
    <section class="select_section">
        <section class="phb_box clearfix margin--120"><!-- 排行榜 -->
            <div class="phb_box_table mzy-phb clearfix">
                @foreach($rankList as $key => $item)
                <div class="list_item">
                    <a href="{{ $item->url }}">
                        <div class="pm">{{ $key+1 }}</div>
                        <div class="title">
                            <p class="title-first"><span class="xm">{{ $item->name }}</span></p>
                        </div>
                        <div class="ps"><span class="num">{{ $item->num }}</span> 赞</div>
                    </a>
                </div>
                @endforeach
            </div>
        </section>
    </section>
    @endif
    
    <div style="display: none;"><script src="https://s13.cnzz.com/z_stat.php?id=1263058209&web_id=1263058209" language="JavaScript"></script></div>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js?v=2" type="text/javascript"></script>
    <script type="application/javascript">
		function fun(cid){
			var captchaShowStatus = 0;
			if(submintVoteStatus ==1){
				
			}else{
				var submintVoteStatus = 0;
			}
			
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
			
			var ajaxVoteUrl ="https://cdsb.scmingyi.cn/vote/do-vote/"+cid+"/{{ $wid }}?id=15&type={{$type}}";
			
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
						$('#num'+cid).text(data.vote_num);
						tusi(data.msg);
						setTimeout(function(){
							window.location.href = "https://cdsb.scmingyi.cn/vote/rank?id=15&type={{$type}}";
						},1000);
					} else if (data.code == 209) {
						afterCheckCaptcha();
						$('.footer_nav_gz a').click();
					} else if (data.code == 210) {
						afterCheckCaptcha();
						tusi("请再试一次");
						setTimeout(function(){
							window.location.href = "https://cdsb.scmingyi.cn/vote/rank?id=15&type={{$type}}";
						},1888);
					} else if (data.code == 211) {
						$('#captcha_code').val('');
						tusi(data.msg);
					} else if (data.code == 202) {
						afterCheckCaptcha();
						tusi(data.msg);
					}else if (data.code == 206) {
						afterCheckCaptcha();
						tusi(data.msg);
						setTimeout(function(){
							window.location.href = "https://cdsb.scmingyi.cn/vote/rank?id=15&type={{$type}}";
						},1888);
					}else {
						afterCheckCaptcha();
						tusi(data.msg);
					}
				}
			});
		};
		
		function afterCheckCaptcha () {
			if ('{{ $vote->captcha_status }}' == 1) {
				$('#captcha_img').attr('src', '{{ route("base.getCaptcha") }}?'+Math.random());
				$('.yanzhengcode').css('display', 'none');
				captchaShowStatus = 0;
				$('#captcha_code').val('');
			}
		}
            
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
