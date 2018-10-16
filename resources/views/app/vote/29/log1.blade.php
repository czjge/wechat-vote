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
    <div class="board-head"></div>
    <div class="log-title">{{ $title_words }}</div>

    <ul class="record-content clearfix">
        @foreach($doc_list as $key => $doc_item)

            <li>
                <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $doc_item->doc_id]) }}?id={{ Input::get('id') }}">
                    <div class="record-img"><img src="@if(''==$doc_item->doc_avatar) {{ $qiniu_cdn_path }}/images/default_doc_avatar.jpg @elseif(false !== strpos($doc_item->doc_avatar, 'https')) {{ $doc_item->doc_avatar }} @else {{ $qiniu_cdn_path }}/storage/{{ $doc_item->doc_avatar }} @endif"> </div>
                    <div class="record-info">
                        <div class="record-detail ellipsis"><span>{{ $doc_item->doc_name }}</span>{{ $doc_item->doc_title }}</div>
                        <div class="record-hos ellipsis">{{ $doc_item->doc_hos }}</div>
                    </div>
                </a>
            </li>

        @endforeach

    </ul>
    <p style="font-size: 13px;color: #999;margin-top: .2rem;">按姓名首字母排名</p>{{--专科专病榜时显示--}}
    <div style="height:50px;"></div>
@endsection
@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script>

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

    </script>

@endsection
