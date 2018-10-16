@extends('layouts.home2')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="https://qiniu.scmingyi.com/mp_vote/public/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <link href="https://qiniu.scmingyi.com/mp_vote/public/css/vote/{{ $vote->id }}/register.css" rel="stylesheet" type="text/css">
    <style>
        /** 提示 **/
.lock_box{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 9999999;
    color: #999;
    height: 100%;
}

.lock_box_main {
    /* min-height: 500px; */
    width: 420px;
    background: #fff;
    /* line-height: 40px; */
    margin-left: 165px;
    margin-top: 400px;
    border-radius: 20px;
    /* border: solid #9ec1f5 10px; */
    text-align: center;
    padding: 20px 0;
}
.lock_box .msg_box{
    text-align: center;
    margin-top: 10px;
}
    </style>
@endsection

@section('content')

    <header class="header_style clearfix">
        <a href="https://mp.scmingyi.com/vote/index?id=16&type=0"></a>
        <h1>报名</h1>
    </header>

    {{--<section class="add_top_box clearfix">--}}
        {{--<a href="">如果已报名，点此登陆</a>--}}
    {{--</section>--}}

    <section class="add_form_box clearfix">
        <div class="add_form_box_main clearfix">
        <div class="box_select">
            <a class="active" name="doc">家庭医生</a>
            <a name="hos">医院</a>
        </div>

            <form id="regFrom_doc" method="post" enctype="multipart/form-data" name="doc">
                <input type="hidden" name="id" value="{{ $vote->id }}"/>
                <input type="hidden" name="type" value="0"/>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="30%">
                            <label class="c1">团队联系人</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="name" id="name" />            
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label class="c1">联系人手机</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="tel" id="tel" />            
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label class="c1">医院名称</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="of_hospital" id="of_hospital" />
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="30%"><label class="c1">所属区县</label></td>
                        <td>
                            <select class="input_class" name="title" id="_rank">
                                <option value="1">锦江区</option>
                                <option value="2">青羊区</option>
                                <option value="3">金牛区</option>
                                <option value="4">武侯区</option>
                                <option value="5">成华区</option>
                                <option value="6">高新区</option>
                                <option value="7">天府新区</option>
                                <option value="8">龙泉驿区</option>
                                <option value="9">青白江区</option>
                                <option value="10">新都区</option>
                                <option value="11">温江区</option>
                                <option value="12">双流区</option>
                                <option value="13">都江堰市</option>
                                <option value="14">彭州市</option>
                                <option value="15">邛崃市</option>
                                <option value="16">崇州市</option>
                                <option value="17">金堂县</option>
                                <option value="18">郫县</option>
                                <option value="19">大邑县</option>
                                <option value="20">浦江县</option>
                                <option value="21">新津县</option>
                                <option value="22">简阳市</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label class="c1">团队名称</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="of_dep" id="of_dep" />
                        </td>
                    </tr>

                    <tr>
                        <td><label class="c1">介绍</label></td>
                        <td><textarea class="textarea_class" name="desc" id="desc"></textarea></td>
                    </tr>

                    <tr>
                        <td>
                            <label class="c1">团队照片</label>
                        </td>
                        <td>
                            <input type="file" name="file_doc" id="file_doc" class="file_class" accept="image/*" capture="camera" />
                            <input type="hidden" name="picurl" id="picurl_doc">
                            <span id="picSpanDoc"></span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label class="c1">团队照片2</label>
                        </td>
                        <td>
                            <input type="file" name="file_doc2" id="file_doc2" class="file_class" accept="image/*" capture="camera" />
                            <input type="hidden" name="picurl2" id="picurl_doc2">
                            <span id="picSpanDoc2"></span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="height:auto; padding:20px;">
                            <label class="c3" style="line-height:35px;color: #949090;">（头像图片大小不超过{{ $vote->photo_size/1024/1024 }}M，宽度大于660px，宽高比例16:10最佳）</label>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" style="height:auto; padding:20px;">
                            <label class="c3" style="line-height:35px;color: #949090;text-align: left;">
                            1、请先检查您的图片是否大于5M。<br>
                            2、如果无法正常提交，请在电脑浏览器上输入<a href="http://www.langzoo.com/demo.xlsx">www.langzoo.com/demo.xlsx</a>下载报名表，填写相关内容，并附上照片2张，发送至邮箱zhoujie@scmingyi.com。<br>
                            3、报名后需审核才会显示，请等待！
                            </label>
                        </td>
                    </tr>
                </table>
                <input  class="doc_add_form_btn btn_class" type="button" value="提交" />
            </form>

            <form id="regFrom_hos" method="post" enctype="multipart/form-data" name="hos" style="display: none;">
                <input type="hidden" name="id" value="{{ $vote->id }}"/>
                <input type="hidden" name="type" value="1"/>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="30%"><label class="c1">医院名称</label></td>
                        <td><input type="text" class="input_class" name="of_hospital" id="_name" /></td>
                    </tr>

                    <tr>
                        <td width="30%"><label class="c1">医院类型</label></td>
                        <td>
                            <select class="input_class" name="rank" id="_rank">
                                <option value="1">社区卫生服务中心</option>
                                <option value="2">乡镇卫生院</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="30%"><label class="c1">所属区县</label></td>
                        <td>
                            <select class="input_class" name="title" id="_rank">
                                <option value="1">锦江区</option>
                                <option value="2">青羊区</option>
                                <option value="3">金牛区</option>
                                <option value="4">武侯区</option>
                                <option value="5">成华区</option>
                                <option value="6">高新区</option>
                                <option value="7">天府新区</option>
                                <option value="8">龙泉驿区</option>
                                <option value="9">青白江区</option>
                                <option value="10">新都区</option>
                                <option value="11">温江区</option>
                                <option value="12">双流区</option>
                                <option value="13">都江堰市</option>
                                <option value="14">彭州市</option>
                                <option value="15">邛崃市</option>
                                <option value="16">崇州市</option>
                                <option value="17">金堂县</option>
                                <option value="18">郫县</option>
                                <option value="19">大邑县</option>
                                <option value="20">浦江县</option>
                                <option value="21">新津县</option>
                                <option value="22">简阳市</option>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="30%">
                            <label class="c1">医院联系人</label>
                        </td>
                        <td>
                            <input type="text" class="input_class" name="name" id="names" />            
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="30%"><label class="c1">联系人手机</label></td>
                        <td><input type="text" class="input_class" name="tel" id="_tel" /></td>
                    </tr>
                    
                    <tr>
                        <td><label class="c1">介绍</label></td>
                        <td><textarea class="textarea_class" name="desc" id="_desc"></textarea></td>
                    </tr>

                    <tr>
                        <td><label class="c1">医院照片</label></td>
                        <td>
                            <input type="file" name="file_hos" id="file_hos" class="file_class" accept="image/*" capture="camera" />
                            <input type="hidden" name="picurl" id="picurl_hos">
                            <span id="picSpanHos"></span>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><label class="c1">医院照片2</label></td>
                        <td>
                            <input type="file" name="file_hos2" id="file_hos2" class="file_class" accept="image/*" capture="camera" />
                            <input type="hidden" name="picurl2" id="picurl_hos2">
                            <span id="picSpanHos2"></span>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="height:auto; padding:20px;">
                            <label class="c3" style="line-height:35px;color: #949090;">（图片大小不超过{{ $vote->photo_size/1024/1024}}M，宽度大于660px，宽高比例16:10最佳）</label>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" style="height:auto; padding:20px;">
                            <label class="c3" style="line-height:35px;color: #949090;text-align: left;"> 
                            1、请先检查您的图片是否大于5M。<br>
                            2、如果无法正常提交，请在电脑浏览器上输入<a href="http://www.langzoo.com/demo.xlsx">www.langzoo.com/demo.xlsx</a>下载报名表，填写相关内容，并附上照片2张，发送至邮箱zhoujie@scmingyi.com。<br>
                            3、报名后需审核才会显示，请等待！
                            </label>
                        </td>
                    </tr>
                </table>
                <input  class="hos_add_form_btn btn_class" type="button" value="提交" />
            </form>

        </div>
    </section>
    <section class="lock_box clearfix box_hide">
        <div class="lock_box_main clearfix">
            <img src="https://qiniu.scmingyi.com/mp_vote/public/images/load.gif" />
            <div class="msg_box">请稍后…</div>
        </div>
    </section>

