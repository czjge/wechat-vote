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
    <div class="close_box search_close_box hide"></div>
</section>

<section class="rule_box clearfix box_hide modal-box">
    <div class="rule_box_main clearfix modal-box-main">
        <div class="msg_box">
            <p><b>—&nbsp;报名规则&nbsp;—</b></p>
            <p>一、活动报名：</p>
            <p>1.报名通道：在【四川消防119】微信公众号上开启活动报名通道。</p>
            <p>2.报名要求：以家庭为单位，一个家庭最少2个成员参与体验；参与竞赛的家庭必须为3人，即父母2名+儿童1名，儿童年龄要求6~16岁之间。</p>
            <p>3.家庭合影照片一张。</p>
            <p>4.家庭消防理念一条（50字以内）。</p>
            <p>5.上午总决赛结束后，下午安排所有参赛队伍组织参观“成都防灾减灾教育馆”和“成都搜救犬基地”。</p>
            <p>注：此流程为全省总决赛竞赛流程。各市区县大队在组织选拔活动中，可参考此流程，根据自身场地和器材情况自行组织。</p>
            <p>二、活动参与对象：</p>
            <p>活动地点：预选-全省各消防大队、支队</p>
            <p>总决赛-成都</p>
            <p>主办单位：四川省消防总队 </p>
        </div>
    </div>
    <div class="close_box rule_box_close" onclick="closeRules()"></div>
</section>
<section class="report_box clearfix box_hide modal-box"> {{--风险报告--}}
    <div class="rule_box_main clearfix modal-box-main">
        <div class="msg_box">
            <p><b>—&nbsp;活动规则&nbsp;—</b></p>
            <p>1.网络投票对象：所有参赛家庭</p>
            <p>2.网络投票时间：10月21日~11月5日</p>
            <p>3.参与方式：通过网络报名平台报名参加</p>
            <p>4.投票规则：每人每天可投5票；投票结束后，得票最高的前10组家庭获得“我们都是消防员”网络人气大奖</p>
            <p>奖项设置：神秘大奖一份</p>
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
        <div class="alert-success-info">投票成功！</div>
        <div class="alert-success-btn" onclick="closeModal()">确定</div>
    </div>
</div>
