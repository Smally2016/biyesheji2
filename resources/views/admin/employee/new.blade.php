@extends('layout')
@section('header')
    <title>WAOS | Employee Title</title>
    @endsection
    @section('body')


            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee Title
            <small>New</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/employee/title/list">Employee Title</a></li>
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
                            <label>Employee Title Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"
                                   required>
                        </div>

                        <div class="form-group col-sm-offset-2 col-sm-8">
                            <label>Remark</label>
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
                Saved new Employee Title " {{$name}} "
            </div>
        @endif

    </section><!-- /.content -->

@endsection


@section('js')
    <script>
        $('#tab_admin_employee_title').addClass('active');
        $('#tab_admin_employee_title_new').addClass('active');
    </script>
@endsection