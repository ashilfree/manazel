@extends('layout.layout')
@section('title', __('main.c_panel'))

@section('content')
    @php
        //var_dump(auth()->user()->permissions->sub_groups);
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-tachometer-alt"></i> {{ __('main.c_panel') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
        </ul>
    </div>
    @if(auth('admins')->user()->permissions->statistics[0] == 1 || Auth::user()->admin == 1)
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="widget-small info coloured-icon"><i class="icon fas fa-chalkboard-teacher fa-3x"></i>
                    <div class="info">
                        <h4>{{ __('main.teachers_num') }}</h4>
                        <p><b>{{ $teachers_count }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small info coloured-icon"><i class="icon fas fa-user-graduate fa-3x"></i>
                    <div class="info">
                        <h4>{{ __('main.students_num') }}</h4>
                        <p><b>{{ $students_count }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small primary coloured-icon"><i class="icon fab fa-android fa-3x"></i>
                    <div class="info">
                        <h4>{{ __('main.android_num') }}</h4>
                        <p id="online_now_p"><b>{{ $android_count }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small blue coloured-icon"><i class="icon fab fa-apple fa-3x"></i>
                    <div class="info">
                        <h4>{{ __('main.ios_num') }}</h4>
                        <p id="today_visit_p"><b>{{ $ios_count }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon"><i class="icon fas fa-users fa-3x"></i>
                    <div class="info">
                        <h4>{{ __('main.app_users') }}</h4>
                        <p id="week_visit_p"><b>{{ $android_count + $ios_count }}</b></p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon"><i class="icon fas fa-tasks fa-3x" style="background-color: green;"></i>
                    <div class="info">
                        <h4>{{ __('main.homework_read') }}</h4>
                        <p id="week_visit_p"><b>{{ $homework_read }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon"><i class="icon fas fa-tasks fa-3x" style="background-color: red;"></i>
                    <div class="info">
                        <h4>{{ __('main.homework_not_read') }}</h4>
                        <p id="week_visit_p"><b>{{ $homework_not_read }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon"><i class="icon fas fa-tasks fa-3x" style="background-color: yellow;"></i>
                    <div class="info">
                        <h4>{{ __('main.homework_trmim') }}</h4>
                        <p id="week_visit_p"><b>{{ $homework_trmim }}</b></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="widget-small danger coloured-icon"><i class="icon fas fa-tasks fa-3x" style="background-color: orange;"></i>
                    <div class="info">
                        <h4>{{ __('main.homework_stopped') }}</h4>
                        <p id="week_visit_p"><b>{{ $homework_stopped }}</b></p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection