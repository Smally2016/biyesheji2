@extends('layout')

@section('header')
    <title>员工列表</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            员工
            <small>列表</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/employee/list">员工</a></li>
            <li class="active">列表</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header">
                <a href="/employee/list" class="btn btn-primary {{!isset($id)?'disabled':''}}">所有员工</a>
                <a href="/employee/list/current"
                   class="btn btn-primary {{(isset($id) and $id=='current')?'disabled':''}}">在职</a>
                <a href="/employee/list/resigned"
                   class="btn btn-primary {{(isset($id) and $id=='resigned')?'disabled':''}}">离职</a>
                <a href="/employee/list/reconsider"
                   class="btn btn-primary {{(isset($id) and $id=='reconsider')?'disabled':''}}">考虑中</a>
            </div>
            <div class="box-body">

                <table id="user_table" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>姓名</th>
                        <th>身份证号</th>
                        <th>手机号码</th>
                        <th>公寓</th>
                        <th>职位</th>
                        <th>状态</th>
                        <th>编辑</th>
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
                                    <span class="label label-success">在职</span>
                                @elseif($employee->status ==0)
                                    <span class="label label-danger">离职</span>

                                @elseif($employee->status ==2)
                                    <span class="label label-warning">考虑中</span>

                                @endif
                            </td>

                            <td>
                                <a href="/employee/edit/{{$employee->employee_id}}" target="_blank"
                                   class="btn btn-xs btn-warning">编辑</a>
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