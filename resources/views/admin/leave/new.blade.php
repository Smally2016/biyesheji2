@extends('layout')
@section('header')
    <title>WAOS | New Leave Type</title>
    @endsection
    @section('body')


            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Leave Type
            <small>New</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/leave/type/list">Leave Type</a></li>
            <li class="active">New</li>
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
                            <label>Leave Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"
                                       required>
                        </div>

                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>Description</label>
                                <textarea class="form-control" rows="3" name="remark">{{old('remark')}}</textarea>
                        </div>

                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">Create</button>
                    </div>
                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

        @if($success == true)
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Saved new Leave Type " {{$name}} "
            </div>
        @endif

    </section><!-- /.content -->

@endsection


@section('js')
    <script>
        $('#tab_admin_leave_type').addClass('active');
        $('#tab_admin_leave_type_new').addClass('active');
    </script>
@endsection