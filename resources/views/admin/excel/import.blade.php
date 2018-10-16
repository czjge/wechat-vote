@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">导入</h3>
                    <a href="/admin/excel/export" target="_blank">导出</a>
                </div>

                <form role="form" action="{{ route('admin.excel.postImport') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}

                    <div class="box-body">
                        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label"></label>
                            <input type="file" class="form-control" name="file" placeholder="" required>
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