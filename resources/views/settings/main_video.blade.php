@extends('layout.layout')
@section('title',  __('main.main_video') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-cog"></i> {{ __('main.settings') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_main_video') }}</a></li>
        </ul>
    </div>
    @if($main_video)
        @if($main_video->type == "youtube" || $main_video->type == "video")
            <div class="row justify-content-center">
                <div class="col-xs-12 col-md-9">
                    <div class="tile">
                        <h3 class="tile-title text-center">{{ __('main.edit_main_video') }}</h3>
                        <form action="{{ route('set_main_video') }}" role="form" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="video_id" value="{{ $main_video->id }}">
                            <div class="form-group">
                                <label>{{ __('main.video_link') }}</label>
                                @if($main_video->type == "youtube")
                                    <input type="text" name="videos_link" value="{{ $main_video->setting }}" class="form-control input_margin_bot mb-2 f-size-090">
                                    <iframe style="max-width: 250px; border: 0;" src="{{ $main_video->setting }}"></iframe>
                                @else
                                    <input type="text" name="videos_link" class="form-control input_margin_bot mb-2 f-size-090">
                                @endif
                            </div>
                            <div class="form-group">
                                <label>{{ __('main.video_file') }}</label>
                                <input name="videos_file" type="file" id="videos_file" class="inputfile inputfile-1">
                                <label for="videos_file" class="d-block">
                                    <strong>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                        </svg>{{ __('main.choose_File') }}</strong>
                                    <span class="image-name"></span>
                                </label>
                            </div>
                            <p class="help-block mt-1">{{ __('main.video_desc') }}</p>
                            @if($main_video->type == "video")
                                <video style="max-width: 250px; border: 0;" controls>
                                    <source src="{{ $main_video->setting }}">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                            <div class="tile-footer">
                                <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="row justify-content-center">
            <div class="col-xs-12 col-md-9">
                <div class="tile">
                    <h3 class="tile-title text-center">{{ __('main.add_main_video') }}</h3>
                    <form action="{{ route('set_main_video') }}" role="form" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>{{ __('main.video_link') }}</label>
                            <input type="text" name="videos_link" class="form-control input_margin_bot mb-2 f-size-090">
                        </div>
                        <div class="form-group">
                            <label>{{ __('main.video_file') }}</label>
                            <input name="videos_file" type="file" id="videos_file" class="inputfile inputfile-1">
                            <label for="videos_file" class="d-block">
                                <strong>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                                    </svg>{{ __('main.choose_File') }}</strong>
                                <span class="image-name"></span>
                            </label>
                        </div>
                        <p class="help-block mt-1">{{ __('main.video_desc') }}</p>
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection