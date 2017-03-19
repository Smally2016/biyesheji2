@extends('layout')

@section('header')
    <title>WAOS | Employee Title</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee Title
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/employee/title/list">Employee Title</a></li>
            <li class="active">List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">

                <table id="user_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Employee Title</th>
                        <th>Remarks</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($titles as $title)
                        <tr>
                            <th>{{$title->name}}</th>
                            <th>{{$title->remark}}</th>
                            <th>
                                <a href="/admin/employee/title/edit/{{$title->title_id}}" class="btn btn-xs btn-warning">Edit</a>
                            </th>
                            <th>
                                <a href="/admin/employee/title/delete/{{$title->title_id}}" class="btn btn-xs btn-danger delete">Delete</a>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->

@endsection


@section('js')
    <script>
        $(function () {
            $('#user_table').DataTable({

            });
        });

        $('.delete').click(function () {
            return confirm("Are you sure to Delete?");
        });

        $('#tab_admin_employee_title').addClass('active');
        $('#tab_admin_employee_title_list').addClass('active');
    </script>
@endsection