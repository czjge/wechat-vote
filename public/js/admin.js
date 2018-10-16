$(function(){

    // list-item delete.
    $(document).on('click', '.btn-delete', function () {
        var id = $(this).data('id');
        var module = $(this).data('module');
        bootbox.confirm({
            message: "确定删除?",
            buttons: {
                confirm: {
                    label: '确定',
                    className: 'btn-success'
                },
                cancel: {
                    label: '取消',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    //window.location.href = "/admin/" + module + "/delete/" + id;
                    $.pjax({
                        url: "/admin/" + module + "/delete/" + id,
                        container: '#pjax-container'
                    });
                }
            }
        });
    });

    // vote-candidate-status change.
    $(document).on('click', '.btn-status', function () {
        var id = $(this).data('id');
        var cid = $(this).data('cid');
        var status = $(this).data('status');
        var msg = $(this).data('msg');
        bootbox.confirm({
            message: msg,
            buttons: {
                confirm: {
                    label: '确定',
                    className: 'btn-success'
                },
                cancel: {
                    label: '取消',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    window.location.href = "/admin/vote/"+id+"/candidate-change-status/"+cid+"/"+status;
                }
            }
        });
    });

    // vote-add(edit)-form submit check.
    $(document).on('submit', '.vote-form', function () {
        if ($('[name=start_time]', $(this)).val() > $('[name=end_time]', $(this)).val()) {
            bootbox.alert({
                message: '开始时间不能小于结束时间',
                buttons: {
                    ok: {
                        label: '确定',
                        className: 'btn-warning'
                    }
                },
            });
            return false;
        }
        return true;
    });

    // if throttle_vote_speed is not 0,
    // we need save throttle_vote_speed white_list.
    $(document).on('blur', '[name=throttle_vote_speed]', function () {
        if ($(this).val() != 0) {
            $('#saveThrottleWhiteListModal').modal();
        }
    });

    // import candidates.
    $(document).on('click', '.import-candidate-btn', function () {
        $('.import-candidate-btn-real').click();
    });
    $(document).on('change', '.import-candidate-btn-real', function () {
        $('#import-candidate-form').submit();
    });

    // candidate extend field
    $(document).on('change', '#candidate-extend-field-select', function () {
        if ($(this).val()=='select') {
            $('[name=select_values]').prop('required', 'required');
            $('[name=select_values]').attr('required', 'required');
        } else {
            $('[name=select_values]').removeAttr('required');
        }
    });

    // doctor schedule time.
    $(document).on('click', '.edit-avail', function () {
        if ($(this).html() == '') {
            $(this).append('V');
        } else {
            $(this).empty();
        }
    });

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // community contact add.
    $(document).on('click', '#community-contact-add', function () {
        var html = '<div>'+
                        '<div class="col-sm-4">'+
                            '<input type="file" class="form-control community-contact-btn">'+
                            '<input type="hidden" name="contact_qrcode[]" value="">'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<input type="text" class="form-control" name="contact_phone[]">'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<a class="btn btn-default" id="community-contact-delete"><i class="fa fa-trash"> 删除</i></a>'+
                        '</div>'+
                    '</div>';
        $('.community-contact-container').append(html);
    });
    // community contact delete.
    $(document).on('click', '#community-contact-delete', function () {
        if ($('.community-contact-container').children().length<2) {
            bootbox.alert({
                message: '请至少保留一个',
                buttons: {
                    ok: {
                        label: '确定',
                        className: 'btn-warning'
                    }
                },
            });
            return false;
        }
        $(this).parent().parent().remove();
    });
    // community contact btn.
    $(document).on('change', '.community-contact-btn', function () {
        var _this = $(this);
        var formdata = new FormData();
        var fileObj = $(this).get(0).files;
        formdata.append("file_data", fileObj[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/admin/file/upload",
            data: formdata,
            dataType: "json",
            cache : false,
            contentType : false,
            processData : false,
            success: function(data){
                //console.log(data)
                var img = "<div>"+
                            "<img src='/storage/"+data["url"]+"' class='file-preview-image' width='100'>"+
                            "</div>";
                var fatherDiv = _this.parent().parent();
                if (fatherDiv.children().length==3) {
                    fatherDiv.prepend(img);
                } else {
                    fatherDiv.children().first().remove();
                    fatherDiv.prepend(img);
                }
                fatherDiv.children().eq(1).children().eq(1).val(data['url']);
            }
        });
    });

    // community logo add.
    $(document).on('click', '#community-logo-add', function () {
        var html = '<div>'+
            '<div class="col-sm-6">'+
            '<input type="file" class="form-control community-logo-btn">'+
            '<input type="hidden" name="logos[]" value="">'+
            '</div>'+
            '<div class="col-sm-6">'+
            '<a class="btn btn-default" id="community-logo-delete"><i class="fa fa-trash"> 删除</i></a>'+
            '</div>'+
            '</div>';
        $('.community-logo-container').append(html);
    });
    // community logo delete.
    $(document).on('click', '#community-logo-delete', function () {
        if ($('.community-logo-container').children().length<2) {
            bootbox.alert({
                message: '请至少保留一个',
                buttons: {
                    ok: {
                        label: '确定',
                        className: 'btn-warning'
                    }
                },
            });
            return false;
        }
        $(this).parent().parent().remove();
    });
    // community logo btn.
    $(document).on('change', '.community-logo-btn', function () {
        var _this = $(this);
        var formdata = new FormData();
        var fileObj = $(this).get(0).files;
        formdata.append("file_data", fileObj[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/admin/file/upload",
            data: formdata,
            dataType: "json",
            cache : false,
            contentType : false,
            processData : false,
            success: function(data){
                //console.log(data)
                var img = "<div>"+
                    "<img src='/storage/"+data["url"]+"' class='file-preview-image' width='100'>"+
                    "</div>";
                var fatherDiv = _this.parent().parent();
                if (fatherDiv.children().length==2) {
                    fatherDiv.prepend(img);
                } else {
                    fatherDiv.children().first().remove();
                    fatherDiv.prepend(img);
                }
                fatherDiv.children().eq(1).children().eq(1).val(data['url']);
            }
        });
    });

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // team contact add.
    $(document).on('click', '#team-contact-add', function () {
        var html = '<div>'+
            '<div class="col-sm-4">'+
            '<input type="file" class="form-control team-contact-btn">'+
            '<input type="hidden" name="contact_qrcode[]" value="">'+
            '</div>'+
            '<div class="col-sm-4">'+
            '<input type="text" class="form-control" name="contact_phone[]">'+
            '</div>'+
            '<div class="col-sm-4">'+
            '<a class="btn btn-default" id="team-contact-delete"><i class="fa fa-trash"> 删除</i></a>'+
            '</div>'+
            '</div>';
        $('.team-contact-container').append(html);
    });
    // team contact delete.
    $(document).on('click', '#team-contact-delete', function () {
        if ($('.team-contact-container').children().length<2) {
            bootbox.alert({
                message: '请至少保留一个',
                buttons: {
                    ok: {
                        label: '确定',
                        className: 'btn-warning'
                    }
                },
            });
            return false;
        }
        $(this).parent().parent().remove();
    });
    // team contact btn.
    $(document).on('change', '.team-contact-btn', function () {
        var _this = $(this);
        var formdata = new FormData();
        var fileObj = $(this).get(0).files;
        formdata.append("file_data", fileObj[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/admin/file/upload",
            data: formdata,
            dataType: "json",
            cache : false,
            contentType : false,
            processData : false,
            success: function(data){
                //console.log(data)
                var img = "<div>"+
                    "<img src='/storage/"+data["url"]+"' class='file-preview-image' width='100'>"+
                    "</div>";
                var fatherDiv = _this.parent().parent();
                if (fatherDiv.children().length==3) {
                    fatherDiv.prepend(img);
                } else {
                    fatherDiv.children().first().remove();
                    fatherDiv.prepend(img);
                }
                fatherDiv.children().eq(1).children().eq(1).val(data['url']);
            }
        });
    });

    // team photo add.
    $(document).on('click', '#team-photo-add', function () {
        var html = '<div>'+
            '<div class="col-sm-6">'+
            '<input type="file" class="form-control team-photo-btn">'+
            '<input type="hidden" name="photos[]" value="">'+
            '</div>'+
            '<div class="col-sm-6">'+
            '<a class="btn btn-default" id="team-photo-delete"><i class="fa fa-trash"> 删除</i></a>'+
            '</div>'+
            '</div>';
        $('.team-photo-container').append(html);
    });
    // team photo delete.
    $(document).on('click', '#team-photo-delete', function () {
        if ($('.team-photo-container').children().length<2) {
            bootbox.alert({
                message: '请至少保留一个',
                buttons: {
                    ok: {
                        label: '确定',
                        className: 'btn-warning'
                    }
                },
            });
            return false;
        }
        $(this).parent().parent().remove();
    });
    // team photo btn.
    $(document).on('change', '.team-photo-btn', function () {
        var _this = $(this);
        var formdata = new FormData();
        var fileObj = $(this).get(0).files;
        formdata.append("file_data", fileObj[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/admin/file/upload",
            data: formdata,
            dataType: "json",
            cache : false,
            contentType : false,
            processData : false,
            success: function(data){
                //console.log(data)
                var img = "<div>"+
                    "<img src='/storage/"+data["url"]+"' class='file-preview-image' width='100'>"+
                    "</div>";
                var fatherDiv = _this.parent().parent();
                if (fatherDiv.children().length==2) {
                    fatherDiv.prepend(img);
                } else {
                    fatherDiv.children().first().remove();
                    fatherDiv.prepend(img);
                }
                fatherDiv.children().eq(1).children().eq(1).val(data['url']);
            }
        });
    });

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // doctor avatar add.
    $(document).on('click', '#doctor-avatar-add', function () {
        var html = '<div>'+
            '<div class="col-sm-6">'+
            '<input type="file" class="form-control doctor-avatar-btn">'+
            '<input type="hidden" name="avatars[]" value="">'+
            '</div>'+
            '<div class="col-sm-6">'+
            '<a class="btn btn-default" id="doctor-avatar-delete"><i class="fa fa-trash"> 删除</i></a>'+
            '</div>'+
            '</div>';
        $('.doctor-avatar-container').append(html);
    });
    // doctor avatar delete.
    $(document).on('click', '#doctor-avatar-delete', function () {
        if ($('.doctor-avatar-container').children().length<2) {
            bootbox.alert({
                message: '请至少保留一个',
                buttons: {
                    ok: {
                        label: '确定',
                        className: 'btn-warning'
                    }
                },
            });
            return false;
        }
        $(this).parent().parent().remove();
    });
    // doctor avatar btn.
    $(document).on('change', '.doctor-avatar-btn', function () {
        var _this = $(this);
        var formdata = new FormData();
        var fileObj = $(this).get(0).files;
        formdata.append("file_data", fileObj[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/admin/file/upload",
            data: formdata,
            dataType: "json",
            cache : false,
            contentType : false,
            processData : false,
            success: function(data){
                //console.log(data)
                var img = "<div>"+
                    "<img src='/storage/"+data["url"]+"' class='file-preview-image' width='100'>"+
                    "</div>";
                var fatherDiv = _this.parent().parent();
                if (fatherDiv.children().length==2) {
                    fatherDiv.prepend(img);
                } else {
                    fatherDiv.children().first().remove();
                    fatherDiv.prepend(img);
                }
                fatherDiv.children().eq(1).children().eq(1).val(data['url']);
            }
        });
    });


});