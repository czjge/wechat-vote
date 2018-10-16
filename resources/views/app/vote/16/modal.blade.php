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
    <div class="rule_box_main clearfix">
        <div class="msg_box">
            <p><b>预签约规则</b></p>
            <p>签约家庭医生，立即拥有您专属的家庭私人医生。健康咨询、国家免费公共卫生服务、上级医院医疗绿色通道，通过家庭医生就能轻松获得！</p>
            <p>通过四川名医微信预签约渠道，只需要在手机上提交您的基本信息，我们将把信息通过成都市卫计委官方渠道，转交给您欲签约的社区卫生服务中心/乡镇卫生院，接下来就只需要等待家庭医生主动与您联系即可。</p>
            <p>您提交的所有信息均会妥善保密，敬请放心。</p>            
            <p>预签约方法：</p>
            <p>点击“搜索”，找到您欲签约的家庭医生团队，在其介绍页下方点击“预签约”，填写真实信息即可。</p>
        </div>
    </div>
    <div class="close_box rule_box_close">关闭</div>
</section>