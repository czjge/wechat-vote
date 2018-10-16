@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增选手</h3>
                    <a href="{{ route('admin.vote.getCandidateList', ['id'=>$vote->id]) }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postCandidateAdd') }}" method="post" enctype="multipart/form-data" id="myform" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="vote_id" value="{{ $vote->id }}"/>

                    <div class="box-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label>名称:</label>

                                <input type="text" class="form-control" name="name" maxlength="255" required value="{{ old('name') }}">
                                <span class="help-block">选手的姓名</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>性别:</label>

                            <select class="form-control" name="sex">
                                <option value="0">男</option>
                                <option value="1">女</option>
                            </select>
                            <span class="help-block">选手的性别</span>
                        </div>

                        <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                            <label>手机号:</label>

                            <input type="text" class="form-control" name="tel" maxlength="255">
                            <span class="help-block">选手的手机号</span>
                        </div>

                        <div class="form-group">
                            <label>简介:</label>

                            <textarea class="form-control" name="desc" rows="5"></textarea>
                            <span class="help-block">选手的参赛宣言</span>
                        </div>

                        <div class="form-group">
                            <label>头像:</label>

                            <input type="file" class="form-control fileupload">
                            <span class="help-block">支持jpg和png格式</span>
                            <div class="img-div" data-name="pic_url"></div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label>视频:</label>--}}

                            {{--<input type="file" class="form-control fileupload_video">--}}
                            {{--<span class="help-block">支持jpg和png格式</span>--}}
                            {{--<div class="video-div" data-name="video_url"></div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <label>排序:</label>

                            <input type="text" class="form-control" name="sort" maxlength="255">
                            <span class="help-block">数字越大越靠前</span>
                        </div>

                        <div class="form-group">
                            <label>医院:</label>

                            <input type="text" class="form-control" name="hos" maxlength="255">
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                            <label>科室:</label>

                            <input type="text" class="form-control" name="dep" maxlength="255">
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                            <label>职称:</label>

                            <input type="text" class="form-control" name="tit" maxlength="255">
                            <span class="help-block"></span>
                        </div>

                        @foreach($extendFieldList as $extendFieldItem)
                            @if($extendFieldItem->field_type=='string')
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{ $extendFieldItem->display_name }}:</label>

                                        <input type="text" class="form-control" name="{{ $extendFieldItem->field_name }}" maxlength="{{ $extendFieldItem->field_length }}" {{ $extendFieldItem->is_must==1 ? 'required' : '' }}>
                                        <span class="help-block">{{ $extendFieldItem->prompt_msg }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($extendFieldItem->field_type=='integer')
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{ $extendFieldItem->display_name }}:</label>

                                        <input type="number" class="form-control" name="{{ $extendFieldItem->field_name }}" {{ $extendFieldItem->is_must==1 ? 'required' : '' }}>
                                        <span class="help-block">{{ $extendFieldItem->prompt_msg }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($extendFieldItem->field_type=='text')
                                <div class="form-group">
                                    <label>{{ $extendFieldItem->display_name }}:</label>

                                    <textarea class="form-control" name="{{ $extendFieldItem->field_name }}" rows="5" {{ $extendFieldItem->is_must==1 ? 'required' : '' }}></textarea>
                                    <span class="help-block">{{ $extendFieldItem->prompt_msg }}</span>
                                </div>
                            @endif

                            @if($extendFieldItem->field_type=='select')
                                <div class="form-group">
                                    <label>{{ $extendFieldItem->display_name }}:</label>

                                    <select class="form-control" name="{{ $extendFieldItem->field_name }}" {{ $extendFieldItem->is_must==1 ? 'required' : '' }}>
                                        @foreach($extendFieldItem->select_values as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{ $extendFieldItem->prompt_msg }}</span>
                                </div>
                            @endif
                        @endforeach



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