@extends('layout')

@section('header')
    <title>WAOS | Leave Type</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Leave
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/leave">Leave</a></li>
            <li class="active">List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <table id="data_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leaves as $leave)
                        <tr>
                            <th>{{$leave->name}}</th>
                            <th>{{$leave->remark}}</th>
                            <th>
                                <a target="_blank" href="/admin/leave/type/edit/{{$leave->leave_type_id}}" class="btn btn-xs btn-warning">Edit</a>
                            </th>
                            <th>
                                <a href="/admin/leave/type/delete/{{$leave->leave_type_id}}" class="btn btn-xs btn-danger delete">Delete</a>
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
            $('#data_table').DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
            });
        });

        $('.delete').click(function () {
            return confirm("Are you sure to Delete?");
        });

        $('#tab_admin_leave_type').addClass('active');
        $('#tab_admin_leave_type_list').addClass('active');
    </script>
@endsection