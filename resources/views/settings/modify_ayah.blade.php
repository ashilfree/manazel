@extends('layout.layout')
@section('title',  __('main.edit_ayah') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-cog"></i> {{ __('main.settings') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_ayah') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_ayah') }}</h3>
                <form action="{{ route('set_ayat_update') }}" role="form" method="post" enctype="multipart/form-data" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <input type="hidden" name="ayah_id" value="{{ $ayah->id }}">
                    <div class="form-group">
                        <label>{{ __('main.ayah_name') }}</label>
                        <input class="form-control" type="text" name="ayah_name" value="{{ $ayah->name }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_ayah_name') }}</label>
                        <input class="form-control" type="text" name="en_ayah_name" value="{{ $ayah->setting }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.ayah_file') }}</label>
                        <input name="ayah_file" type="file" id="homework_file" class="inputfile inputfile-1 change_src_image">
                        <label for="homework_file" class="d-block">
                            <strong>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                </svg>{{ __('main.choose_File') }}</strong>
                            <span class="image-name"></span>
                        </label>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @php
        //$name2 = pathinfo($ayah->setting2, PATHINFO_FILENAME);
        //$parts = parse_url($ayah->setting2);
        //$filename = basename($parts["path"]); // this will return 'file.php'
        //echo $filename;
    @endphp
@endsection
