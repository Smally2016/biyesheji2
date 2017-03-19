@extends('layout')

@section('header')
    <title>WAOS | Employee List</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/employee/list">Employee</a></li>
            <li class="active">List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <a href="/employee/list" class="btn btn-primary {{!isset($id)?'disabled':''}}">All</a>
                <a href="/employee/list/current"
                   class="btn btn-primary {{(isset($id) and $id=='current')?'disabled':''}}">Current</a>
                <a href="/employee/list/resigned"
                   class="btn btn-primary {{(isset($id) and $id=='resigned')?'disabled':''}}">Resigned</a>
                <a href="/employee/list/reconsider"
                   class="btn btn-primary {{(isset($id) and $id=='reconsider')?'disabled':''}}">Re-consider</a>
            </div>
            <div class="box-body">

                <table id="user_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>NRIC</th>
                        <th>Mobile</th>
                        <th>Department</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->nric}}</td>
                            <td>{{$employee->phone}}</td>
                            <td>
                                @foreach($employee->department as $department)
                                    {{$department->name}}
                                @endforeach
                            </td>
                            <td>
                                {{$employee->title->name}}
                            </td>
                            <td>
                                @if($employee->status==1)
                                    <span class="label label-success">Current</span>
                                @elseif($employee->status ==0)
                                    <span class="label label-danger">Resigned</span>

                                @elseif($employee->status ==2)
                                    <span class="label label-warning">Re-consider</span>

                                @endif
                            </td>

                            <td>
                                <a href="/employee/edit/{{$employee->employee_id}}" target="_blank"
                                   class="btn btn-xs btn-warning">Edit</a>
                            </td>
                            {{--    <td>
                                    <a href="/employee/delete/{{$employee->employee_id}}"
                                       class="btn btn-xs btn-danger delete_button">Delete</a>
                                </td>--}}
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
            $('#user_table').DataTable({});
        });
        $('.delete_button').on('click', function () {
            return confirm('Confirm Delete Employee?');
        });
        $('#tab_employee').addClass('active');
        $('#tab_employee_list').addClass('active');
    </script>
@endsection