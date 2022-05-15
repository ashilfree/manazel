@extends('layout.layout')
@section('title',  __('main.edit_country') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-flag"></i> {{ __('main.countries') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_country') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_country') }}</h3>
                <form action="{{ route('update_country_data') }}" role="form" method="post" enctype="application/x-www-form-urlencoded">
                    {{ csrf_field() }}
                    <input type="hidden" name="country_id" value="{{ $country->id }}">
                    <div class="form-group">
                        <label>{{ __('main.country_ar_name') }}</label>
                        <input class="form-control" type="text" name="ar_name" value="{{ $country->name }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.country_en_name') }}</label>
                        <input class="form-control" type="text" name="en_name" value="{{ $country->en_name }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.country_phone_code') }}</label>
                        <input class="form-control" type="text" name="phone_code" value="{{ $country->phone_code }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.country_code') }}</label>
                        <input class="form-control" type="text" name="country_code" value="{{ $country->country_code }}" required>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection