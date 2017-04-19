@extends('layout')

@section('header')
    <title>WAOS | Employee Card</title>
    @endsection

    @section('body')

            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            员工
            <small>员工卡</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/employee/card">员工</a></li>
            <li class="active">员工卡</li>
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
                        <th>姓名</th>
                        <th>身份证号</th>
                        <th>手机号码</th>
                        <th>员工卡链接</th>
                        <th>二维码</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($employees as $employee)
                        <tr class="userList">
                            <td>{{ $employee->name}}</td>
                            <td>{{ $employee->nric }}</td>
                            <td>{{ $employee->phone }}</td>
                            <td id="link{{$employee->employee_id}}"></td>
                            @if($employee -> secret == null)
                                <td id="employee{{$employee->employee_id}}"><a class="btn btn-primary btn-xs"
                                                                               id="button{{$employee->employee_id}}"
                                                                               onclick="generateQR('{{$employee -> employee_id}}','{{$employee -> secret}}')">生成二维码</a>
                                </td>
                            @else
                                <td id="employee{{$employee->employee_id}}"><a class="btn btn-primary btn-xs"
                                                                               id="button{{$employee->employee_id}}"
                                                                               onclick="generateQR('{{$employee -> employee_id}}','{{$employee -> secret}}')">展示二维码</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->
        </div><!-- /.box -->

    </section><!-- /.content -->

@endsection


@section('js')
    <script src="{{asset('js/qrcode.min.js')}}"></script>
    <script>
        $('#user_table').DataTable({});
        jQuery(document).ready(function () {

        });
        function generateQR(id, secret) {
            if (secret.length < 6) {
                $.post("/employee/add_secret",
                        {
                            employee_id: id,
                            _token: '{{csrf_token()}}',
                        },
                        function (data) {
                            secret = data
                            secret = "{{url('/check')}}" + '/' + id + secret

                            new QRCode(document.getElementById("employee" + id), secret);
                        });
            } else {
                secret = "{{url('/check')}}" + '/' + id + secret
                new QRCode(document.getElementById("employee" + id), secret);

            }

            $("#button" + id).hide()
            $("#link" + id).html("<a href='" + secret + "' target='_blank'>" + secret + "</a>")


        }

        $('#tab_employee').addClass('active');
        $('#tab_employee_card').addClass('active');
    </script>
@endsection