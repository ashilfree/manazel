@extends('layout.layout')
@section('title',  __('main.select_teacher_level') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-chalkboard-teacher"></i> {{ __('main.teachers') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.select_teacher_level') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.select_teacher_level') }}</h3>
                <form action="{{ route('set_teacher_level') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                    <div class="form-group">
                        <label>{{ __('main.teacher_sound_test') }}</label>
                        @foreach($teacher_tests as $teacher_test)
                            <audio controls class="w-100">
                                <source src="{{ \App\Helper\MyHelper::returnBase64Data($teacher_test->file_path) }}" type="audio/mp4">
                                Your browser does not support the audio element.
                            </audio>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="level" id="slide_section_select">
                            <option value="null">{{ __('main.notـspecified') }}</option>
                            @foreach($levels as $level)
                                @if($level->id == $teacher->level_id)
                                    <option value="{{ $level->id }}" selected>{{ $level->name }} - {{ $level->level }}</option>
                                @else
                                    <option value="{{ $level->id }}">{{ $level->name }} - {{ $level->level }}</option>
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
