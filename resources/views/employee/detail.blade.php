@extends('layout')
@section('header')
    <title>员工详情</title>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

    @endsection
    @section('body')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Employee
            <small>Detail</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="/employee/list">Employee</a></li>
            <li class="active">Detail</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                @if($employee-> img == null)
                    <img class="profile-user-img img-responsive"  src="/img/No_Profile.jpg"
                         alt="User profile picture">

                @else
                    <img class="profile-user-img img-responsive" src="/{{$employee-> img}}"
                         alt="User profile picture">

                @endif

                <h3 class="profile-username text-center">Nina Mcintire</h3>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </section><!-- /.content -->

@endsection


@section('js')
    <script src="{{asset('js/inputmask.js')}}"></script>
    <script src="{{asset('js/jquery.inputmask.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>

    <script>

        $('#tab_employee').addClass('active');
        $('#tab_employee_list').addClass('active');
    </script>
@endsection