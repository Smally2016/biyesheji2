@extends('layout')
@section('header')
    <title>编辑员工</title>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">

@endsection
@section('body')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            员工
            <small>编辑</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> 首页</a></li>
            <li><a href="/employee/list">员工</a></li>
            <li class="active">编辑</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-body">
                @if ($errors->has())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }} <br/>
                        @endforeach
                    </div>
                @endif
                <div class="flash-message">
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has($msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} </p>
                        @endif
                    @endforeach
                </div> <!-- end .flash-message -->
                <form role="form" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="col-lg-6">
                                    @if($employee-> img == null)
                                        <img class="img-responsive" src="/img/No_Profile.jpg"
                                             style="max-height: 200px;float: left"
                                             alt="User profile picture">

                                    @else
                                        <img class=" img-responsive" src="/{{$employee-> img}}"
                                             style="max-height: 200px;float: left"
                                             alt="User profile picture">

                                    @endif
                                </div>
                                <div class="col-lg-6">
                                    <input type="file" name="pic" class="btn btn-default">
                                    <span>
                                        <p>头像尺寸:宽400x高514</p>
                                        <p>文件大小必须在150K之内.</p>
                                        {{--<p>For more detail, refer https://apples.ica.gov.sg/apples/index.xhtml</p>--}}
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group col-sm-12" style="clear: both">
                                    <label for="name">姓名 <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" id="name" required name="name"
                                           value="{{$employee->name}}">
                                </div>
                                <div class="form-group col-sm-12" style="clear: left">
                                    <label for="nric">身份证号码 <span class="text-red">*</span></label>
                                    <input type="text" class="form-control" id="nric" required name="nric"
                                           value="{{$employee->nric}}">
                                </div>
                                <?php $dob = \Carbon\Carbon::parse($employee->dob)?>
                                <div class="form-group col-sm-4" style="clear: left">
                                    <label>出生日期 <span class="text-red">*</span></label>
                                    <select class="form-control" name="day" required>
                                        <option value="{{$dob->format('d')}}">{{$dob->format('d')}}</option>
                                        @for($i = 1; $i <= 31; $i++)
                                            <option value="{{$i}}" {{$dob->format('d') == $i?'selected':''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="color: white">M</label>
                                    <select class="form-control" name="month" required>
                                        <option value="{{$dob->format('m')}}">{{$dob->format('m')}}</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{$i}}" {{$dob->format('m') == $i?'selected':''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="color: white">Y</label>
                                    <select class="form-control" name="year" required>
                                        <option value="{{$dob->format('Y')}}">{{$dob->format('Y')}}</option>
                                        @for($i = date('Y')-16; $i >= date('Y')-86; $i--)
                                            <option value="{{$i}}" {{$dob->format('Y') == $i?'selected':''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group col-sm-6" style="clear: left">
                            <label>Gender <span class="text-red">*</span></label>
                            <select class="form-control" name="gender" required>
                                <option value="男" {{$employee->gender=='男'?'selected':''}}>男</option>
                                <option value="女" {{$employee->gender=='女'?'selected':''}}>女</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="id">员工ID</label>
                            <input type="text" class="form-control" id="id" required name="id"
                                   value="{{$employee->id}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>国籍</label>
                            <select class="form-control select2" name="nationality">
                                <option value="">选择国籍</option>
                                @foreach(\App\Helpers\NationalHelper::$nationals as $nation)
                                    <option value="{{$nation}}" {{$employee->nationality==strtoupper($nation)?'selected':''}}>{{$nation}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>城市 </label>
                            <select class="form-control" name="citizenship">
                                <option value="">Choose Citizenship</option>
                                @foreach(\App\Helpers\NationalHelper::$citizenships as $citi)
                                    <option value="{{$citi}}" {{$employee->citizenship==$citi?'selected':''}}>{{$citi}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>部门 <span class="text-red">*</span></label>
                            <select class="form-control" name="department_id" required>
                                @foreach($departments as $department)
                                    <option value="{{$department->department_id}}"
                                            {{$employee->department->first() ? ($employee->department->first()->department_id==$department->department_id?'selected':''):''}}>{{$department->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>职能 <span class="text-red">*</span></label>
                            <select class="form-control" name="title_id" required>
                                @foreach($titles as $title)
                                    <option value="{{$title->title_id}}" {{$employee->title_id==$title->title_id?'selected':''}}>{{$title->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="email">邮箱</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{$employee->email}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="phone">Mobile</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                   value="{{$employee->phone}}">
                        </div>

                        <div class="form-group  col-sm-12">
                            <label for="address">地址</label>
                            <input type="text" class="form-control" id="address" name="address"
                                   value="{{$employee->address}}">
                        </div>
                        <div class="form-group  col-sm-6">
                            <label for="address_postal">邮编</label>
                            <input type="text" class="form-control" id="address_postal" name="address_postal"
                                   value="{{$employee->address_postal}}">
                        </div>

                        <div class="form-group  col-sm-6" style="clear: left">
                            <label for="nok">紧急联系人姓名</label>
                            <input type="text" class="form-control" id="nok" name="nok" value="{{$employee->nok}}">
                        </div>

                        <div class="form-group  col-sm-6">
                            <label for="nok_phone">紧急联系方式</label>
                            <input type="text" class="form-control" id="nok_phone" name="nok_phone"
                                   value="{{$employee->nok_phone}}">
                        </div>

                        <div class="form-group col-sm-12">
                            <label>备注</label>
                            <textarea class="form-control" rows="3" name="remark">{{$employee->remark}}</textarea>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>开户银行</label>
                            <select class="form-control" name="bank" required>
                                @foreach(\App\Http\Models\EmployeeModel::$banks as $bank)
                                    <option value="{{$bank}}" {{$employee->bank==$bank?'selected':''}}>{{$bank}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-6">
                            <label>银行账号</label>
                            <input type="text" class="form-control" id="account" name="account"
                                   value="{{$employee->account}}">
                        </div>

                        <div class="form-group col-sm-6" style="clear: both">
                            <label>状态</label>
                            <select class="form-control" name="status" required>
                                @foreach(\App\Http\Models\EmployeeModel::$status as $key => $value)
                                    <option value="{{$key}}" {{$employee->status==$key?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary center-block">保存</button>
                    </div>
                </form>
            </div><!-- /.box-body -->

        </div><!-- /.box -->


        <!-- Default box -->
        {{--<div class="box">--}}
            {{--<div class="box-body">--}}
                {{--<form role="form" method="post" enctype="multipart/form-data"--}}
                      {{--action="/employee/edit/{{$employee->employee_id}}/pdf">--}}
                    {{--{{csrf_field()}}--}}
                    {{--<input type="hidden" name="license" value="license">--}}
                    {{--<div class="box-body">--}}
                        {{--<div class="form-group col-sm-6">--}}
                            {{--<label for="notification_number">Notification Number</label>--}}
                            {{--<input type="text" class="form-control" id="notification_number"--}}
                                   {{--name="notification_number"--}}
                                   {{--value="{{$employee->notification_number}}">--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-sm-6">--}}
                            {{--<label>Notification Valid</label>--}}
                            {{--<select class="form-control" name="notification_valid">--}}
                                {{--<option value="0" {{$employee->notification_valid==0?'selected':''}}>Not Valid</option>--}}
                                {{--<option value="1" {{$employee->notification_valid==1?'selected':''}}>Valid</option>--}}
                            {{--</select>--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-sm-6">--}}
                            {{--<label>Notification PDF</label>--}}
                            {{--@if($employee -> notification_pdf != '')--}}
                                {{--<a class="btn btn-success btn-sm" href="/{{$employee -> notification_pdf}}" download--}}
                                   {{--style="clear: both">Download</a>--}}
                                {{--<a class="btn btn-success btn-sm" href="/{{$employee -> notification_pdf}}"--}}
                                   {{--target="_blank">Preview</a>--}}
                            {{--@else--}}
                                {{--No file uploaded--}}
                            {{--@endif--}}
                        {{--</div>--}}
                        {{--<div class="form-group col-sm-6">--}}
                            {{--<label>Notification Upload</label>--}}
                            {{--<input type="file" name="pdf" class="btn  btn-sm btn-brown">--}}
                        {{--</div>--}}
                    {{--</div><!-- /.box-body -->--}}

                    {{--<div class="box-footer">--}}
                        {{--<button type="submit" class="btn btn-primary center-block">Update</button>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div><!-- /.box-body -->--}}

        {{--</div><!-- /.box -->--}}
    </section><!-- /.content -->

@endsection


@section('js')
    <script src="{{asset('js/inputmask.js')}}"></script>
    <script src="{{asset('js/jquery.inputmask.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>

    <script>
        $(document).ready(function ($) {
            $(".date_input").inputmask("99/99/9999", {placeholder: "dd/mm/yyyy"});
        });

        $('.select2').select2();


        $('#tab_employee').addClass('active');
        $('#tab_employee_list').addClass('active');
    </script>
@endsection