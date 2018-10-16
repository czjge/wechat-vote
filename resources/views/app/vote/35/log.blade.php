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
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="mara-head log-banner">
    </div>
    <ul class="record-content">
        @if(count($logList) == 0)
            <span class="tip-text">您今天还没投票，快去给Ta投票吧~</span>
        @else
            @foreach($logList as $key => $logItem)
            <li>
                <div class="record-info">
                    <div class="record-name">【{{ $logItem->name }}】</div>
                    <div class="record-time">{{ date('Y-m-d H:i:s', $logItem->time) }}</div>
                </div>
                <div class="record-status">点赞成功！</div>
            </li>
            @endforeach
        @endif

    </ul>
@endsection
@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script>

        // 搜索
        $('.footer-search').click(function () {
            $(window).scrollTop(0);
            $(".search_box").removeClass('box_hide');
        });
        $('.search_box').click(function () {
            $(".search_box").addClass('box_hide');
        })
        $('.search_box_main').click(function () {
            event.stopPropagation(); //阻止事件冒泡
        })

    </script>

@endsection
