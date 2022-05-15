@extends('layout.layout')
@section('title',  __('main.add_homework') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-tasks"></i> {{ __('main.homework') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.add_homework') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.add_homework') }}</h3>
                <form action="{{ route('set_homework') }}" role="form" method="post" enctype="multipart/form-data" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('main.level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="level" id="slide_section_select">
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }} - {{ $level->level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.tajweed_link') }}</label>
                        <input class="form-control" type="text" name="tajweed_link" value="{{ old('group_name') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.tafsir_link') }}</label>
                        <input class="form-control" type="text" name="tafsir_link" value="{{ old('group_name') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.homework_file') }}</label>
                        <input name="homework_file" type="file" id="homework_file" class="inputfile inputfile-1 change_src_image">
                        <label for="homework_file" class="d-block">
                            <strong>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                </svg>{{ __('main.choose_File') }}</strong>
                            <span class="image-name"></span>
                        </label>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection