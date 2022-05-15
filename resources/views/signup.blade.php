@php
    //var_dump(auth()->user());
    //auth()->logout()
@endphp
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link href="{{ asset('css/main.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/plugins/font-awesome-5.1.0/css/all.css') }}" type="text/css" rel="stylesheet" />
    <title>تسجيل حساب السوبر أدمن</title>
</head>
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content" style="padding-bottom: 20px;">
    <div class="logo" style="margin-top: 15px; margin-bottom: 20px;">
        <img src="{{ URL('images/logo.png') }}" style="height: 140px;">
    </div>
    <div class="login-box" style="height: 450px;">
        <form action="{{ route('set_start') }}" class="login-form" method="post">
            {{ csrf_field() }}
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>تسجيل حساب السوبر أدمن</h3>
            <div class="form-group text-right">
                <label class="control-label">الأسم بالكامل</label>
                <input class="form-control" type="text" name="full_name" required autofocus>
            </div>
            <div class="form-group text-right">
                <label class="control-label">أسم المستخدم</label>
                <input class="form-control" type="text" name="username" required>
            </div>
            <div class="form-group text-right">
                <label class="control-label">كلمة المرور</label>
                <input class="form-control" type="password" name="password" required>
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt" style="margin-left: 3px;"></i>تسجيل </button>
            </div>
        </form>
    </div>
</section>
<script src="{{ asset('js/plugins/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/bootstrap-notify.min.js') }}" type="text/javascript"></script>

@if($errors->any())

    <script type="text/javascript">
        $(document).ready(function ()
        {
            $.notify({
                message: "{{ $errors->first() }}",
                @if($errors->first('error'))
                icon: 'fa fa-warning',
                @elseif($errors->first('success'))
                icon: 'fa fa-check',
                @endif
            },{
                placement: {
                    from: "top",
                    align: "right"
                },
                @if($errors->first('error'))
                type: "danger",
                @elseif($errors->first('success'))
                type: "success",
                @endif
                template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0} text-right" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss" style=" margin-right: -10px;">×</button>' +
                '<div style="margin-right: 10px;">' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '</div>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'});
        });
    </script>
@endif

</body>
</html>
