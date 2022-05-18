<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Main CSS-->

    <link href="{{ asset('summernote/summernote-bs4.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/flatpickr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/plugins/switchery.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/plugins/font-awesome-5.6.1-web/css/all.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/plugins/ladda.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/plugins/cropper.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/plugins/fontawesome-iconpicker.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('intl-tel-input/css/intlTelInput.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('css/plugins/chosen.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/style.css') }}" type="text/css" rel="stylesheet" />

@if(app()->getLocale() == 'ar')
        <link href="{{ asset('css/main.css') }}" type="text/css" rel="stylesheet" />
    @elseif(app()->getLocale() == 'en')
        <link href="{{ asset('css/en_main.css') }}" type="text/css" rel="stylesheet" />
    @else
        <link href="{{ asset('css/main.css') }}" type="text/css" rel="stylesheet" />
    @endif
</head>
<body class="app sidebar-mini" url="{{ env('APP_URL','http://local-mnazel.com') }}">
@include('include.header')
@include('include.sidebar')

<main class="app-content">
    @yield('content')
</main>

<script src="{{ asset('js/plugins/jquery-3.3.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/flatpickr.min.js') }}"  type="text/javascript"></script>
<script src="{{ asset('js/plugins/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/sweetalert-dev.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/jscolor.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/bootstrap-notify.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('summernote/summernote-bs4.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('summernote/lang/summernote-ar-AR.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/switchery.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/spin.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/ladda.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/cropper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/fontawesome-iconpicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/plugins/chosen.jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('intl-tel-input/js/intlTelInput.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/main.js') }}" type="text/javascript"></script>

@if($errors->any())
    <script type="text/javascript">
        $(document).ready(function ()
        {
            $.notify({
                message: "{{ $errors->first() }}",
                @if($errors->first('error'))
                icon: 'fas fa-exclamation-triangle',
                @elseif($errors->first('success'))
                icon: 'fas fa-check',
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
                template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0} text-lang-dir" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close margin-10_bylang" data-notify="dismiss">×</button>' +
                    '<div class="margin-x10-by-lang">' +
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
