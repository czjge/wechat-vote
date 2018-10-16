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
            <p><b>—&nbsp;活动规则&nbsp;—</b></p>
            <p>活动时间：2018年7月23日-2018年8月1日。</p>
            <p>活动方式：每人每天有5次点赞权利。</p>
            <p>活动奖品：参与点赞的用户，将在活动时间结束后，从中抽取20位幸运者，赠送智能手环一个，影响人数最多的三位医生将获得《2018最具公益影响力控烟大使称号》</p>
        </div>
    </div>
    <div class="close_box rule_box_close" onclick="closeRules()"></div>
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
    <div class="close_box rule_box_close" onclick="closeRules(this)">关闭</div>
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
