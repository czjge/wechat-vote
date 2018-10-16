<!-- footer start-->
<section class="footer_block clearfix "></section>
<footer class="footer_main clearfix">
    <ul class="clearfix">
        <li class="footer_nav_index"><a href="{{ route('home.vote.getIndex'.Input::get('id')) }}?id={{ Input::get('id') }}"><span class="nav">首页</span></a></li>
        <li class="footer_nav_search"><a href="javascript:void(0);"><span class="nav">搜索</span></a></li>
        <li class="footer_nav_ph"><a href="<?php
                                                if (strtotime($vote->start_time) > time()) {
                                                    echo "javascript:tusi('报名阶段暂不开放')";
                                                } else {
                                                    echo route('home.vote.getRank'.Input::get('id')).'?id='.Input::get('id');
                                                }
                                            ?>"><span class="nav">排行榜</span></a></li>
        <li class="footer_nav_gz"><a href="javascript:void(0);" onclick="showShareGuide();"><span class="nav">我们</span></a></li>
    </ul>
</footer>
<!-- footer end-->