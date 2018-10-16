<section class="search_box clearfix box_hide">
    <div class="search_box_main clearfix">
        <div class="form_box">
            <form action="{{ route('home.vote.getIndex'.\Illuminate\Support\Facades\Input::get('id')) }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}" id="search_form" method="get">
                <table width="100%">
                    <tr>
                        <input type="hidden" name="id" value="{{ \Illuminate\Support\Facades\Input::get('id') }}"/>
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
<section class="rule_box clearfix box_hide">
    <div class="rule_box_main clearfix" style=" max-height: 1000px;overflow: scroll;">
        <div class="msg_box" style="padding:40px 30px;">
<p class="rule-box-title" style="text-align: center; margin-top: 10px;" ><b style="font-size:32px;">评选规则</b></p>
<p>本次活动由四川大学华西医院主办，成都商报社、成都商报四川名医协办。</p>

<p>此次活动将展示26首由华西医院的医务人员、后勤工作者创作的歌曲，由大众对其进行投票。11月2日晚举办的“唱响华西 原创健康音乐大赛”中，将通过前期投票评选出5名最具人气奖。</p>

<p><b>投票方式：</b>页面上点击“为他投票”即可对您中意的歌曲投上宝贵的一票，若有问题，请联系：028-86780845（工作日），每人每天5票</p>
<p><b>投票阶段：</b>10月25日晚6点-11月2日晚</p>

<p>本次活动最终解释权由四川大学华西医院工会、成都商报社、成都商报四川名医所有。</p>


    <div class="close_box rule_box_close">关闭</div>
</section>