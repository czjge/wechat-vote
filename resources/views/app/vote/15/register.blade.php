@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/register.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

    <header class="header_style clearfix">
        <a href="javascript:history.go(-1);"></a>
        <h1>报名</h1>
    </header>

    {{--<section class="add_top_box clearfix">--}}
        {{--<a href="">如果已报名，点此登陆</a>--}}
    {{--</section>--}}

    <section class="tab_box box_hide">
        <div class="box_select">
            <a href="{{ route('home.vote.getRegister'.Input::get('id')) }}?id={{ Input::get('id') }}&type=0" <?php if(Input::get('type')==0){echo 'class="active"';}?> >药企</a>
            <a href="{{ route('home.vote.getRegister'.Input::get('id')) }}?id={{ Input::get('id') }}&type=1" <?php if(Input::get('type')==1){echo 'class="active"';}?> >药店</a>
            <a href="{{ route('home.vote.getRegister'.Input::get('id')) }}?id={{ Input::get('id') }}&type=2" <?php if(Input::get('type')==2){echo 'class="active"';}?> >药品</a>
        </div>
    </section>
    <section class="add_form_box clearfix ">
        <div class="add_form_box_main clearfix">

            <form id="regFrom" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $vote->id }}"/>
                <input type="hidden" name="type" value="{{ Input::get('type') }}"/>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="30%">
                            <label class="c1">联系人</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="of_hospital" id="of_hospital" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label class="c1">联系方式</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="tel" id="tel" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label class="c1">名称</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="name" id="name" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label class="c1">品牌</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="brand" id="brand" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="30%"><label class="c1">所属区县</label></td>
                        <td>
                            <select class="input_class" name="title" id="titles">
                                <option value="0">请选择</option>
                                <option value="锦江区">锦江区</option>
                                <option value="青羊区">青羊区</option>
                                <option value="金牛区">金牛区</option>
                                <option value="武侯区">武侯区</option>
                                <option value="成华区">成华区</option>
                                <option value="高新区">高新区</option>
                                <option value="天府新区">天府新区</option>
                                <option value="龙泉驿区">龙泉驿区</option>
                                <option value="青白江区">青白江区</option>
                                <option value="新都区">新都区</option>
                                <option value="温江区">温江区</option>
                                <option value="双流区">双流区</option>
                                <option value="都江堰市">都江堰市</option>
                                <option value="彭州市">彭州市</option>
                                <option value="邛崃市">邛崃市</option>
                                <option value="崇州市">崇州市</option>
                                <option value="金堂县">金堂县</option>
                                <option value="郫都区">郫都区</option>
                                <option value="大邑县">大邑县</option>
                                <option value="浦江县">浦江县</option>
                                <option value="新津县">新津县</option>
                                <option value="简阳市">简阳市</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label class="c1">地址</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="address" id="address" />
                        </td>
                    </tr>

                    <tr>
                        <td><label class="c1">简介</label></td>
                        <td><textarea class="textarea_class" name="desc" id="desc"></textarea></td>
                    </tr>

                    <tr>
                        <td colspan="2" style="line-height:20px; height:60px; padding:10px;">
                            <label class="c3" style="line-height:40px;color: #949090;"><!--（LOGO/头像图片大小不超过{{ $vote->photo_size/1024 }}KB）
                            <br>-->如需修改信息或无法上传请联系小康妹儿17780661126
                            </label>
                        </td>
                    </tr>
                </table>
                <input  class="add_form_btn btn_class" type="button" value="提交" />
            </form>

        </div>
    </section>

@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js?v=2" type="text/javascript"></script>
    <script type="application/javascript" src="{{ $qiniu_cdn_path }}/plugins/ajax-fileupload/ajaxfileupload.js"></script>
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
            
            
            $(document).on('change', '#file_logo', function() {
                loading('上传中');
                uploadsuccess = function(data) {
                    if(data == '') {
                        loading(false);
                        tusi('上传错误');
                    }
                    var dataarr = data.split('|');
                    if(dataarr[0] == 0) {
                        loading(false);
                        $("#picurl_logo").val(dataarr[1]);
                        $("#picSpanLogo").html('<img width="120" height="120" src="/storage/'+dataarr[1]+'">');
                    }else if(dataarr[0] == 3){
                        loading(false);
                        tusi('上传图片过大');
                    } else {
                        loading(false);
                        tusi('上传错误');
                    }
                };
                $.ajaxfileupload({
                    url: '{{ route("base.postUpload") }}',
                    data: {_token: "{{ csrf_token() }}", size: "{{ $vote->photo_size }}", name: "file_logo"},
                    dataType: 'text',
                    fileElementId: 'file_logo',
                    success: uploadsuccess,
                    error: function() {
                        loading(false);
                        tusi('上传错误');
                    }
                });
            });

            $(".add_form_btn").click( function () {
                var of_hospital = $("#of_hospital").val();
                var tel = $("#tel").val();
                var name = $('#name').val();
                var address = $('#address').val();
                var desc = $("#desc").val();
                var picUrl = $('#picurl_logo').val();
                var type = '{{ Input::get("type") }}';
                var brand = $('#brand').val();
                var titles = $('#titles').val();

                if(of_hospital==""){
                    tusi("联系人不能为空");
                    return false;
                }
                if(titles=="0"){
                    tusi("请选择药店所在区域");
                    return false;
                }
                if(tel==""){
                    tusi("联系方式不能为空");
                    return false;
                }
                if(name==""){
                    tusi("名称不能为空");
                    return false;
                }
                if(address=="" && type!=2){
                    tusi("地址不能为空");
                    return false;
                }
                if(desc==""){
                    tusi("简介不能为空");
                    return false;
                }
//                if(picUrl==""){
//                    tusi("LOGO/头像不能为空");
//                    return false;
//                }
                if (! checkMobile(tel) && ! checkLandline(tel)) {
                    tusi("联系方式必须是手机或者座机");
                    return false;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ route('home.vote.getDoRegister'.Input::get('id')) }}",
                    data: $('#regFrom').serialize(),
                    success: function(msg){
                        if(msg == 1){
                            tusi("报名成功");
                            setTimeout(function(){window.location="{{ route('home.vote.getIndex'.Input::get('id')) }}?id={{ Input::get('id') }}";}, 1888);
                        }else if(msg == 2){
                            tusi("报名成功，请等待管理员审核…");
                            setTimeout(function(){window.location="{{ route('home.vote.getIndex'.Input::get('id')) }}?id={{ Input::get('id') }}";}, 1888);
                        }else if(msg == 3) {
                            tusi("联系方式已存在");
                            setTimeout(function(){document.location.reload();}, 1888);
                        }else{
                            tusi("报名失败");
                            //etTimeout(function(){document.location.reload();}, 1888);
                        }
                    }
                });
            });
        });
    </script>
@endsection