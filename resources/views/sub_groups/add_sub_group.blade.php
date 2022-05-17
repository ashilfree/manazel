@extends('layout.layout')
@section('title',  __('main.add_sub_group') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="far fa-object-group"></i> {{ __('main.sub_groups') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.add_sub_group') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.add_sub_group') }}</h3>
                <form action="{{ route('set_sub_group') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('main.ar_sub_group_name') }}</label>
                        <input class="form-control" type="text" name="group_name" value="{{ old('group_name') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_sub_group_name') }}</label>
                        <input class="form-control" type="text" name="en_group_name" value="{{ old('en_group_name') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.sub_group_student_num') }}</label>
                        <input class="form-control" type="number" name="group_student_num" value="{{ old('group_student_num') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.ch_mains_groups') }}</label>
                        <select class="form-control f-size-090 mb-1" name="main_group" id="group_select">
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">
                                    @if(app()->getLocale() == "ar")
                                        {{ $group->name }} - {{ $group->en_name }}
                                    @else
                                        {{ $group->en_name }} - {{ $group->name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.select_current_week') }}</label>
                        <select class="form-control f-size-090 mb-1" name="week" id="week_select">
                            <option value="">{{ __('main.select_later') }}</option>
                            @php
                                $weeks = \App\Week::where('level_id', $groups[0]->sub_level_id)->get();
                            @endphp
                            @foreach($weeks as $week)
                                <option value="{{ $week->id }}">
                                    @if(app()->getLocale() == "ar")
                                        {{ $week->week_name }}
                                    @else
                                        {{ $week->week_en_name }}
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
