@extends('layout')
@section('header')
    <title>WAOS | Department</title>
@endsection
@section('body')
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Site
        <small>Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="/admin/department/list">Department</a></li>
        <li class="active">Edit</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-body">
            <form role="form-horizontal" method="post">
                {{csrf_field()}}
                <input type="hidden" value="{{$department->department_id}}" name="department_id">
                <div class="box-body">
                    <div class="form-group col-sm-offset-2 col-sm-8">
                        <label>Department Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$department->name}}"
                               required>
                    </div>
                    <div class="form-group col-sm-offset-2 col-sm-8">
                        <label>Remark</label>
                        <textarea class="form-control" rows="3" name="remark">{{$department->remark}}</textarea>
                    </div>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary center-block">Update</button>
                </div>
            </form>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

</section><!-- /.content -->

@endsection


@section('js')
<script>
    $('#tab_admin_department').addClass('active');
    $('#tab_admin_department_list').addClass('active');
</script>
@endsection