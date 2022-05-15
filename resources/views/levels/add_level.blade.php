@extends('layout.layout')
@section('title',  __('main.add_level') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fas fa-sort-numeric-up"></i> {{ __('main.levels') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.add_level') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.add_level') }}</h3>
                <form action="{{ route('set_level') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('main.ar_level_name') }}</label>
                        <input class="form-control" type="text" name="ar_level_name" value="{{ old('ar_level_name') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.ar_the_level') }}</label>
                        <input class="form-control" type="text" name="ar_the_level" value="{{ old('ar_the_level') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_level_name') }}</label>
                        <input class="form-control" type="text" name="en_level_name" value="{{ old('en_level_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_the_level') }}</label>
                        <input class="form-control" type="text" name="en_the_level" value="{{ old('en_the_level') }}" required>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection