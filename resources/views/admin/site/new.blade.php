@extends('layout')
@section('header')
    <title>WAOS | New Site</title>
    @endsection
    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            工作地点
            <small>新增</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/admin/site/list">工作地点</a></li>
            <li class="active">新增</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <form role="form-horizontal" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>工作地点名称</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"
                                   required>
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>地址</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}" >
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>邮编</label>
                            <input type="number" class="form-control" id="postal" name="postal" value="{{old('postal')}}" >
                        </div>
                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>备注</label>
                            <textarea class="form-control" rows="3" name="remark">{{old('remark')}}</textarea>
                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">创建</button>
                    </div>
                </form>
            </div><!-- /.box-body -->

        </div><!-- /.box -->

        @if($success == true)
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Saved new Site " {{$name}} "
            </div>
        @endif

    </section><!-- /.content -->

@endsection


@section('js')
<script>
    $('#tab_admin_site').addClass('active');
    $('#tab_admin_site_new').addClass('active');
</script>
@endsection