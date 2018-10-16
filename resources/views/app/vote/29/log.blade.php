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

    <div class="search-content mrg clearfix">
        <div class="se-icon"></div>
        <input class="se-input" type="search" placeholder="搜索医生" id="search_doc" value="{{ Input::get('kwd') }}">
    </div>

    <ul class="record-content clearfix">
        @foreach($doc_list as $key => $doc_item)

            @if($doc_item->rank_num <= 10)
            <li>
                <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $doc_item->doc_id]) }}?id={{ Input::get('id') }}">
                    <div class="record-num">
                        <div class="number"><?php if(10!=$doc_item->rank_num){echo 0;}?>{{ $doc_item->rank_num }}</div>
                        <div class="label">top</div>
                    </div>
                    <div class="record-img"><img src="@if(''==$doc_item->doc_avatar) {{ $qiniu_cdn_path }}/images/default_doc_avatar.jpg @elseif(false !== strpos($doc_item->doc_avatar, 'https')) {{ $doc_item->doc_avatar }} @else {{ $qiniu_cdn_path }}/storage/{{ $doc_item->doc_avatar }} @endif"> </div>
                    <div class="record-info">
                        <div class="record-detail ellipsis"><span>{{ $doc_item->doc_name }}</span>{{ $doc_item->doc_title }}</div>
                        <div class="record-hos ellipsis">{{ $doc_item->doc_hos }}</div>
                    </div>
                </a>
            </li>
            @endif

            @if($doc_item->rank_num > 10)
            <li>
                <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $doc_item->doc_id]) }}?id={{ Input::get('id') }}">
                    <div class="record-num">
                        <div class="number normal">{{ $doc_item->rank_num }}</div>
                    </div>
                    <div class="record-img"><img src="@if(''==$doc_item->doc_avatar) {{ $qiniu_cdn_path }}/images/default_doc_avatar.jpg @elseif(false !== strpos($doc_item->doc_avatar, 'https')) {{ $doc_item->doc_avatar }} @else {{ $qiniu_cdn_path }}/storage/{{ $doc_item->doc_avatar }} @endif"> </div>
                    <div class="record-info">
                        <div class="record-detail ellipsis"><span>{{ $doc_item->doc_name }}</span>{{ $doc_item->doc_title }}</div>
                        <div class="record-hos ellipsis">{{ $doc_item->doc_hos }}</div>
                    </div>
                </a>
            </li>
            @endif

        @endforeach


        <div class="votes-page">
            <div class="page-btn prev {{ ($doc_list->currentPage() == 1) ? ' forbid' : '' }}">
                <a @if($doc_list->currentPage() != 1)href="{{ $doc_list->appends(['kwd' => Input::get('kwd'),'type' => Input::get('type'),'name' => Input::get('name')])->url($doc_list->currentPage()-1) }}&id={{ Input::get('id') }}"@endif>上一页</a>
            </div>
            <div class="page-num">{{ $doc_list->currentPage() }}/{{ ceil($doc_list->total()/config('home.pageNum')) }}</div>
            <div class="page-btn next {{ ($doc_list->currentPage() == $doc_list->lastPage()) ? ' forbid' : '' }}">
                <a @if($doc_list->currentPage() != $doc_list->lastPage())href="{{ $doc_list->appends(['kwd' => Input::get('kwd'),'type' => Input::get('type'),'name' => Input::get('name')])->url($doc_list->currentPage()+1) }}&id={{ Input::get('id') }}"@endif>下一页</a>
            </div>
        </div>

    </ul>
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

        $("#search_doc").on('keypress', function(e) {
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
                    window.location.href = '{{ route("home.vote.getLog" . Input::get('id')) }}?id={{ Input::get('id') }}&type={{ Input::get('type') }}&name={{ Input::get('name') }}&kwd=' + searchContent;
                }
            }
        });

    </script>

@endsection
