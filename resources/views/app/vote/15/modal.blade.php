<section class="search_box clearfix box_hide">
    <div class="search_box_main clearfix">
        <div class="form_box">
            <form action="{{ route('home.vote.getRank'.Input::get('id')) }}?id={{ Input::get('id') }}" id="search_form" method="get">
                <table width="100%">
                    <tr>
                        <input type="hidden" name="id" value="{{ \Illuminate\Support\Facades\Input::get('id') }}"/>
                        <input type="hidden" name="type" value="1"/>
                        <td width=""><input class="input_class" type="text" name="keywords" placeholder="请输入名称搜索"/></td>
                        <td width="140">
                            <input class="a_class id_search_btn" type="submit" value="搜索">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div class="msg_box"></div>
    </div>
    <div class="close_box search_close_box"></div>
</section>

<section class="count_down_box clearfix box_hide">
    <div class="count_down_main clearfix">
        <div class="count_down">
            活动开始还有<span id="_t_d"></span>天 <span id="_t_h"></span>小时 <span id="_t_m"></span>分钟
        </div>
    </div>
    <div class="close_box count_down_close_box"></div>
</section>

<section class="rule_box clearfix box_hide">
    <div class="rule_box_main clearfix">
        <div class="msg_box">

            <p><b>评选规则</b></p>
            <p>成都商报、成都商报四川名医启动四川“百强金口碑药店”评选活动，邀请成都市民共同打造全国首张特色的“寻药地图”。该地图将收集全成都所有药店信息，方便市民“一键导航”来进行选择。汇聚市民口碑共同评选出药店中的“金口碑药店”，金口碑药店将享有全方位展示药店信息以及优惠活动的权益，便于市民优先来进行选择。</p>
            <p>即日起，金口碑药店面向全社会开放报名通道，扫描二维码关注“成都商报四川名医”微信公众号，在公众号底部菜单栏中点击“药店评选”，即可报名参加。</p>
            <p>报名方式：页面上点击“征集通道”，即可在线上传参评药店的资料，提交审核过后可以在评选平台显示。若有药店连锁企业批量上传资料，欢迎联系cdsbscmy@sina.com，或咨询热线028-69982575（工作日）、18583795519。</p>            
            <p class="box_hide">报名条件：凡在成都市已取得《药品经营许可证》和《药品经营质量管理规范认证证书》，并正常经营的零售药店（连锁门店），均可申报参加，报名截止日期为7月23日。</p>
			
			<p><b>活动流程</b></p>
            <p>征集阶段：7月17日—7月23日</p>
            <p>评选阶段：7月24日—8月上旬<br>评选平台启动网络投票，市民可登录评选平台，为心目中的“金口碑”药店投上支持的一票，我们将网络票选结果报请监管部门以及行业协会来进行把关。</p>
            <p>公示阶段： 9月<br>公示阶段结束后，我们将在已拥有百万用户的“成都商报四川名医”微信公众号推出“药店地图”功能，开启市民寻药新方式。</p>

        </div>
    </div>
    <div class="close_box rule_box_close">关闭</div>
</section>