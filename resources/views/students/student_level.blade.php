@extends('layout.layout')
@section('title',  __('main.select_student_level') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-graduate"></i> {{ __('main.students') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.select_student_level') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.select_student_level') }}</h3>
                <form action="{{ route('set_student_level') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <div class="form-group">
                        <label>{{ __('main.student_sound_test') }}</label>
                        @foreach($student_tests as $student_test)
                            <audio controls class="w-100">
                                <source src="{{ \App\Helper\MyHelper::returnBase64Data($student_test->file_path) }}" type="audio/mp4">
                                Your browser does not support the audio element.
                            </audio>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="level" id="main_level_select">
                            <option value="null">{{ __('main.notـspecified') }}</option>
                            @php
                                $selected_level_id = null;
                            @endphp
                            @foreach($levels as $level)
                                @if($level->id == $student->level_id)
                                    @php
                                        $selected_level_id = $level->id;
                                    @endphp
                                    <option value="{{ $level->id }}" selected>{{ $level->name }} - {{ $level->level }}</option>
                                @else
                                    <option value="{{ $level->id }}">{{ $level->name }} - {{ $level->level }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.sub_level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="sub_level" id="sub_level_select">
                            <option value>{{ __('main.no_sub_level') }}</option>
                            @php
                                $sub_levels = [];
                                if($selected_level_id != null)
                                {
                                    $sub_levels = \App\Sub_level::where('level_id', $selected_level_id)->get();
                                }
                            @endphp
                            @foreach($sub_levels as $level)
                                @php
                                    $selected_level_id = $level->id;
                                @endphp
                                @if($level->id == $student->sub_level_id)
                                    <option value="{{ $level->id }}" selected>{{ $level->name }}</option>
                                @else
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.change') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
