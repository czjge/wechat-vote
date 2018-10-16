@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/newstyle2.css?v=2" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/potential.css" rel="stylesheet" type="text/css">
    <style>
        .box_select{
            margin-top: 30px;
        }
        .mzy-phb .list_item .head-img{
            left: 85px;
        }
        .mzy-phb .list_item .title {
            left: 195px;
            width: 340px;
        }
        .list_item .title .xm {
            font-size: 28px;
            margin-right: 0;
        }
        .mzy-phb .list_item .title .title-first {
            margin-top: 22px;
        }
        .mzy-phb .list_item .ps {
            width: 160px;
            right: 0px;
            font-weight: normal;
        }
        .mzy-phb .list_item .ps .num {
            padding-right: 0px;
        }
        .mzy-phb .list_item .pm{
            font-size: 28px;
            padding: 5px 12px;
        }
        .mzy-phb .list_item:nth-child(1) .pm, .mzy-phb .list_item:nth-child(2) .pm,.mzy-phb .list_item:nth-child(3) .pm {
            background: #ef4d3e;
        }
        .index_section {
            color: #896a39;
        }
        .select_section_2 {
            background: transparent;
            margin-bottom: -30px;
            margin-top: 0;
        }
        .rank-img{
            position: relative;
        }
        .rank-img img{
            position: absolute;
        }
        .rank-wid400 .rank-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 385px;
            text-align: left;
        }
        .rank-name.font-s26.rank-name-ks{
            max-width: 160px;
            text-align: left;
        }
        .rank-name.font-s26.rank-name-yy{
            max-width: 250px;
        }
    </style>
@endsection

@section('content')
    <section class="top_box position-r">
        <div class="top-bg"><img src="{{ $qiniu_cdn_path }}/images/vote/2/bg2.jpg" width="100%"></div>
        <div style="width: 100%;height: 90px;"></div>
        <div class="clear" ><span class="top-rank-title">{{ $title }}</span></div>
        <a class="top-search position-r">
            <i class="top-search-icon search-icon"></i>
            <form action="" method="get">
                <input type="text" class="top-search-input" placeholder="搜索医院、医生">
                <button class="search-btn" type="submit">搜索</button>
                <input type="hidden" id="searchUrl" value="{{ route('home.vote.getRank'.$id).'?id='.Input::get('id').'&type='.Input::get('type').'&disease='.Input::get('disease').'&hospital_id='.Input::get('hospital_id') }}">
            </form>
        </a>
    </section>

    <section>
        <div class="section-content">
            <ul class="list-block pad20 clear" style="width: 100%">

                @if ($type==0)

                    @foreach ($retval as $item)
                        <li class="clear">
                            <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$item->id]).'?id='.$id.'&type=0' }}" class="clear">
                                <div class="left-sec-con wid-auto">
                                    <div class="rank-img wid-small"><img src="<?php if($item->doctor_avatar==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$item->doctor_avatar;}?>" ></div>
                                </div>
                                <div class="left-sec-con wid-auto mrg-t20">
                                    <span class="rank-name">{{ $item->doctor_name }}</span><span class="rank-name rank-name-ks font-s26">{{ $item->doctor_title }}</span>
                                </div>
                                <div class="right-sec-con mrg-t24">
                                    <span class="rank-name rank-name-yy font-s26">{{ $item->hospital }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else

                    @if (Input::get('page')==1||Input::get('page')==null)

                        @if (count($retval)>10)
                            @for ($i = 0; $i < 10; $i++)
                                <li class="clear">
                                    <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$retval[$i]->id]).'?id='.$id.'&type=1' }}" class="clear">
                                        <div class="left-sec-con wid-auto"><span class="rank-num">{{ $i+1 }}</span><span class="rank-top">top</span></div>
                                        <div class="left-sec-con wid-auto"><div class="rank-img"><img src="<?php if($retval[$i]->doctor_avatar==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$retval[$i]->doctor_avatar;}?>" ></div> </div>
                                        <div class="left-sec-con wid-auto">
                                            <div class="clear rank-wid400 mrg-t20">
                                                <span class="rank-name">{{ $retval[$i]->doctor_name }}</span><span class="rank-name font-s26">{{ $retval[$i]->doctor_title }}</span>
                                            </div>
                                            <div class="clear rank-wid400 mrg-t10">
                                                <span class="rank-name font-s28">{{ $retval[$i]->hospital }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endfor
                            @for ($i = 10; $i < count($retval); $i++)
                                <li class="clear position-r">
                                    <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$retval[$i]->id]).'?id='.$id.'&type=1' }}" class="clear">
                                        <div class="left-sec-con wid-auto">
                                            <div class="rank-img wid-small"><img src="<?php if($retval[$i]->doctor_avatar==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$retval[$i]->doctor_avatar;}?>" ></div>
                                            @if ($retval[$i]->is_recommend==1)<div class="rank-recommend">同行推荐</div>@endif
                                        </div>
                                        <div class="left-sec-con wid-auto mrg-t20">
                                            <span class="rank-name">{{ $retval[$i]->doctor_name }}</span><span class="rank-name rank-name-ks font-s26">{{ $retval[$i]->doctor_title }}</span>
                                        </div>
                                        <div class="right-sec-con mrg-t24">
                                            <span class="rank-name rank-name-yy font-s26">{{ $retval[$i]->hospital }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endfor
                        @else
                            @foreach ($retval as $key => $item)
                                <li class="clear">
                                    <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$item->id]).'?id='.$id.'&type=1' }}" class="clear">
                                        <div class="left-sec-con wid-auto"><span class="rank-num">{{ $key+1 }}</span><span class="rank-top">top</span></div>
                                        <div class="left-sec-con wid-auto"><div class="rank-img"><img src="<?php if($item->doctor_avatar==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$item->doctor_avatar;}?>" ></div> </div>
                                        <div class="left-sec-con wid-auto">
                                            <div class="clear rank-wid400 mrg-t20">
                                                <span class="rank-name">{{ $item->doctor_name }}</span><span class="rank-name font-s26">{{ $item->doctor_title }}</span>
                                            </div>
                                            <div class="clear rank-wid400 mrg-t10">
                                                <span class="rank-name font-s28">{{ $item->hospital }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        @endif

                    @else

                        @for ($i = 0; $i < count($retval); $i++)
                            <li class="clear position-r">
                                <a href="{{ route('home.vote.getInfo'.$id, ['cid'=>$retval[$i]->id]).'?id='.$id.'&type=1' }}" class="clear">
                                    <div class="left-sec-con wid-auto">
                                        <div class="rank-img wid-small"><img src="<?php if($retval[$i]->doctor_avatar==''){echo $qiniu_cdn_path.'/images/default_doc_avatar.jpg';}else{echo 'http://qiniu.langzoo.com'.$retval[$i]->doctor_avatar;}?>" ></div>
                                        @if ($retval[$i]->is_recommend==1)<div class="rank-recommend">同行推荐</div>@endif
                                  </div>
                                    <div class="left-sec-con wid-auto mrg-t20">
                                        <span class="rank-name">{{ $retval[$i]->doctor_name }}</span><span class="rank-name rank-name-ks font-s26">{{ $retval[$i]->doctor_title }}</span>
                                    </div>
                                    <div class="right-sec-con mrg-t24">
                                        <span class="rank-name rank-name-yy font-s26">{{ $retval[$i]->hospital }}</span>
                                    </div>
                                </a>
                            </li>
                        @endfor

                    @endif




                @endif

            </ul>
        </div>
    </section>
    @if ($type==0)
    <section class="select_section_2 index_section">
        <p style="margin-top:0;">以上均按姓氏排列</p>
    </section>
    @endif
    <section class="select_section">
        <section class="list_box clearfix show" id="doctor_list">
            <div id="list_box">
            </div>
            <div class="pages clearfix">
                {!! $paginator->appends([
                    'id' => Input::get('id'),
                    'keywords' => Input::get('keywords'),
                    'type' => Input::get('type'),
                    'hospital_id' => Input::get('hospital_id'),
                    'disease' => Input::get('disease'),
                ])->render(new App\Extensions\boolawuiThreePresenter($paginator)) !!}
            </div>
        </section>
    </section>
   
@endsection

@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script type="application/javascript">

        $(document).on("click", ".search-btn", function(){
            if($(".top-search-input").val()){
                document.location.href = $('#searchUrl').val() + "&keywords=" + $(".top-search-input").val();
            }
            return false;
        })

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
