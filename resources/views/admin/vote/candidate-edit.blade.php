@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">编辑选手</h3>
                    <a href="{{ route('admin.vote.getCandidateList', ['id'=>$candidate->vote_id]) }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.vote.postCandidateEdit') }}" method="post" enctype="multipart/form-data" id="myform" pjax-container>
                    {!! csrf_field() !!}
                    <input type="hidden" name="id" value="{{ $candidate->id }}"/>

                    <div class="box-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label>名称:</label>

                                <input type="text" class="form-control" name="name" maxlength="255" required value="{{ $candidate->name }}">
                                <span class="help-block">选手的姓名</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>性别:</label>

                            <select class="form-control" name="sex">
                                <option value="0" <?php if($candidate->sex==0){echo 'selected="selected"';}?>>男</option>
                                <option value="1" <?php if($candidate->sex==1){echo 'selected="selected"';}?>>女</option>
                            </select>
                            <span class="help-block">选手的性别</span>
                        </div>

                        <div class="form-group{{ $errors->has('tel') ? ' has-error' : '' }}">
                            <label>手机号:</label>

                            <input type="text" class="form-control" name="tel" maxlength="255" value="{{ $candidate->tel }}">
                            <span class="help-block">选手的手机号</span>
                        </div>

                        <div class="form-group">
                            <label>简介:</label>

                            <textarea class="form-control" name="desc" rows="5">{{ $candidate->desc }}</textarea>
                            <span class="help-block">选手的参赛宣言</span>
                        </div>

                        <div class="form-group">
                            <label>头像:</label>

                            <input type="file" class="form-control fileupload" value="{{ $candidate->pic_url }}">
                            <span class="help-block">支持jpg和png格式</span>
                            <div class="img-div" data-name="pic_url">
                                <input type='hidden' name='pic_url' value='{{ $candidate->pic_url }}'/>
                            </div>
                        </div>

                        {{--<div class="form-group">--}}
                            {{--<label>视频:</label>--}}

                            {{--<input type="file" class="form-control fileupload_video" value='{{ $candidate->video_url }}'>--}}
                            {{--<span class="help-block">支持jpg和png格式</span>--}}
                            {{--<div class="video-div" data-name="video_url">--}}
                                {{--<input type='hidden' name='video_url' value='{{ $candidate->video_url }}'/>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div class="form-group">
                            <label>票数:</label>

                            <input type="text" class="form-control" name="num" maxlength="255" value="{{ $candidate->num }}">
                            <span class="help-block">选手目前的票数</span>
                        </div>

                        <div class="form-group">
                            <label>状态:</label>

                            <select class="form-control" name="status">
                                <option value="0" <?php if($candidate->status == 0){echo 'selected="selected"';}?> >正常</option>
                                <option value="1" <?php if($candidate->status == 1){echo 'selected="selected"';}?> >待审核</option>
                                <option value="2" <?php if($candidate->status == 2){echo 'selected="selected"';}?> >锁定</option>
                            </select>
                            <span class="help-block">选手目前的状态</span>
                        </div>

                        <div class="form-group">
                            <label>排序:</label>

                            <input type="text" class="form-control" name="sort" maxlength="255" value="{{ $candidate->sort }}">
                            <span class="help-block">数字越大越靠前</span>
                        </div>

                        <div class="form-group">
                            <label>医院:</label>

                            <input type="text" class="form-control" name="hos" maxlength="255" value="{{ $candidate->hos }}">
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                            <label>科室:</label>

                            <input type="text" class="form-control" name="dep" maxlength="255" value="{{ $candidate->dep }}">
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group">
                            <label>职称:</label>

                            <input type="text" class="form-control" name="tit" maxlength="255" value="{{ $candidate->tit }}">
                            <span class="help-block"></span>
                        </div>

                        @foreach($extendFieldList as $extendFieldItem)
                            @if($extendFieldItem->field_type=='string')
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{ $extendFieldItem->display_name }}:</label>

                                        <input value="{{ $extendFieldValuesArr[$extendFieldItem->field_name] }}" type="text" class="form-control" name="{{ $extendFieldItem->field_name }}" maxlength="{{ $extendFieldItem->field_length }}" {{ $extendFieldItem->is_must==1 ? 'required' : '' }}>
                                        <span class="help-block">{{ $extendFieldItem->prompt_msg }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($extendFieldItem->field_type=='integer')
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>{{ $extendFieldItem->display_name }}:</label>

                                        <input value="{{ $extendFieldValuesArr[$extendFieldItem->field_name] }}" type="number" class="form-control" name="{{ $extendFieldItem->field_name }}" {{ $extendFieldItem->is_must==1 ? 'required' : '' }}>
                                        <span class="help-block">{{ $extendFieldItem->prompt_msg }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($extendFieldItem->field_type=='text')
                                <div class="form-group">
                                    <label>{{ $extendFieldItem->display_name }}:</label>

                                    <textarea class="form-control" name="{{ $extendFieldItem->field_name }}" rows="5" {{ $extendFieldItem->is_must==1 ? 'required' : '' }}>{{ $extendFieldValuesArr[$extendFieldItem->field_name] }}</textarea>
                                    <span class="help-block">{{ $extendFieldItem->prompt_msg }}</span>
                                </div>
                            @endif

                            @if($extendFieldItem->field_type=='select')
                                <div class="form-group">
                                    <label>{{ $extendFieldItem->display_name }}:</label>

                                    <select class="form-control" name="{{ $extendFieldItem->field_name }}" {{ $extendFieldItem->is_must==1 ? 'required' : '' }}>
                                        @foreach($extendFieldItem->select_values as $item)
                                            <option value="{{ $item }}" <?php if($item==$extendFieldValuesArr[$extendFieldItem->field_name]){echo 'selected="selected"';}?> >{{ $item }}</option>
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
