@extends('layout.layout')
@section('title',  __('main.edit_sub_level') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-sort-amount-down"></i> {{ __('main.sub_levels') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_sub_level') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_sub_level') }}</h3>
                <form action="{{ route('update_sub_level') }}" role="form" method="post" enctype="application/x-www-form-urlencoded">
                    {{ csrf_field() }}
                    <input type="hidden" name="level_id" value="{{ $level->id }}">
                    <div class="form-group">
                        <label>{{ __('main.ar_level_name') }}</label>
                        <input class="form-control" type="text" name="ar_level_name" value="{{ $level->name }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_level_name') }}</label>
                        <input class="form-control" type="text" name="en_level_name" value="{{ $level->en_name }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.main_level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="main_level" id="slide_section_select">
                            @foreach($levels as $main_level)
                                @if($main_level->id == $level->level_id)
                                    <option value="{{ $main_level->id }}" selected>
                                        @if(app()->getLocale() == "ar")
                                            {{ $main_level->name }} - {{ $main_level->en_name }}
                                        @else
                                            {{ $main_level->en_name }} - {{ $main_level->name }}
                                        @endif
                                    </option>
                                @else
                                    <option value="{{ $main_level->id }}">
                                        @if(app()->getLocale() == "ar")
                                            {{ $main_level->name }} - {{ $main_level->en_name }}
                                        @else
                                            {{ $main_level->en_name }} - {{ $main_level->name }}
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection