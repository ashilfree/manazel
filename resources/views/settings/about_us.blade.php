@extends('layout.layout')
@section('title',  __('main.about_us') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-cog"></i> {{ __('main.settings') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.about_us') }}</a></li>
        </ul>
    </div>
    @if(!$about_us)
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.add_about_us') }}</h3>
                <form action="{{ route('set_about_us') }}" role="form" method="post" enctype="multipart/form-data" class="image_crop_form">
                    {{ csrf_field() }}
                    <input type="hidden" id="filename" name="filename" /> <!-- Filename -->
                    <div class="form-group">
                        <label>{{ __('main.about_usـdata') }}</label>
                        <textarea id="summernote" name="about_usـdata"></textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_about_usـdata') }}</label>
                        <textarea id="summernote2" name="en_about_usـdata"></textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.app_guide_image') }}</label>
                        <input name="image" type="file" id="image" class="inputfile inputfile-1 change_src_image crop_image_input">
                        <label for="image" class="d-block">
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
    @else
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_about_us') }}</h3>
                <form action="{{ route('set_about_us_update') }}" role="form" method="post" enctype="multipart/form-data" class="image_crop_form">
                    {{ csrf_field() }}
                    <input type="hidden" id="filename" name="filename" /> <!-- Filename -->
                    <input type="hidden" name="about_us_id" value="{{ $about_us->id }}" /> <!-- Filename -->
                    <div class="form-group">
                        <label>{{ __('main.about_usـdata') }}</label>
                        <textarea id="summernote" name="about_usـdata">{{ $about_us->setting }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_about_usـdata') }}</label>
                        <textarea id="summernote2" name="en_about_usـdata">{{ $about_us->setting2 }}</textarea>
                    </div>
                    <div class="form-group" style="border: 1px solid #cccccc;padding: 0px 20px 20px 20px;border-radius: 5px;">
                        <div class="text-center p-4">
                            <h1 class="d-block">{{ __('main.app_guide_image') }}</h1>
                            <img src="{{ \App\Helper\MyHelper::returnBase64Data($about_us->name) }}" class="img-fluid" style="max-height: 200px;" />
                        </div>
                        <input name="image" type="file" id="image" class="inputfile inputfile-1 change_src_image crop_image_input">
                        <label for="image" class="d-block">
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
    @endif
    <div class="modal fade crop_image_model" id="add_slide_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">{{ __('main.crop_iamge') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <img class="w-100 crop_image_image" src="https://avatars0.githubusercontent.com/u/3456749">
                    </div>
                    <span class="d-block py-2 text-center font-weight-bold">{{ __('main.aspect_ratio') }}</span>
                    <div class="btn-group d-flex flex-nowrap justify-content-center" data-toggle="buttons">
                        <label class="btn btn-primary active">
                            <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">16:9</span>
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">4:3</span>
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">1:1</span>
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">2:3</span>
                        </label>
                        <label class="btn btn-primary">
                            <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">Free</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary mx-2" id="crop">{{ __('main.crop_iamge') }}</button>
                    <button type="button" class="btn btn-default" style="background-color: #cccccc;" data-dismiss="modal">{{ __('main.close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection