<section class="search_box clearfix box_hide" >
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
        <div class="msg_box box_hide"></div>
    </div>
    <div class="close_box search_close_box  box_hide"></div>
</section>

<section class="rule_box clearfix box_hide modal-box">
    <div class="rule_box_main clearfix modal-box-main">
        <div class="msg_box">
            <p><b>—&nbsp;活动背景&nbsp;—</b></p>
            <p> 
                为深入贯彻落实党的十九大精神、习近平总书记对四川系列重要指示精神和省市党代会精神，立足新的历史方位，以培育和践行社会主义核心价值观为根本，围绕坚持职业理想与追求，坚持行业自觉与定力，坚持自我改造与升华，市委宣传部、市文明办、市卫计委决定在全市展开首届“成都骄傲·大美医者”评选宣传活动，为成都建设全面体现新发展理念的城市，建设“健康成都”聚集卫计事业发展正能量。</p>
            <p style="margin-top: .3rem"><b>—&nbsp;活动规则&nbsp;—</b></p>
            <p>一．活动主题</p>
            <p>首届“成都骄傲 大美医者”网络票选</p>
            <p>主办单位：中共成都市委宣传部、成都市精神文明建设办公室、成都市卫生和计划生育委员会</p>
            <p>二．票选规则</p>
            <p>1.投票时间：7月12日7点至7月22日18点;</p>
            <p>2.投票同时在“健康成都官微”与“成都商报·四川名医”微信上进行，票选结果为两个平台票数总和；</p>
            <p>3.投票期间，每个ID每天可投五票（备注：可投给同一候选人，也可投给不同候选人）；</p>
            <p>4.投票结果将作为评委评审的参考依据之一。</p>
            <p>温馨提示：</p>
            <p>首届“成都骄傲·大美医者”网络票选阶段的投票通道，已于七月十二日上午七点正式开启。目前已有不少网络公司骚扰各单位。请各单位不要轻信刷票公司，谨防上当受骗。郑重提醒，本次投票活动严禁使用商业手段或通过其他不正当途径进行拉票、刷票的作弊行为，一经发现，将根据核查情况，清除使用商业手段或通过其他不正当途径所增加的票数。投票以官方公布的渠道为准。</p>
        </div>
    </div>
    <div class="close_box rule_box_close"></div>
</section>
<section class="report_box clearfix box_hide"> {{--风险报告--}}
    <div class="rule_box_main clearfix">
        <div class="msg_box">
            <p>马拉松是一项高负荷、大强度、长距离的竞技运动，也是一项高风险的竞技项目，对参赛者身体状况有较高的要求。参赛者应身体健康，有长期锻炼的基础。有以下身体状况者不宜参加比赛：</p>
            <p>1、先天性心脏病和风湿性心脏病；</p>
            <p>2、高血压和脑血管疾病；</p>
            <p>3、心肌炎和其他心脏病；</p>
            <p>4、冠状动脉病和严重心律不齐；</p>
            <p>5、血糖过高或过低的糖尿病；</p>
            <p>6、比赛日前两周以内患感冒；</p>
            <p>7、妊娠；</p>
            <p>8、其它不适合运动的疾病。</p>
        </div>
    </div>
    <div class="close_box rule_box_close" onclick="closeRules(this)"></div>
</section>
<section class="usual_box right_box clearfix box_hide">  {{--报名资格--}}
    <div class="rule_box_main clearfix">
        <div class="msg_box">
            <p><b>（一）参赛选手年龄要求：</b></p>
            <p>1、A组选手6岁及以下（含2012年5月1日出生者）；</p>
            <p>2、B组选手7岁至9岁（含2011年5月1日及2009年5月1日出生）；</p>
            <p>3、C组选手10岁-12岁（含2008年5月1日及2006年5月1日出生）；</p>
            <p>注意事项：18岁以下未成年人报名参加比赛，在赛前领取参赛物品时，须其监护人或法定代理人现场陪同，方可领取参赛物品并参加比赛。</p>
            <p><b>（二）参赛选手身体状况要求：</b></p>
            <p>马拉松是一项高负荷、大强度、长距离的竞技运动，也是一项高风险的竞技项目，对参赛者身体状况有较高的要求。参赛者应身体健康，有长期锻炼的基础。有以下身体状况者不宜参加比赛：</p>
            <p>1、先天性心脏病和风湿性心脏病；</p>
            <p>2、高血压和脑血管疾病；</p>
            <p>3、心肌炎和其他心脏病；</p>
            <p>4、冠状动脉病和严重心律不齐；</p>
            <p>5、血糖过高或过低的糖尿病；</p>
            <p>6、比赛日前两周以内患感冒； </p>
            <p>7、妊娠；</p>
            <p>8、其它不适合运动的疾病。</p>
        </div>
    </div>
    <div class="close_box rule_box_close" onclick="closeRules(this)">关闭</div>
</section>
{{--投票成功--}}
<div class="success-modal hide">
    <div class="alert-success-content">
        <div class="form-content mrg-t7">
            <div class="form-title">姓&nbsp;&nbsp;&nbsp;名</div>
            <input type="text" placeholder="请输入您的真实姓名" class="form-input" id="yizhen2-name">
        </div>
        <div class="form-content">
            <div class="form-title">手机号</div>
            <input type="number" placeholder="请输入您的手机号" class="form-input" id="yizhen2-phone">
        </div>
        <div class="alert-success-btn" onclick="closeSubmit()">确定</div>
    </div>
</div>
