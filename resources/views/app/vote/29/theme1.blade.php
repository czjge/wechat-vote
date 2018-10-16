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
    <link href="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.min.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <style>
        .footer_main{display: block}
    </style>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection
<div class="th-head"><div class="board-head"></div> </div>
<div class="tab-board-content">
    <div class="search-content clearfix">
        <div class="se-icon"></div>
        <input class="se-input" type="search" placeholder="搜索科室" id="search_dept" value="@if(2 == Input::get('type')) {{ Input::get('kwd') }} @endif">
    </div>
    <ul class="dept-board">

        @foreach($dep_list as $key => $dep_item)
            <li>
                <a href="{{ route('home.vote.getLog'.Input::get('id')) }}?id={{ Input::get('id') }}&type=4&name={{ $dep_item->dep_name }}">
                    <div class="dept-left">{{ $dep_item->dep_name }}</div>
                    {{--<div class="dept-right">{{ $dep_item->dep_total_num }}<i class="icon-arrorwy"></i> </div>--}}
                    <div class="dept-right">Top10<i class="icon-arrorwy"></i> </div>
                </a>
            </li>
        @endforeach

    </ul>
</div>
<div style="height: 50px"></div>
@section('content')

@endsection
@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/plugins/swiper/swiper-3.4.2.jquery.min.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script>
        var mySwiper = new Swiper(".swiper-container",{
            direction:"horizontal",/*横向滑动*/
            loop:true,/*形成环路（即：可以从最后一张图跳转到第一张图*/
            pagination:".swiper-pagination",/*分页器*/
            //prevButton:".swiper-button-prev",/*前进按钮*/
            //nextButton:".swiper-button-next",/*后退按钮*/
            autoplay: 4000/*每隔3秒自动播放*/
        });
        $('.tab-index').click(function () {
            $('.tab-opt').removeClass('active');
            $(this).addClass('active');
            $('.tab-contents').addClass('hide');
            $('.index-content').removeClass('hide');
        });
        $('.tab-activity').click(function () {
            $('.tab-opt').removeClass('active');
            $(this).addClass('active');
            $('.tab-contents').addClass('hide');
            $('.second-content').removeClass('hide');
        });
        $('.tab-rules').click(function () {
            $('.tab-opt').removeClass('active');
            $(this).addClass('active');
            $('.tab-contents').addClass('hide');
            $('.third-content').removeClass('hide');
        });

        $("#search_dept").on('keypress', function(e) {
            var keycode = e.keyCode;
            //获取搜索框的值
            var searchContent = $(this).val().trim();
            if (keycode == '13') {
                e.preventDefault();
                //请求搜索接口
                if (searchContent == '') {
                    alert('请输入检索内容！');
                } else {
                    //alert(searchContent);
                    window.location.href = '{{ route("home.vote.getTheme1" . Input::get('id')) }}?id={{ Input::get('id') }}&type=2&kwd=' + searchContent;
                }
            }
        });
    </script>

@endsection
