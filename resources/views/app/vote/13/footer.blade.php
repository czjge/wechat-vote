<!-- footer start-->
<section class="footer_block clearfix "></section>
<footer class="footer_main clearfix">
    <ul class="clearfix">
        <li class="footer_nav_index"><a href="{{ route('home.vote.getIndex') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}&type=0"><span class="nav">首页</span></a></li>
        <li class="footer_nav_search"><a href="javascript:void(0);"><span class="nav">搜索</span></a></li>
        <li class="footer_nav_ph"><a href="{{ route('home.vote.getRank') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}"><span class="nav">排行榜</span></a></li>
        <li class="footer_nav_gz"><a href="javascript:void(0);" onclick="showShareGuide();"><span class="nav">关注</span></a></li>
    </ul>
</footer>
<!-- footer end-->
