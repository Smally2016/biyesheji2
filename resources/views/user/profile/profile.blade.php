@extends('layout_mobile.mobile_layout')

@section('body')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            个人信息
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $employee->name }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <strong>姓名</strong>
                <p class="text-muted">{{ $employee->name }}</p>
                <hr>

                <strong>编号</strong>
                <p class="text-muted">{{ $employee->id }}</p>
                <hr>

                <strong>身份证号</strong>
                <p class="text-muted">{{ $employee->nric }}</p>
                <hr>

                <strong>出生日期</strong>
                <p class="text-muted">{{ $employee->dob }}</p>
                <hr>

                <strong>性别</strong>
                <p class="text-muted">{{ $employee->gender }}</p>
                <hr>

                <strong>邮箱</strong>
                <p class="text-muted">{{ $employee->email }}</p>
                <hr>

                <strong>住址</strong>
                <p class="text-muted">{{ $employee->address }}</p>
                <hr>

                <strong>电话号码</strong>
                <p class="text-muted">{{ $employee->phone }}</p>

                <strong>紧急联系人姓名</strong>
                <p class="text-muted">{{ $employee->nok }}</p>
                <hr>

                <strong>紧急联系人电话</strong>
                <p class="text-muted">{{ $employee->nok_phone }}</p>
                <hr>

                <strong>部门</strong>

                <p>
                    @foreach($employee->department as $department)
                        <span class="label label-info label-lg">{{ $department->name }}</span>
                    @endforeach
                </p>

                <hr>
            </div>
            <!-- /.box-body -->
        </div>

    </section><!-- /.content -->

@endsection


@section('js')

@endsection