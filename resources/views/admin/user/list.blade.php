@extends('layout')

@section('header')
    <title>WAOS | User List</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/admin/user">User</a></li>
            <li class="active">List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <table class="table table-striped table-hover" id="data_table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Department</th>
                        <th>Remark</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                {{$user->username}}
                                @if($user->is_admin == 1)
                                    <span class="label label-info">Admin</span>
                                @elseif($user->is_admin == 2)
                                    <span class="label label-danger">Super Admin</span>
                                @endif
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>
                                <?php
                                $temp = array();
                                $departments = $user->department;
                                ?>
                                @foreach($departments as $department)
                                    <?php $temp[] = $department->name ?>
                                @endforeach
                                ({{$departments->count()}})
                                {{implode(', ',$temp) }}

                            </td>


                            <td>{{$user->remark}}</td>
                            <th>
                                <a class="btn btn-xs btn-warning" href="/admin/user/edit/{{$user->user_id}}"
                                   target="_blank">Edit</a>
                            </th>
                            <th>
                                <a class="btn btn-xs btn-danger">Delete</a>
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
                iDisplayLength: 50
            });
        });
        $('#tab_admin_user').addClass('active');
        $('#tab_admin_user_list').addClass('active');
    </script>

@endsection