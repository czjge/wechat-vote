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
            <p><b>—&nbsp;报名须知&nbsp;—</b></p>
            <p>1、评选对象： 本次评选活动面向全市所有医院主治医生及以上职称的医生。</p>
            <p>2、评选方式：根据成都商报四川名医对市民就医需求调查，按照病种、专科产生分榜，原则上每个榜单前十强同一家医院入选不超过30%。投票结果由市民投票（40%）+专家评审团投票（60%）组成，专家评审团拥有一票否决权。</p>
            <p>3、投票规则：每个微信号每天最多点赞5次，可为多位医生投票；每位医生每天得票数上限是1万票；服务器承载能力有限，如果出现投票过于集中，页面延迟，请稍后再试。</p>
            <p>4、为了助推“分级诊疗”的进行，每个榜单留出一定比例的名额给区县域基层医疗机构的医生。</p>
            <p>5、注意：评选期间，主办方将严格核查报名信息及投票数据，如若发现报名信息作假或刷票行为，一经查实，将立即取消评选资格。</p>
            <p>6、本轮报名时间：到2018年9月14日18:00截止。</p>
            <p>7、本活动最终解释权归成都商报四川名医所有，咨询电话：028-69982575。</p>
        </div>
    </div>
    <div class="close_box rule_box_close" onclick="closeRules()"></div>
</section>
<section class="rule_box clearfix box_hide modal-box act-rules-modal">
    <div class="rule_box_main clearfix modal-box-main">
        <div class="msg_box">
            <p><b>—&nbsp;活动规则&nbsp;—</b></p>
            <p>1、评选对象： 本次评选活动面向全市所有医院主治医生及以上职称的医生。</p>
            <p>2、评选方式：根据成都商报四川名医对市民就医需求调查，按照病种、专科产生分榜，原则上每个榜单前十强同一家医院入选不超过30%。投票结果由市民投票（40%）+专家评审团投票（60%）组成，专家评审团拥有一票否决权。</p>
            <p>3、投票规则：每个微信号每天最多点赞5次，可为多位医生投票；每位医生每天得票数上限是1万票；服务器承载能力有限，如果出现投票过于集中，页面延迟，请稍后再试。</p>
            <p>4、为了助推“分级诊疗”的进行，每个榜单留出一定比例的名额给区县域基层医疗机构的医生。</p>
            <p>5、注意：评选期间，主办方将严格核查报名信息及投票数据，如若发现报名信息作假或刷票行为，一经查实，将立即取消评选资格。</p>
            <p>6、本轮投票时间：2018年8月30日7:00开始，到2018年9月14日18:00截止。</p>
            <p>7、本活动最终解释权归成都商报四川名医所有，咨询电话：028-69982575。</p>
        </div>
    </div>
    <div class="close_box rule_box_close" onclick="closeRules()"></div>
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
