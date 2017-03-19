<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="" type="image/png">

    <title>ADP Protection Services Pte Ltd</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/skin-blue-light.min.css')}}">
</head>

<body>
<div class="container">

    <div class="row" style="margin: 60px 0">
        <div class="col-sm-12 col-md-6">
            <img src="/adp.jpg" width="350px" style="margin: auto;display: block;max-width: 400px">
        </div>
        <div class="col-sm-12 col-md-6">
            <h2 style="text-align: center;line-height: 60px">ADP Protection Services Pte Ltd</h2>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row" style="font-size: 20px">
        <div class="col-md-6" style="font-size: 20px" style="margin-bottom: 50px">
            @if($employee-> img == null)
                <img src="/img/No_Profile.jpg" class="thumbnail img-responsive" alt=""
                     style="width: 300px;margin: auto;display: block">
            @else
                <img src="/{{$employee-> img}}" class="thumbnail img-responsive" alt=""
                     style="width: 300px;margin: auto;display: block">
            @endif
        </div>
        <div class="col-md-6" style="font-size: 20px">
            <div class="well">
                <span>Name: {{$employee -> name}}</span>
            </div>
            <div class="well">
                {{--<span>NRIC: {{substr($employee -> NRIC,0,5)}}****</span>--}}
                <span>NRIC: *{{substr(substr($employee -> nric,1),0,-2)}}**</span>
            </div>
            <div class="well">
                <span>Department: {{$employee->department->first()->name}}</span>
            </div>
            <div class="well">
                <span>Contact: {{$employee -> phone}}</span>
            </div>
            <div class=" well">
                <span>Police Notification Validity: </span>
                @if($employee -> notification_valid == 1)
                    <span style="color: green">Valid</span>
                @else
                    <span style="color: red">Not Valid</span>
                @endif
            </div>
            @if($employee -> notification_valid == 1)
                <div class="well">
                    <span>Notification Number: {{$employee -> notification_number}}</span>
                </div>
            @endif
        </div>
    </div>
</div>

</body>
</html>