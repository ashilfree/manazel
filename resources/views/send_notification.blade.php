@extends('layout.layout')
@section('title', __('main.send_notification'))

@section('content')
    @php
        //echo Route::current()->getName();
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-bell"></i> التنبيهات</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.send_notification') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-8">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.send_notification') }}</h3>
                <form action="{{ route('set_send_notification') }}" class="login-form" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label">{{ __('main.notification_title') }}</label>
                        <input class="form-control" type="text" name="notification_title" required autofocus>
                    </div>
                    <div class="form-group">
                        <label class="control-label">{{ __('main.the_notification') }}</label>
                        <input class="form-control" type="text" name="notification" required >
                    </div>
                    <div class="form-group btn-container">
                        <button class="btn btn-primary btn-block" type="submit">{{ __('main.send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection