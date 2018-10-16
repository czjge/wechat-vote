<section class="search_box clearfix box_hide">
    <div class="search_box_main clearfix">
        <div class="form_box">
            <form action="{{ route('home.vote.getIndex') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}" id="search_form" method="get">
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

<section class="count_down_box clearfix box_hide">
    <div class="count_down_main clearfix">
        <div class="count_down">
            活动开始还有<span id="_t_d"></span>天 <span id="_t_h"></span>小时 <span id="_t_m"></span>分钟
        </div>
    </div>
    <div class="close_box count_down_close_box"></div>
</section>