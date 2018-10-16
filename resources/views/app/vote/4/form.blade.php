@extends('layouts.home')


<?php $footer = 'app.vote.'.$id.'.footer';?>
<?php $modal = 'app.vote.'.$id.'.modal';?>

@section('title')
    预签约报名
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $id }}/register.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

    <header class="header_style clearfix">
        <h1>预签约报名</h1>
    </header>

    <section class="add_form_box clearfix">
        <div class="add_form_box_main clearfix">
            <form id="regFrom_doc" method="post" enctype="multipart/form-data" name="doc">
                {!! csrf_field() !!}
                <input type="hidden" name="id" value="{{ $id }}"/>
                <input type="hidden" name="cid" value="{{ $cid }}"/>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="30%">
                            <label class="c1">您的姓名</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="name" id="name" />            
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label class="c1">手机号码</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="tel" id="tel" />            
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="30%"><label class="c1">性别</label></td>
                        <td>
                            <select class="input_class" name="sex" id="sex">
                                <option value="0">男</option>
                                <option value="1">女</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label class="c1">年龄</label>
                        </td>
                        <td>
                            <input type="number" class="input_class" name="age" id="age" />            
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label class="c1">预签约的团队</label>
                        </td>
                        <td>
                            @if($list->type==0)
                            {{ $list->of_dep }}
                            @else
                            {{ $list->of_hospital }}
                            @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="30%"><label class="c1">身体状况</label></td>
                        <td>
                            <select class="input_class" name="disease" id="disease">
                                <option value="健康">健康</option>
                                <option value="糖尿病">糖尿病</option>
                                <option value="高血压">高血压</option>
                                <option value="慢阻肺(COPD)">慢阻肺(COPD)</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" style="line-height:20px; height:60px; padding:10px;">
                            <label class="c3" style="line-height:30px;color: #949090;">（契约式家庭服务，以病人为中心，<br/>全面、连续、有效、及时。）</label>
                        </td>
                    </tr>
                </table>
                <input  class="doc_add_form_btns btn_class" type="button" value="提交" />
            </form>
        </div>
    </section>

@endsection

@section('selfjs')
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $id }}/script.js" type="text/javascript"></script>
    <script type="application/javascript" src="{{ $qiniu_cdn_path }}/plugins/ajax-fileupload/ajaxfileupload.js"></script>
    <script type="application/javascript">
        $(function () {
            // candidate sign up.
            $(".doc_add_form_btns").click( function () {
                var name = $("#name").val();
                var tel = $("#tel").val();
                var age = $("#age").val();
                if(name == ""){
                    tusi("团队联系人不能为空");
                    return false;
                }
                if(tel == ''){
                    tusi("联系人手机号码不能为空");
                    return false;
                }
                if (! checkMobile(tel)) {
                    tusi("手机号码格式不正确");
                    return false;
                }
                if(age == ''){
                    tusi("年龄不能为空");
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('home.form.getForm'.$id,['cid'=>$cid,'id'=>$id]) }}",
                    data: $('#regFrom_doc').serialize(),
                    success: function(msg){
                        if(msg == 1){
                            tusi("预签约成功！");
                            setTimeout(function(){window.location="{{ route('home.vote.getInfo'.$id,['cid'=>$cid]) }}?id={{ $id }}";}, 3000);
                        }else if(msg == 2){
                            tusi("预签约成功，请等待管理员审核…");
                            setTimeout(function(){window.location="{{ route('home.vote.getInfo'.$id,['cid'=>$cid]) }}?id={{ $id }}";}, 3000);
                        }else if(msg == 3) {
                            tusi("该号码已存在，请勿重复报名");
                            setTimeout(function(){document.location.reload();}, 3000);
                        }else if(msg == 4){
                            tusi("预签约失败，路径错误");
                            setTimeout(function(){document.location.reload();}, 3000);
                        }else if(msg == 5){
                            tusi("失败，对象不存在或被锁定");
                            setTimeout(function(){document.location.reload();}, 3000);
                        }else{
                            tusi("预签约失败");
                            //etTimeout(function(){document.location.reload();}, 3000);
                        }
                    }
                });
            });
        });
    </script>
    
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $id }}/script.js" type="text/javascript"></script>
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
@endsection
