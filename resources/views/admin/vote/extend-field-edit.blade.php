@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑投票扩展字段</h3>
                    <a href="{{ route('admin.vote.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postExtendFieldEdit') }}" method="post" class="vote-form" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $extendField->id }}"/>
                    <input type="hidden" name="vote_id" value="{{ $extendField->vote_id }}"/>

                    <div class="box-body">
                        <div class="form-group">
                            <label>字段展示名:</label>

                            <input type="text" class="form-control" name="display_name" maxlength="64" required value="{{ $extendField->display_name }}">
                            <span class="help-block">扩展字段的展示名，必填</span>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label>字段名:</label>--}}

                            {{--<input type="text" class="form-control" name="field_name" maxlength="32" required>--}}
                            {{--<span class="help-block">扩展字段的系统名，必填</span>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<label>字段类型:</label>--}}

                            {{--<select class="form-control" name="field_type">--}}
                                {{--<option value="string">字符串</option>--}}
                                {{--<option value="integer">整数</option>--}}
                                {{--<option value="text">文本</option>--}}
                            {{--</select>--}}
                            {{--<span class="help-block">扩展字段类型，必填</span>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<label>字段长度:</label>--}}

                            {{--<input type="text" class="form-control" name="field_length" maxlength="4" required>--}}
                            {{--<span class="help-block">扩展字段长度的最大长度，字段类型为“字符串”、“整数”时候填写</span>--}}
                        {{--</div>--}}

                        {{--<div class="form-group">--}}
                            {{--<label>默认值:</label>--}}

                            {{--<input type="text" class="form-control" name="df_value" maxlength="32">--}}
                            {{--<span class="help-block">扩展字段的默认值，选填</span>--}}
                        {{--</div>--}}

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