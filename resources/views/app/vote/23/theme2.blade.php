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
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <style>
        .footer_main{display: none}
    </style>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="main-head mara-reg-head"></div>
    <div class="mara-reg-rules">报名资格</div>
    <div class="reg-container marareg-container mrg-b8">
        <form id="" method="post" enctype="multipart/form-data" name="">
            <div class="reg-item">
                <div class="name-content">
                    <span class="icon-point">*</span>
                    <span class="reg-title">宝贝姓名</span>
                </div>
                <input type="text" class="name-input" placeholder="请输入宝贝的真实姓名" name="name">
            </div>
            <div class="reg-item">
                <span class="icon-point">*</span>
                <span class="reg-title">宝贝性别</span>
                <div class="reg-sex mrg-l3">
                    <div class="select-box selected"></div>
                    <span>小帅哥</span>
                </div>
                <div class="reg-sex mrg-l4">
                    <div class="select-box"></div>
                    <span>小美女</span>
                </div>
            </div>
            <div class="reg-item mrg-t3">
                <div class="clearfix">
                    <span class="icon-point">*</span>
                    <span class="reg-title">宝贝身份证号码<small>(购买保险使用)</small></span>
                </div>
                <div class="clearfix">
                    <input type="num" placeholder="请正确填写18位身份证件号码" class="sfz-input">
                </div>
            </div>
            <div class="reg-item">
                <span class="icon-point">*</span>
                <span class="reg-title">报名组别</span>
                <span class="reg-group clearfix">
                    <div class="group-age clearfix">
                        <div class="select-box selected"></div>
                        <span>A组（6岁以下）</span>
                    </div>
                    <div class="group-age clearfix">
                        <div class="select-box"></div>
                        <span>B组（7-9岁）</span>
                    </div>
                    <div class="group-age clearfix">
                        <div class="select-box"></div>
                        <span>C组（10-12岁）</span>
                    </div>
                </span>
            </div>
            <div class="reg-item">
                <div class="name-content">
                    <span class="icon-point">*</span>
                    <span class="reg-title">家长姓名</span>
                </div>
                <input type="text" class="name-input" placeholder="请输入家长的真实姓名" name="name">
            </div>
            <div class="reg-item">
                <span class="icon-point">*</span>
                <span class="reg-title">家长性别</span>
                <div class="parent-sex mrg-l3">
                    <div class="select-box selected"></div>
                    <span>小帅哥</span>
                </div>
                <div class="parent-sex mrg-l4">
                    <div class="select-box"></div>
                    <span>小美女</span>
                </div>
            </div>
            <div class="reg-item mrg-t3">
                <div class="clearfix">
                    <span class="icon-point">*</span>
                    <span class="reg-title">家长身份证号码<small>(购买保险使用)</small></span>
                </div>
                <div class="clearfix">
                    <input type="num" placeholder="请正确填写18位身份证件号码" class="sfz-input">
                </div>
            </div>
            <div class="reg-item mrg-t5">
                <div class="name-content">
                    <span class="icon-point">*</span>
                    <span class="reg-title">联系方式</span>
                </div>
                <input type="num" class="name-input" placeholder="请输入家长的真实姓名">
            </div>
            <div class="reg-protocal clearfix">
                <span class="check-opt"><i class="check-box"></i>我已了解</span><span class="report">《风险报告》</span>
            </div>
        </form>
        <div class="btn-sure bg-gray">支付￥101元</div>
    </div>
@endsection
@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script>
        $('.report').click(function () {  //风险报告
            $('.report_box').removeClass('box_hide');
        });
        $('.check-opt').click(function () {
            if($('.check-box').hasClass('checked')){
                $('.check-box').removeClass('checked');
                $('.btn-sure').addClass('bg-gray');
            }else {
                $('.check-box').addClass('checked');
                $('.btn-sure').removeClass('bg-gray');
            }
        })
        $('.reg-sex').click(function () {  //性别
            $(this).parent().find(".select-box").removeClass('selected');
            $(this).find('.select-box').addClass('selected');
        });

        $('.parent-sex').click(function () {  //家长性别
            $(this).parent().find(".select-box").removeClass('selected');
            $(this).find('.select-box').addClass('selected');
        });
        $('.group-age').click(function () {  //分组
            $(this).parent().find(".select-box").removeClass('selected');
            $(this).find('.select-box').addClass('selected');
        });
        $(document).on('click','.mara-reg-rules',function () {
            $('.usual_box').removeClass('box_hide');
        });

        function closeRules(e) {
            $(e).parent().addClass('box_hide');
        }
    </script>

@endsection
