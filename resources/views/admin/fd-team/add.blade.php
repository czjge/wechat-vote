@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增团队</h3>
                    <a href="{{ route('admin.familydoctor.team.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.familydoctor.team.postAdd') }}" method="post" pjax-container>
                    {!! csrf_field() !!}

                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label"><span class="text-red">*</span>团队名称</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="community_id" class="col-sm-2 control-label">所属社区</label>
                            <select class="form-control select2" name="community_id" id="community_id">
                                <option value="0">请选择</option>
                                @foreach ($community_list as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="service_region" class="col-sm-2 control-label">服务区域</label>
                            <input type="text" class="form-control" name="service_region" id="service_region" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <a class="btn btn-default pull-right" id="team-contact-add"><i class="fa fa-plus"> 新增</i></a>
                            <label for="" class="col-sm-2 control-label">联系方式</label><br/><br/>

                            <div class="team-contact-container">
                                <div>
                                    <div class="col-sm-4">
                                        <input type="file" class="form-control team-contact-btn">
                                        <input type="hidden" name="contact_qrcode[]" value="">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="contact_phone[]">
                                    </div>
                                    <div class="col-sm-4">
                                        <a class="btn btn-default" id="team-contact-delete"><i class="fa fa-trash"> 删除</i></a>
                                    </div>
                                </div>
                            </div>

                            <br/><br/>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-default pull-right" id="team-photo-add"><i class="fa fa-plus"> 新增</i></a>
                            <label for="" class="col-sm-2 control-label">团队照片</label><br/><br/>

                            <div class="team-photo-container">
                                <div>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control team-photo-btn">
                                        <input type="hidden" name="photos[]" value="">
                                    </div>
                                    <div class="col-sm-6">
                                        <a class="btn btn-default" id="team-photo-delete"><i class="fa fa-trash"> 删除</i></a>
                                    </div>
                                </div>
                            </div>

                            <br/><br/>
                        </div>

                        <div class="form-group">
                            <label for="push_contact" class="col-sm-2 control-label">预签约名单推送</label>
                            <input type="text" class="form-control" name="push_contact" id="push_contact" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="desc" class="col-sm-2 control-label">简介</label>
                            <textarea class="form-control" name="desc" id="desc" rows="10"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="status" class="col-sm-2 control-label">状态</label>
                            <select class="form-control" name="status" id="status">
                                <option value="0">待审核</option>
                                <option value="1">审核通过</option>
                                <option value="-1">审核未通过</option>
                            </select>
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