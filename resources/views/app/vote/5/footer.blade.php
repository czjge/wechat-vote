<!-- footer start-->
<section class="footer_block clearfix "></section>
<footer class="footer_main clearfix">
    <ul class="clearfix">
        <li class="footer_nav_index active"><a href="{{ route('home.vote.getIndex'.Input::get('id')) }}?id={{ Input::get('id') }}&type=0"><span class="nav">首页</span></a></li>
        <li class="footer_nav_zj box_hide"><a href="{{ route('home.vote.getIndex'.Input::get('id')) }}?id={{ Input::get('id') }}"><span class="nav">专家评审</span></a></li>
        <li class="footer_nav_ph"><a href="{{ route('home.vote.getRank'.Input::get('id')) }}?id={{ Input::get('id') }}&type=2"><span class="nav">十强榜</span></a></li>
        <li class="footer_nav_gz"><a href="{{ route('home.vote.getLog'.Input::get('id')) }}?id={{ Input::get('id') }}"><span class="nav">投票记录</span></a></li>
        <li class="footer_nav_search"><a href="javascript:void(0);"><span class="nav">搜索</span></a></li>
        <li class="footer_nav_gz2 box_hide"><a href="javascript:void(0);" onclick="showShareGuide();"><span class="nav">我们</span></a></li>
    </ul>
</footer>
<script>
</script>
<div style="display: none;"><script src="https://s19.cnzz.com/z_stat.php?id=1264495785&web_id=1264495785" language="JavaScript"></script></div>
<!-- footer end-->
