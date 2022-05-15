@extends('layout.layout')
@section('title',  __('main.add_group') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-object-ungroup"></i> {{ __('main.groups') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.add_group') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.add_group') }}</h3>
                <form action="{{ route('set_group') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('main.ar_group_name') }}</label>
                        <input class="form-control" type="text" name="group_name" value="{{ old('group_name') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_group_name') }}</label>
                        <input class="form-control" type="text" name="en_group_name" value="{{ old('en_group_name') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="level" id="slide_section_select">
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}">
                                    @if(app()->getLocale() == "ar")
                                        {{ $level->name }} - {{ $level->level }}
                                    @else
                                        {{ $level->en_name }} - {{ $level->en_level }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.sub_level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="sub_level_id" id="slide_section_select">
                            @foreach($sub_levels as $level)
                                <option selected value style="color:gray !important;"> -- {{ __('main.no_sub_level') }} -- </option>
                                <option value="{{ $level->id }}">
                                    @if(app()->getLocale() == "ar")
                                        {{ $level->name }}
                                    @else
                                        {{ $level->en_name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection