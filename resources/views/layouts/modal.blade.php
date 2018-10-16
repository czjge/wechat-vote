<!-- change password modal -->
<div class="modal fade" id="changePwdModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">修改密码</h4>
            </div>
            <form id="pwd_chg_form">
                <div class="modal-body">
                        {!! csrf_field() !!}

                        @if (session('pwd_change_warning'))
                            <div class="alert alert-danger">
                                {{ session('pwd_change_warning') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">原密码</label>
                            <input type="password" class="form-control" name="old_password" id="old_password">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">新密码</label>
                            <input type="password" class="form-control" name="new_password" id="new_password">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">确认密码</label>
                            <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation">
                            <span class="help-block" id="error_msg"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="pwd_chg_btn">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- save throttle_vote_speed white_list modal -->
<!-- 你会发现select2的输入框不能输入，这时候把tabindex="-1"去掉就可以了。 -->
<div class="modal fade" id="saveThrottleWhiteListModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">白名单列表</h4>
            </div>
            <form id="save_throttle_white_list_form">
                <div class="modal-body list-body">

                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control select2" style="width: 80%;" id="not-white-list">

                        </select>
                        <button type="button" class="btn btn-primary" id="add-white-list-btn">添加</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    {{--<button type="button" class="btn btn-primary" id="pwd_chg_btn">保存</button>--}}
                </div>
            </form>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(function () {
        <!-- change password modal -->
        $('#pwd_chg_btn').click(function () {
            if ($('#old_password').val() == '') {
                $('#error_msg').html('<span class="text-danger">请输入原密码</span>');
                return;
            }

            if ($('#new_password').val() == '') {
                $('#error_msg').html('<span class="text-danger">请输入新密码</span>');
                return;
            }

            if ($('#new_password_confirmation').val() == '') {
                $('#error_msg').html('<span class="text-danger">请再次输入新密码</span>');
                return;
            }

            if ($('#new_password').val() != $('#new_password_confirmation').val()) {
                $('#error_msg').html('<span class="text-danger">前后密码不一致</span>');
                return;
            }

            $.ajax({
                type: 'POST',
                url: '{{ route("admin.postChgPwd") }}' ,
                data: $('#pwd_chg_form').serialize() ,
                dataType: 'json',
                success: function (e) {
                    if (e == 2) {
                        $('#error_msg').html('<span class="text-danger">原密码错误</span>');
                    }
                    if (e == 1) {
                        window.location.href = '{{ route("admin.getLogin") }}';
                    }
                }
            });
        });
        <!-- save throttle_vote_speed white_list modal -->
        $('#saveThrottleWhiteListModal').on('shown.bs.modal',
                function() {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("admin.vote.postThrottleWhiteList") }}' ,
                        data: {id: $('[name=id]').val(), _token: '{{ csrf_token() }}'},
                        dataType: 'json',
                        success: function (e) {
                            if (e.white_list.length>0) {
                                $('#save_throttle_white_list_form .list-body').empty();
                                for(var i=0; i<e.white_list.length; i++)
                                {
                                    $('#save_throttle_white_list_form .list-body').append('<span data-id='+ e.white_list[i].id+' class="label label-success" >'+ e.white_list[i].name+'</span><i class="fa fa-close remove-throttle-white-list"></i>&nbsp;');
                                }
                            }
                            if (e.not_white_list.length>0) {
                                $('#not-white-list').empty();
                                for(var i=0; i<e.not_white_list.length; i++)
                                {
                                    $('#not-white-list').append('<option value="'+e.not_white_list[i].id+'">'+ e.not_white_list[i].name+'</option>');
                                }
                            }
                        }
                    });
                });
        });
        $(document).on('click', '.remove-throttle-white-list', function () {
            var _this = $(this);
            $.ajax({
                type: 'POST',
                url: '{{ route("admin.vote.postThrottleWhiteRemove") }}' ,
                data: {id: $('[name=id]').val(), cid: $(this).prev().data('id'), _token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function (e) {
                    if (e != false) {
                        // the removing order cannot be exchanged.
                        _this.prev().remove();
                        _this.remove();
                        // append it to the select
                        $("#not-white-list").append("<option value='"+ e.id+"'>"+ e.name+"</option>");
                    }
                }
            });
        });
        $(document).on('click', '#add-white-list-btn', function () {
            var cid = $('#not-white-list').val();
            $.ajax({
                type: 'POST',
                url: '{{ route("admin.vote.postThrottleWhiteAdd") }}' ,
                data: {id: $('[name=id]').val(), cid: cid, _token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function (e) {
                    // append the new white list item
                    $('#save_throttle_white_list_form .list-body').append('<span data-id='+ e.id+' class="label label-success" >'+ e.name+'</span><i class="fa fa-close remove-throttle-white-list"></i>&nbsp;');
                    // remove it from select
                    $("#not-white-list option[value='"+cid+"']").remove();
                }
            });
        });
</script>