@endsection

@section('selfjs')
    <script src="https://qiniu.scmingyi.com/mp_vote/public/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script type="application/javascript" src="/plugins/ajax-fileupload/ajaxfileupload.js"></script>
    <script type="application/javascript">
        $(function () {
            // candidate avatar upload.
            $(document).on('change', '#file_doc', function() {
                loading('上传中');
                uploadsuccess = function(data) {
                    if(data == '') {
                        loading(false);
                        tusi('上传错误');
                    }
                    var dataarr = data.split('|');
                    if(dataarr[0] == 0) {
                        loading(false);
                        $("#picurl_doc").val(dataarr[1]);
                        $("#picSpanDoc").html('<img width="120" height="120" src="/storage/'+dataarr[1]+'">');
                    }else if(dataarr[0] == 3){
                        loading(false);
                        tusi('上传图片过大');
                    } else {
                        loading(false);
                        tusi('上传错误');
                    }
                };
                $.ajaxfileupload({
                    url: '{{ route("base2.postUpload") }}',
                    data: {_token: "{{ csrf_token() }}", size: "{{ $vote->photo_size }}", name: "file_doc"},
                    dataType: 'text',
                    fileElementId: 'file_doc',
                    success: uploadsuccess,
                    error: function() {
                        loading(false);
                        tusi('上传错误');
                    }
                });
            });
            
             $(document).on('change', '#file_doc2', function() {
                loading('上传中');
                uploadsuccess = function(data) {
                    if(data == '') {
                        loading(false);
                        tusi('上传错误');
                    }
                    var dataarr = data.split('|');
                    if(dataarr[0] == 0) {
                        loading(false);
                        $("#picurl_doc2").val(dataarr[1]);
                        $("#picSpanDoc2").html('<img width="120" height="120" src="/storage/'+dataarr[1]+'">');
                    }else if(dataarr[0] == 3){
                        loading(false);
                        tusi('上传图片过大');
                    } else {
                        loading(false);
                        tusi('上传错误');
                    }
                };
                $.ajaxfileupload({
                    url: '{{ route("base2.postUpload") }}',
                    data: {_token: "{{ csrf_token() }}", size: "{{ $vote->photo_size }}", name: "file_doc2"},
                    dataType: 'text',
                    fileElementId: 'file_doc2',
                    success: uploadsuccess,
                    error: function() {
                        loading(false);
                        tusi('上传错误');
                    }
                });
            });
            
            $(document).on('change', '#file_hos', function() {
                loading('上传中');
                uploadsuccess = function(data) {
                    if(data == '') {
                        loading(false);
                        tusi('上传错误');
                    }
                    var dataarr = data.split('|');
                    if(dataarr[0] == 0) {
                        loading(false);
                        $("#picurl_hos").val(dataarr[1]);
                        $("#picSpanHos").html('<img width="120" height="120" src="/storage/'+dataarr[1]+'">');
                    }else if(dataarr[0] == 3){
                        loading(false);
                        tusi('上传图片过大');
                    } else {
                        loading(false);
                        tusi('上传错误');
                    }
                };
                $.ajaxfileupload({
                    url: '{{ route("base2.postUpload") }}',
                    data: {_token: "{{ csrf_token() }}", size: "{{ $vote->photo_size }}", name: "file_hos"},
                    dataType: 'text',
                    fileElementId: 'file_hos',
                    success: uploadsuccess,
                    error: function() {
                        loading(false);
                        tusi('上传错误');
                    }
                });
            });
            
            $(document).on('change', '#file_hos2', function() {
                loading('上传中');
                uploadsuccess = function(data) {
                    if(data == '') {
                        loading(false);
                        tusi('上传错误');
                    }
                    var dataarr = data.split('|');
                    if(dataarr[0] == 0) {
                        loading(false);
                        $("#picurl_hos2").val(dataarr[1]);
                        $("#picSpanHos2").html('<img width="120" height="120" src="/storage/'+dataarr[1]+'">');
                    }else if(dataarr[0] == 3){
                        loading(false);
                        tusi('上传图片过大');
                    } else {
                        loading(false);
                        tusi('上传错误');
                    }
                };
                $.ajaxfileupload({
                    url: '{{ route("base2.postUpload") }}',
                    data: {_token: "{{ csrf_token() }}", size: "{{ $vote->photo_size }}", name: "file_hos2"},
                    dataType: 'text',
                    fileElementId: 'file_hos2',
                    success: uploadsuccess,
                    error: function() {
                        loading(false);
                        tusi('上传错误');
                    }
                });
            });
            // candidate sign up.
            $(".doc_add_form_btn").click( function () {
                var name = $("#name").val();
                var tel = $("#tel").val();
                var desc = $("#desc").val();
                var ofHospital = $('#of_hospital').val();
                var ofDep = $('#of_dep').val();
                var picurlDoc = $('#picurl_doc').val();

                if(name == ""){
                    tusi("团队联系人不能为空");
                    return false;
                }
                if(tel == ''){
                    tusi("联系人手机号码不能为空");
                    return false;
                }
                if(ofHospital == ""){
                    tusi("医院名称不能为空");
                    return false;
                }
                if(ofDep == ""){
                    tusi("团队名称不能为空");
                    return false;
                }
                if(desc == ""){
                    tusi("介绍不能为空");
                    return false;
                }
                if(picurlDoc == ""){
                    tusi("请上传团队照片");
                    return false;
                }
                if (! checkMobile(tel)) {
                    tusi("手机号码格式不正确");
                    return false;
                }
                $(".lock_box").removeClass('box_hide');
                $.ajax({
                    type: "GET",
                    url: "{{ route('home.form.getDoRegister') }}",
                    data: $('#regFrom_doc').serialize(),
                    success: function(msg){
                        $(".lock_box").addClass('box_hide');
                        if(msg == 1){
                            tusi("报名成功");
                            setTimeout(function(){window.location="{{ route('home.form.getRegister') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}";}, 3000);
                        }else if(msg == 2){
                            tusi("报名成功，请等待管理员审核…");
                            setTimeout(function(){window.location="{{ route('home.form.getRegister') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}";}, 3000);
                        }else if(msg == 3) {
                            tusi("手机号已存在");
                            setTimeout(function(){document.location.reload();}, 3000);
                        }else{
                            tusi("报名失败");
                            //etTimeout(function(){document.location.reload();}, 3000);
                        }
                    }
                });
            });

            $(".hos_add_form_btn").click( function () {
                var name = $("#_name").val();
                var names = $("#names").val();
                var desc = $("#_desc").val();
                var picurlHos = $('#picurl_hos').val();
                var tel = $("#_tel").val();

                if(name == ""){
                    tusi("医院名称不能为空");
                    return false;
                }
                if(names == ""){
                    tusi("联系人姓名不能为空");
                    return false;
                }
                if(tel == ""){
                    tusi("联系人手机不能为空");
                    return false;
                }
                if(desc == ""){
                    tusi("介绍不能为空");
                    return false;
                }
                if(picurlHos == ""){
                    tusi("请上传医院照片");
                    return false;
                }
                $(".lock_box").removeClass('box_hide');
                $.ajax({
                    type: "GET",
                    url: "{{ route('home.form.getDoRegister') }}",
                    data: $('#regFrom_hos').serialize(),
                    success: function(msg){
                        $(".lock_box").addClass('box_hide');
                        if(msg == 1){
                            tusi("报名成功");
                            setTimeout(function(){window.location="{{ route('home.form.getRegister') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}";}, 3000);
                        }else if(msg == 2){
                            tusi("报名成功，请等待管理员审核…");
                            setTimeout(function(){window.location="{{ route('home.form.getRegister') }}?id={{ \Illuminate\Support\Facades\Input::get('id') }}";}, 3000);
                        }else if(msg == 3) {
                            tusi("手机号已存在");
                            setTimeout(function(){document.location.reload();}, 3000);
                        }else{
                            tusi("报名失败");
                            //setTimeout(function(){document.location.reload();}, 1888);
                        }
                    }
                });
            });
            $(document).on('click','.box_select a', function(event) {
                var name = this.name;
                var box = $("form[name="+name+"]");
                $(this).addClass('active').siblings('a').removeClass('active');
                $(box).show().siblings('form').hide();
            });
        });
    </script>
@endsection
