@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增投票扩展字段</h3>
                    <a href="{{ route('admin.vote.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postExtendFieldAdd', ['id'=>$vote->id]) }}" method="post" class="vote-form" pjax-container>
                    {!! csrf_field() !!}

                    <div class="box-body">
                        <div class="form-group">
                            <label>字段展示名:</label>

                            <input type="text" class="form-control" name="display_name" maxlength="64" required>
                            <span class="help-block">扩展字段的展示名，必填</span>
                        </div>

                        <div class="form-group">
                            <label>字段名:</label>

                            <input type="text" class="form-control" name="field_name" maxlength="32" required>
                            <span class="help-block">扩展字段的系统名，必填</span>
                        </div>

                        <div class="form-group">
                            <label>字段类型:</label>

                            <select class="form-control" name="field_type" id="candidate-extend-field-select">
                                <option value="string">字符串</option>
                                <option value="integer">整数</option>
                                <option value="text">文本</option>
                                <option value="select">下拉框</option>
                            </select>
                            <span class="help-block">扩展字段类型，必填</span>
                        </div>

                        <div class="form-group">
                            <label>下拉框默认值:</label>

                            <input type="text" class="form-control" name="select_values">
                            <span class="help-block">若字段类型是下拉框，填写下拉框值，英文逗号隔开，选填</span>
                        </div>

                        <div class="form-group">
                            <label>字段长度:</label>

                            <input type="text" class="form-control" name="field_length" maxlength="4">
                            <span class="help-block">扩展字段长度的最大长度，字段类型为“字符串”时候填写，选填</span>
                        </div>

                        <div class="form-group">
                            <label>默认值:</label>

                            <input type="text" class="form-control" name="df_value" maxlength="32">
                            <span class="help-block">扩展字段的默认值，选填</span>
                        </div>

                        <div class="form-group">
                            <label>是否必填:</label>

                            <select class="form-control" name="is_must">
                                <option value="1">是</option>
                                <option value="0">否</option>
                            </select>
                            <span class="help-block">扩展字段是否必须填写，必填</span>
                        </div>

                        <div class="form-group">
                            <label>提示信息:</label>

                            <input type="text" class="form-control" name="prompt_msg" maxlength="255">
                            <span class="help-block">扩展字段填写表单时的提示信息，选填</span>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-default">提交</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection