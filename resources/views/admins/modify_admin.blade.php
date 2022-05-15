@extends('layout.layout')
@section('title',  __('main.edit_admin') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-cog"></i> {{ __('main.admins_acc') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_admin') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_admin') }}</h3>
                <form action="{{ route('update_admin_data') }}" role="form" method="post" enctype="application/x-www-form-urlencoded">
                    {{ csrf_field() }}
                    <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                    <div class="form-group">
                        <label>{{ __('main.full_name') }}</label>
                        <input class="form-control" type="text" name="full_name" value="{{ $admin->full_name }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.username') }}</label>
                        <input class="form-control" type="text" name="username" value="{{ $admin->username }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.password') }}</label>
                        <input class="form-control" type="password" name="password" placeholder="{{ __('main.change_pass') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.c_password') }}</label>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="{{ __('main.change_pass') }}">
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection