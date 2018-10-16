<!-- footer start-->
<section class="footer_block clearfix "></section>
<footer class="footer_main clearfix">
    <ul class="clearfix">
        <li><a href="{{ route('home.vote.getIndex'.Input::get('id')) }}?id={{ Input::get('id') }}"><div class="icon-img-f icon-home"></div> <span class="nav">首页</span></a></li>
        <li><a href="{{ route('home.vote.getRank'.Input::get('id')) }}?id={{ Input::get('id') }}"><div class="icon-img-f icon-rank"></div><span class="nav">十强榜</span></a></li>
        <li><a href="{{ route('home.vote.getLog'.Input::get('id')) }}?id={{ Input::get('id') }}"><div class="icon-img-f icon-rule"></div><span class="nav">点赞记录</span></a></li>
        <li class="footer-search"><a href="javascript:void(0);"><div class="icon-img-f icon-search"></div><span class="nav">搜索</span></a></li>
        <li class="footer_nav_gz" style="opacity: 0"><a href="javascript:void(0);" onclick="showShareGuide();"><div class="icon-img-f icon-we"></div><span class="nav">我们</span></a></li>
    </ul>
</footer>
<div style="display: none;"><script src="https://s13.cnzz.com/z_stat.php?id=1261966094&web_id=1261966094" language="JavaScript"></script></div>
<!-- footer end-->
