@extends('layouts.home')


<?php $footer = 'app.vote.'.$vote->id.'.footer';?>
<?php $modal = 'app.vote.'.$vote->id.'.modal';?>

@section('selfmeta')
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/js/vote/35/select2.css" rel="stylesheet" type="text/css">
    <link href="{{ $qiniu_cdn_path }}/js/vote/35/webuploader/webuploader.css" rel="stylesheet" type="text/css">
    <link href="/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">
    <style>
        .footer_main{display: none}
    </style>
    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="container clearfix">
       <div class="banner reg"></div>
        <input type="hidden" name="id" value="{{ $vote->id }}"/>
        <input type="hidden" name="pic_url" value=""/>
        <input type="hidden" name="father_info" value=""/>
        <input type="hidden" name="mother_info" value=""/>
        <input type="hidden" name="kid_info" value=""/>
        <ul class="ri-info">
            <li>
                <div class="rform-title">所属大队</div>
                <div class="rform-right">
                    <input readonly placeholder="请选择所属大队" value="" id="expressArea" class="area-input" name="group">
                    <i class="icon-img arrow-right"></i>
                </div>
                <div class="input-tip tip-address">请选择所在地区</div>
            </li>
            <li>
                <div class="rform-title">家庭地址</div>
                <div class="rform-right">
                    <input class="rform-input" placeholder="请输入您的家庭地址" type="text" name="address">
                </div>
            </li>
            <li>
                <div class="rform-title">父亲信息</div>
                <div class="rform-right">
                    <input class="rform-input" placeholder="请输入您的家庭成员信息" type="text" name="father" readonly id="modal1">
                </div>
            </li>
            <li>
                <div class="rform-title">母亲信息</div>
                <div class="rform-right">
                    <input class="rform-input" placeholder="请输入您的家庭成员信息" type="text" name="mother" readonly id="modal2">
                </div>
            </li>
            <li>
                <div class="rform-title">小孩信息</div>
                <div class="rform-right">
                    <input class="rform-input" placeholder="请输入您的家庭成员信息" type="text" name="kid" readonly id="modal3">
                </div>
            </li>
            <li>
                <div class="rform-title">联系方式</div>
                <div class="rform-right">
                    <input class="rform-input" placeholder="请输入您的联系方式" type="text" name="mobile">
                </div>
            </li>
        </ul>
       <div class="ri-content clearfix">
            <h1>家庭消防理念</h1>
            <textarea class="ri-area" placeholder="请输入家庭消防理念" name="desc"></textarea>
        </div>
        <div class="ri-content pad-t0 clearfix">
            <p class="img-title">家庭合影照片</p>
            <div id="uploader">
                <div id="filePicker"><img src="{{ $qiniu_cdn_path }}/images/vote/35/add.png" width="100%"></div>
                <div class="uploader-tips"></div>
                <div id="fileList" class="uploader-list"></div>
                <input type="hidden" id="imgUrls" name="imgUrls"/>
            </div>
            <p class="img-tip">请上传照片</p>
        </div>
        <div class="ri-btn reg-btn">确认报名</div>
        <div style="height: 20px;width: 100%;"></div>
    </div>
    <div class="reg-rules"></div>
    <div class="info-modal modal-one">
        <div class="im-content">
            <div class="im-title">请您填写个人信息</div>
            <div class="im-item mrg-t7">
                <div class="icon-img icon-person"></div>
                <input type="text" name="name" placeholder="请输入姓名">
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-gender"></div>
                <div class="im-choose">
                    <div class="choose">
                        <div class="input"><label><input type="radio" name="sex1" value="1" checked="checked"/><span>男</span></label></div>
                        <div class="input"><label><input type="radio" name="sex1" value="0"/><span>女</span></label></div>
                    </div>
                </div>
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-age"></div>
                <input type="number" name="age" placeholder="请输入年龄">
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-id"></div>
                <input type="text" name="idcard" placeholder="请输入身份证">
            </div>
            <div class="ri-btn sure-btn" onclick="sureMsg(this)">确定</div>
        </div>
        <div class="im-hide" onclick="imClose(this)"></div>
    </div>
    <div class="info-modal modal-sec">
        <div class="im-content">
            <div class="im-title">请您填写个人信息</div>
            <div class="im-item mrg-t7">
                <div class="icon-img icon-person"></div>
                <input type="text" name="name" placeholder="请输入姓名">
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-gender"></div>
                <div class="im-choose">
                    <div class="choose">
                        <div class="input"><label><input type="radio" name="sex2" value="1"/><span>男</span></label></div>
                        <div class="input"><label><input type="radio" name="sex2" value="0" checked/><span>女</span></label></div>
                    </div>
                </div>
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-age"></div>
                <input type="number" name="age" placeholder="请输入年龄">
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-id"></div>
                <input type="text" name="idcard" placeholder="请输入身份证">
            </div>
            <div class="ri-btn sure-btn" onclick="sureMsg(this)">确定</div>
        </div>
        <div class="im-hide" onclick="imClose(this)"></div>
    </div>
    <div class="info-modal modal-thd">
        <div class="im-content child">
            <div class="im-title">请您填写个人信息</div>
            <div class="im-item mrg-t7">
                <div class="icon-img icon-person"></div>
                <input type="text" name="name" placeholder="请输入姓名">
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-gender"></div>
                <div class="im-choose">
                    <div class="choose">
                        <div class="input"><label><input type="radio" name="sex" value="1" checked/><span>男</span></label></div>
                        <div class="input"><label><input type="radio" name="sex" value="0" /><span>女</span></label></div>
                    </div>
                </div>
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-age"></div>
                <input type="number" name="age" placeholder="请输入年龄">
            </div>
            <div class="im-item mrg-t3">
                <div class="icon-img icon-id"></div>
                <input type="text" name="idcard" placeholder="请输入身份证">
            </div>
            <div class="ri-btn sure-btn" onclick="sureMsg(this)">确定</div>
        </div>
        <div class="im-hide" onclick="imClose(this)"></div>
    </div>
    <div class="area-modal">
        <div class="area-con">
            <select id="sel" class="area-select">
                <option></option>
            </select>
            <div class="area-cancle">取消</div>
        </div>
    </div>
@endsection

@section('selfjs')
    <script src="{{ $qiniu_cdn_path }}/js/vote/35/select2.full.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/35/webuploader/webuploader.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/35/xxx.js" type="text/javascript"></script>

    <script>
        var yyy = Object.keys(xxx).map(e => ({ text: e, children: xxx[e].map(x => ({ id: x, text: x }))}));
        function uploaderImg() {
            var uploader = WebUploader.create({
                auto: true,
                fileVal: 'file',
                swf: '{{ $qiniu_cdn_path }}/js/vote/35/webuploader/webuploader/Uploader.swf',
                server: '/upload',
                pick: '#filePicker',
                resize: false,
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                fileSingleSizeLimit: '{{ $vote->photo_size }}',
                threads: 9,
                fileNumLimit: 1,
                formData:{
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    Msize: '{{ $vote->photo_size }}',
                    fileName: 'file'
                },
            });
            uploader.on('beforeFileQueued', function (file) {
                /*if(_login_auth_()){
                    return true;
                }*/
                return true;
            });
            uploader.on('fileQueued', function (file) {
                var $li = $(
                    '<div id="' + file.id + '" class="file-item thumbnail">' +
                    '<img>' +
                    '<div class="thumbnail-delet"><div>' +
                    '</div>'
                    ),
                    $img = $li.find('img');
                var $list = $("#fileList");
                $list.append($li);
                uploader.makeThumb(file, function (error, src) {
                    if (error) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }
                    $img.attr('src', src);
                }, 100, 100);
                //fileStatusMap.push(file.id, 0);
                console.log(file.id)
            });
            uploader.on('fileDequeued', function (file) {
                // fileStatusMap.remove(file.id);
            });
            uploader.onError = function (code) {
                if (code == 'F_EXCEED_SIZE') {
                    myApp.alert("单张图片大小不能超过" + uploader.options.fileSingleSizeLimit / 1024 / 1024 + "M");
                } else if (code == 'Q_TYPE_DENIED') {
                    myApp.alert("请选择图片文件");
                } else if (code == 'Q_EXCEED_NUM_LIMIT') {
                    myApp.alert("图片数量不能超过" + uploader.options.fileNumLimit + "张");
                } else if (code == 'F_DUPLICATE') {
                    // myApp.alert("该图片已被上传");
                } else {
                    // TODO 失败数据统计
                    myApp.alert("上传文件失败，code: " + code);
                }
            };
            // 文件上传过程中创建进度条实时显示。
            uploader.on('uploadProgress', function (file, percentage) {
                var $li = $('#' + file.id),
                    $percent = $li.find('.progress span');
                // 避免重复创建
                if (!$percent.length) {
                    $percent = $('<p class="progress"><span></span></p>').appendTo($li).find('span');
                }
                $percent.css('width', percentage * 100 + '%');
            });
            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function (file, response) {
//                console.log(response.data)
//                filePath = response.data[0].file_path;
                var dataarr = response._raw.split('|');
                $('[name=pic_url]').val(dataarr[1]);
//                fileId = response.data[0].file_id;
                var uploaded = $("#imgUrls").val() ? $("#imgUrls").val() + "," : "";
                $("#imgUrls").val(dataarr[1]);
                $('#' + file.id).addClass('upload-state-done');
                var $li = $('#' + file.id);
                $('#' + file.id).on('click', '.thumbnail-delet', function () {
                    console.log(1);
                    uploader.removeFile(file);
                    /*console.log(response.data.filePath);*/
                    $li.remove();
                    if($("#imgUrls").val().indexOf(dataarr[1]) != -1){
                        if($("#imgUrls").val() == dataarr[1]){
                            $("#imgUrls").val('');
                        }else if($("#imgUrls").val().endsWith(dataarr[1])){
                            $("#imgUrls").val($("#imgUrls").val().replace(',' + dataarr[1], ''))
                        }else{
                            $("#imgUrls").val($("#imgUrls").val().replace(dataarr[1] + ',', ''))
                        }
                    }
                });
            });
            // 文件上传失败，显示上传出错。
            uploader.on('uploadError', function (file) {
                console.log(2);
                var $li = $('#' + file.id),
                    $error = $li.find('div.error');
                // 避免重复创建
                if (!$error.length) {
                    $error = $('<div class="error-text"></div>').appendTo($li);
                }
                $error.text('上传失败');
                $li.children("img").addClass('error');
                $('#' + file.id).on('click', '.thumbnail-delet', function () {
                    uploader.removeFile(file);
                    $li.remove();
                });
            });
        }
        uploaderImg();
        $('.reg-rules').click(function () {
            $('.rule_box').removeClass('box_hide');
        });
        function closeRules() {
            $('.rule_box').addClass('box_hide');
        };
        function imClose(e) {
            $(e).parent().hide();
        };
       $('#modal1').click(function () {
           $('.modal-one').show();
       });
        $('#modal2').click(function () {
            $('.modal-sec').show();
        })
        $('#modal3').click(function () {
            $('.modal-thd').show();
        });
        function checkIdCard(s){
            var regu =/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
            var re = new RegExp(regu);
            if (re.test(s)) {
                return true;
            }else{
                return false;
            }
        }
        function checkMobile(s){
            var regu =/^[1][3|8|4|5|7|9][0-9]{9}$/;
            var re = new RegExp(regu);
            if (re.test(s)) {
                return true;
            }else{
                return false;
            }
        }
        function sureMsg(e) {
            var pa   = $(e).parent();
            var name = $(pa).find('input[name = "name"]').val();
            var age  = $(pa).find('input[name = "age"]').val();
            var id   = $(pa).find('input[name = "idcard"]').val();
            var sex1 = $(pa).find('input[name="sex1"]:checked').val();
            var sex2 = $(pa).find('input[name="sex2"]:checked').val();
            var sex  = $(pa).find('input[name="sex"]:checked').val();

            if(name == ""){
                tusi("姓名不能为空");
                return false;
            }
            if(age == ""){
                tusi("年龄不能为空");
                return false;
            }
//            if(id == ""){
//                tusi("身份证不能为空");
//                return false;
//            }
//            if(!checkIdCard(id)){
//                tusi("身份证号格式不正确");
//                return false;
//            }

            if ($(pa).parent().hasClass('modal-thd')){  //小孩信息
                if (age >= 6 && age <= 16) {
                    var kidInfo = name + ',' + sex + ',' + age + ',' + id;
                    $('[name=kid_info]').val(kidInfo);
                    $('#modal3').attr('value', name);
                    $(pa).parent().hide();
                }else {
                    tusi('儿童年纪应在6岁-16岁区间');
                }
            }else if ($(pa).parent().hasClass('modal-sec')){  //母亲信息
                var motherInfo = name + ',' + sex2 + ',' + age + ',' + id;
                $('[name=mother_info]').val(motherInfo);
                $('#modal2').attr('value', name);
                $(pa).parent().hide();
            }else if ($(pa).parent().hasClass('modal-one')){  //父亲信息
                var fatherInfo = name + ',' + sex1 + ',' + age + ',' + id;
                $('[name=father_info]').val(fatherInfo);
                $('#modal1').attr('value', name);
                $(pa).parent().hide();
            }
        };
        $('#expressArea').click(function () {
            $('.area-modal').show();
        });
        $('.area-cancle').click(function () {
            $('.area-modal').hide();
        });
      //远程筛选
        $("#sel").select2({
            data: yyy,
            placeholder: '请选择',
            allowClear:true
        });
        $("#sel").on("change",function(){
            var val = $(this).val();
            $('#expressArea').attr('value', val);
            $('.area-modal').hide()
        })

        var submintVoteStatus = 0;
        $(".reg-btn").click( function () {
            if(submintVoteStatus == 1){
                return false;
            }

            var group   = $('[name=group]').val().trim();
            var address = $('[name=address]').val().trim();
            var father  = $('[name=father_info]').val().trim();
            var mother  = $('[name=mother_info]').val().trim();
            var kid     = $('[name=kid_info]').val().trim();
            var desc    = $('[name=desc]').val().trim();
            var picUrl  = $('[name=pic_url]').val().trim();
            var id      = $('[name=id]').val().trim();
            var mobile  = $('[name=mobile]').val().trim();

            if(group == ""){
                tusi("所属大队不能为空");
                return false;
            }
            if(address == ""){
                tusi("家庭地址不能为空");
                return false;
            }
            if(father == ""){
                tusi("父亲信息不能为空");
                return false;
            }
            if(mother == ""){
                tusi("母亲信息不能为空");
                return false;
            }
            if(kid == ""){
                tusi("小孩信息不能为空");
                return false;
            }
            if(mobile == ""){
                tusi("联系方式不能为空");
                return false;
            }
            if(! checkMobile(mobile)){
                tusi("手机号码格式不对");
                return false;
            }
            if(desc == ""){
                tusi("家庭消防理念不能为空");
                return false;
            }
            if(picUrl == ""){
                tusi("家庭合影照片不能为空");
                return false;
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('home.vote.getDoRegister' . Input::get('id')) }}?id={{ Input::get('id') }}",
                data: {group: group, address: address, father: father, mother: mother, kid: kid, desc: desc, pic_url: picUrl, id: id, tel: mobile},
                beforeSend: function () {
                    loading('请稍后');
                    submintVoteStatus = 1;
                },
                complete: function () {
                    loading(false);
                    submintVoteStatus = 0;
                },
                success: function(msg){
                    if(msg == 1){
                        tusi("报名成功");
                        //setTimeout(function(){window.location="{{ route('home.vote.getIndex' . Input::get('id')) }}?id={{ Input::get('id') }}";}, 1888);
                        setTimeout(function(){window.location.reload();}, 1888);
                    }else if(msg == 2){
                        tusi("报名成功，请等待管理员审核…");
                        //setTimeout(function(){window.location="{{ route('home.vote.getIndex' . Input::get('id')) }}?id={{ Input::get('id') }}";}, 1888);
                        setTimeout(function(){window.location.reload();}, 1888);
                    }else{
                        tusi("报名失败");
                        //setTimeout(function(){document.location.reload();}, 1888);
                    }
                }
            });
        });
    </script>
@endsection
