<section class="search_box clearfix box_hide">
    <div class="search_box_main clearfix">
        <div class="form_box">
            <form action="{{ route('home.vote.getIndex'.\Illuminate\Support\Facades\Input::get('id')) }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}" id="search_form" method="get">
                <table width="100%">
                    <tr>
                        <input type="hidden" name="id" value="{{ \Illuminate\Support\Facades\Input::get('id') }}"/>
                        <td width=""><input class="input_class" type="text" name="keywords" placeholder="请输入名称或者医院搜索"/></td>
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
            <p>本次评选活动由成都商报社、成都商报四川名医主办，四川省中医药学会儿科专委会、成都中医药学会(中医儿科专业委员会)指导。</p>

            <p>该活动将聚焦儿童冬季常见病，以呼吸内科疾病为主，邀请全成都最知名的西医、中医儿科专家，联手打造儿童冬季常见病的“就诊地图”，汇聚专家以及家长口碑来开启“成都金口碑儿科医生”的评选活动。</p>
            <p><b>一、评选对象</b><br>公立三级医院涉及冬季儿童常见病相关专业的中青年儿科医生、优质民营医疗机构以及基层医疗机构的儿科医生，包含中医及西医的医生。</p>

            <p><b>二、评选阶段</b><br>
            （一）征集阶段(1月16日——1月17日24点)<br>
             征集方式：请将推荐医生的姓名、所属医院、职称、擅长领域、坐诊时间、照片等资料发到指定邮箱:scmy@scmingyi.com。<br><br>
            （二）投票阶段(1月18日8点——1月26日24点)<br>
             投票方式：微信关注“成都商报四川名医”，点击底部菜单栏“金口碑儿科”进入页面后，点击“给Ta投票”即可对您信任的医生投上宝贵的一票，每人每天5票。<br><br>
            （三）专家评审阶段(1月27日—2月1日)</p>

            <p><b>三、评选规则</b><br>
            网络投票占比40%，专家评审占比60%，中医/西医得分最高的前10名获选“金口碑中医儿科新锐十强/金口碑西医儿科新锐十强”</p><br>


            若有问题，请联系：028-86780845(工作日)，本次活动最终解释权由成都商报社、成都商报四川名医所有。
        </div>
     </div>   
    <div class="close_box rule_box_close">关闭</div>
</section>
