<!-- footer start-->
<section class="footer_block clearfix "></section>
<footer class="footer_main clearfix">
    <ul class="clearfix">
        <li><a href="{{ route('home.vote.getIndex'.Input::get('id')) }}?id={{ Input::get('id') }}"><div class="icon-img icon-home"></div> <span class="nav">首页</span></a></li>
        <li><a href="{{ route('home.vote.getTheme2'.Input::get('id')) }}?id={{ Input::get('id') }}"><div class="icon-img icon-judge"></div><span class="nav">评审团</span></a></li>
        <li class="footer-search"><a href="javascript:void(0);"><div class="icon-img icon-search"></div><span class="nav">搜索</span></a></li>
        <li><a href="{{ route('home.vote.getRank'.Input::get('id')) }}?id={{ Input::get('id') }}"><div class="icon-img icon-rank"></div><span class="nav">排行</span></a></li>
        <li><a href="{{ route('home.vote.getTheme1'.Input::get('id')) }}?id={{ Input::get('id') }}"><div class="icon-img icon-theme"></div><span class="nav">专科专病</span></a></li>
        <li class="footer_nav_gz" style="opacity: 0"><a href="javascript:void(0);" onclick="showShareGuide();"><div class="icon-img icon-we"></div><span class="nav">我们</span></a></li>
    </ul>
</footer>
<div style="display: none;"><script src="https://s19.cnzz.com/z_stat.php?id=1274546610&web_id=1274546610" language="JavaScript"></script></div>
<!-- footer end-->
