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
<p class="rule-box-title" style="text-align: center; margin-top: 10px;" ><b style="font-size:32px;">院长拜年送祝福，四川名医发红包！</b></p>
<p>2018新年即将到来，四川名医联合全川医院20多名院长特别推出“2018·院长拜年”活动！</p>

<p>本次活动，四川名医将邀请到四川大学华西医院、四川省肿瘤医院等20多家医院院长为大家送新春祝福，四川名医为了回馈粉丝，也将在春节期间为大家发放新春红包！</p>

<p><b>活动时间：</b><br>2月12日—2月14日，院长给您送祝福！<br>2月15日—2月22日，四川名医每天发红包！发完即止</p>

<p>注：本次活动最终解释权由成都商报四川名医所有。</p>

    <div class="close_box rule_box_close">关闭</div>
</section>