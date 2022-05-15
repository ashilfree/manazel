@extends('layout.layout')
@section('title',  __('main.add_country') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-flag"></i> {{ __('main.countries') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.add_country') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.add_country') }}</h3>
                <form action="{{ route('set_country') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('main.country_ar_name') }}</label>
                        <input class="form-control" type="text" name="ar_name" value="{{ old('ar_name') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.country_en_name') }}</label>
                        <input class="form-control" type="text" name="en_name" value="{{ old('en_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.country_phone_code') }}</label>
                        <input class="form-control" type="text" name="phone_code" value="{{ old('phone_code') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.country_code') }}</label>
                        <input class="form-control" type="text" name="country_code" placeholder="{{ __('main.country_code_plac') }}" value="{{ old('country_code') }}" required>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection