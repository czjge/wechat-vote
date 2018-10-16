@extends('layouts.admin')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增社区</h3>
                    <a href="{{ route('admin.familydoctor.community.list') }}" class="btn btn-default pull-right"><i class="fa fa-reply"> 返回</i></a>
                </div>


                <form role="form" action="{{ route('admin.familydoctor.community.postAdd') }}" method="post" pjax-container>
                    {!! csrf_field() !!}

                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label"><span class="text-red">*</span>社区名称</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="" required maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="region" class="col-sm-2 control-label"><span class="text-red">*</span>所属区域</label>
                            <select class="form-control" name="region" id="region">
                                @foreach (Config::get('admin.communityRegion') as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address" class="col-sm-2 control-label">社区地址</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="" maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="hospital_id" class="col-sm-2 control-label">所属医联体</label><br/><br/>
                            <select class="form-control select2" name="hospital_id" id="hospital_id">
                                <option value="0">未关联</option>
                                @foreach ($hospital_list as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-default pull-right" id="community-contact-add"><i class="fa fa-plus"> 新增</i></a>
                            <label for="" class="col-sm-2 control-label">联系方式</label><br/><br/>

                            <div class="community-contact-container">
                                <div>
                                    <div class="col-sm-4">
                                        <input type="file" class="form-control community-contact-btn">
                                        <input type="hidden" name="contact_qrcode[]" value="">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="contact_phone[]">
                                    </div>
                                    <div class="col-sm-4">
                                        <a class="btn btn-default" id="community-contact-delete"><i class="fa fa-trash"> 删除</i></a>
                                    </div>
                                </div>
                            </div>

                            <br/><br/>
                        </div>

                        <div class="form-group">
                            <a class="btn btn-default pull-right" id="community-logo-add"><i class="fa fa-plus"> 新增</i></a>
                            <label for="" class="col-sm-2 control-label">logo</label><br/><br/>

                            <div class="community-logo-container">
                                <div>
                                    <div class="col-sm-6">
                                        <input type="file" class="form-control community-logo-btn">
                                        <input type="hidden" name="logos[]" value="">
                                    </div>
                                    <div class="col-sm-6">
                                        <a class="btn btn-default" id="community-logo-delete"><i class="fa fa-trash"> 删除</i></a>
                                    </div>
                                </div>
                            </div>

                            <br/><br/>
                        </div>

                        <div class="form-group">
                            <label for="paid_service_tag" class="col-sm-2 control-label">有偿预签约服务包</label>
                            <select class="form-control select2-paid_service_tag" multiple="multiple" name="paid_service_tag[]" id="paid_service_tag" data-placeholder="请选择">
                                @foreach ($paid_service_tags as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="unpaid_service_tag" class="col-sm-2 control-label">无偿预签约服务包</label>
                            <select class="form-control select2-unpaid_service_tag" multiple="multiple" name="unpaid_service_tag[]" id="unpaid_service_tag" data-placeholder="请选择">
                                @foreach ($unpaid_service_tags as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
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