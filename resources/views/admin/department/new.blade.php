@extends('layout')
@section('header')
    <title>WAOS | New Department</title>
    @endsection
    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            部门
            <small>新增</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/department/list">部门</a></li>
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
                            <label>部门名称</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
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
                Saved new Department " {{$name}} "
            </div>
        @endif
    </section><!-- /.content -->

@endsection


@section('js')
    <script>
        $('#tab_admin_department').addClass('active');
        $('#tab_admin_department_new').addClass('active');
    </script>
@endsection