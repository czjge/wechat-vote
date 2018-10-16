@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

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
    <div class="choose-content">
        <div class="choose-btn active">{{--<div class="btn-circle left"></div>--}}专科专病榜{{--<div class="btn-circle right"></div>--}}</div>
        <div class="choose-btn" id="yybd">医院榜单</div>
        <div class="choose-btn" id="ysbd">医生榜单</div>
    </div>
    <div class="tab-board clearfix">
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
                            <div class="dept-right">{{ $dep_item->dep_total_num }}<i class="icon-arrorwy"></i> </div>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
        <div class="tab-board-content" style="display: none">
            <div class="search-content clearfix">
                <div class="se-icon"></div>
                <input class="se-input" type="search" placeholder="搜索医院" id="search_hos" value="@if(1 == Input::get('type')) {{ Input::get('kwd') }} @endif">
            </div>

            @if(count($hos_list) > 0)

                @if(isset($hos_list[0]))
                <a href="{{ route('home.vote.getLog'.Input::get('id')) }}?id={{ Input::get('id') }}&type=3&name={{ $hos_list[0]->hos_name }}" class="first-hos">
                    <div class="first-hos-img"><img src="{{ $hos_list[0]->hos_logo }}"> </div>
                    <div class="first-hos-info clearfix">
                        <div class="hos-name ellipsis">{{ $hos_list[0]->hos_name }}</div>
                        <div class="hos-label">{{ $hos_list[0]->hos_level }}</div>
                    </div>
                    <div class="first-hos-info">
                        <div class="hos-detail">科室&nbsp;{{ $hos_list[0]->dep_num }}<span>医生&nbsp;{{ $hos_list[0]->doc_num }}</span></div>
                    </div>
                    <div class="icon-royal fst-royal"></div>
                </a>
                @endif

                @if(isset($hos_list[1]))
                <a href="{{ route('home.vote.getLog'.Input::get('id')) }}?id={{ Input::get('id') }}&type=3&name={{ $hos_list[1]->hos_name }}" class="first-hos">
                    <div class="first-hos-img"><img src="{{ $hos_list[1]->hos_logo }}"> </div>
                    <div class="first-hos-info clearfix">
                        <div class="hos-name ellipsis">{{ $hos_list[1]->hos_name }}</div>
                        <div class="hos-label">{{ $hos_list[1]->hos_level }}</div>
                    </div>
                    <div class="first-hos-info">
                        <div class="hos-detail">科室&nbsp;{{ $hos_list[1]->dep_num }}<span>医生&nbsp;{{ $hos_list[1]->doc_num }}</span></div>
                    </div>
                    <div class="icon-royal sec-royal"></div>
                </a>
                @endif

                @if(isset($hos_list[2]))
                <a href="{{ route('home.vote.getLog'.Input::get('id')) }}?id={{ Input::get('id') }}&type=3&name={{ $hos_list[2]->hos_name }}" class="first-hos">
                    <div class="first-hos-img"><img src="{{ $hos_list[2]->hos_logo }}"> </div>
                    <div class="first-hos-info clearfix">
                        <div class="hos-name ellipsis">{{ $hos_list[2]->hos_name }}</div>
                        <div class="hos-label">{{ $hos_list[2]->hos_level }}</div>
                    </div>
                    <div class="first-hos-info">
                        <div class="hos-detail">科室&nbsp;{{ $hos_list[2]->dep_num }}<span>医生&nbsp;{{ $hos_list[2]->doc_num }}</span></div>
                    </div>
                    <div class="icon-royal thd-royal"></div>
                </a>
                @endif

            @endif

            <ul class="bill-board clearfix">

                @for($i=3 ; $i < count($hos_list) ; $i++)
                <li>
                    <a href="{{ route('home.vote.getLog'.Input::get('id')) }}?id={{ Input::get('id') }}&type=3&name={{ $hos_list[$i]->hos_name }}">
                        <div class="hos-img"><img src="{{ $hos_list[$i]->hos_logo }}"> </div>
                        <div class="hos-info clearfix">
                            <div class="hos-name ellipsis">{{ $hos_list[$i]->hos_name }}</div>
                            <div class="hos-detail">科室&nbsp;{{ $hos_list[$i]->dep_num }}<span>医生&nbsp;{{ $hos_list[$i]->doc_num }}</span></div>
                            <div class="hos-label">{{ $hos_list[$i]->hos_level }}</div>
                        </div>
                    </a>
                </li>
                @endfor

            </ul>
        </div>
        <div class="tab-board-content" style="display: none">
            {{--<div class="search-content clearfix">--}}
                {{--<div class="se-icon"></div>--}}
                {{--<input class="se-input" type="search" placeholder="搜索医生" id="search_doc" value="@if(3 == Input::get('type')) {{ Input::get('kwd') }} @endif">--}}
            {{--</div>--}}
            <ul class="record-content">

                @foreach($doc_list as $key => $doc_item)
                <li>
                    <a href="{{ route('home.vote.getInfo'.Input::get('id'), ['cid' => $doc_item->doc_id]) }}?id={{ Input::get('id') }}">
                        <div class="record-num">
                            <div class="number"><?php if($key<9){echo 0;}?>{{ $key+1 }}</div>
                            <div class="label">top</div>
                        </div>
                        <div class="record-img"><img src="@if(''==$doc_item->doc_avatar) {{ $qiniu_cdn_path }}/images/default_doc_avatar.jpg @elseif(false !== strpos($doc_item->doc_avatar, 'https')) {{ $doc_item->doc_avatar }} @else {{ $qiniu_cdn_path }}/storage/{{ $doc_item->doc_avatar }} @endif"> </div>
                        <div class="record-info">
                            <div class="record-detail ellipsis"><span>{{ $doc_item->doc_name }}</span>{{ $doc_item->dep_name }}</div>
                            <div class="record-hos ellipsis">{{ $doc_item->hos_name }}</div>
                        </div>
                    </a>
                </li>
                @endforeach

            </ul>
        </div>
    </div>
    <div style="height: 50px"></div>
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
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
    <script>
        // 搜索医院榜单默认显示
        var searchType = '{{ Input::get('type') }}';
        if (1 == searchType) {
            $('#yybd').addClass('active').siblings().removeClass('active');
            $('.tab-board .tab-board-content').eq(1).show().siblings().hide();
        }
        //榜单切换
        $('.choose-btn').click(function () {
            var i = $(this).index();
            $(this).addClass('active').siblings().removeClass('active');
            $('.tab-board .tab-board-content').eq(i).show().siblings().hide();
        });
        //搜索
        $("#search_hos").on('keypress', function(e) {
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
                    window.location.href = '{{ route("home.vote.getRank" . Input::get('id')) }}?id={{ Input::get('id') }}&type=1&kwd=' + searchContent;
                }
            }
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
                    window.location.href = '{{ route("home.vote.getRank" . Input::get('id')) }}?id={{ Input::get('id') }}&type=2&kwd=' + searchContent;
                }
            }
        });
    </script>
@endsection
