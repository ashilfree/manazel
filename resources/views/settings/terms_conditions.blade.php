@extends('layout.layout')
@section('title',  __('main.terms_conditions') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-cog"></i> {{ __('main.settings') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.terms_conditions') }}</a></li>
        </ul>
    </div>
    @if(!$terms_conditions)
        <div class="row justify-content-center">
            <div class="col-xs-12 col-md-9">
                <div class="tile">
                    <h3 class="tile-title text-center">{{ __('main.add_terms_conditions') }}</h3>
                    <form action="{{ route('set_terms_conditions') }}" role="form" method="post" enctype="multipart/form-data" class="image_crop_form">
                        {{ csrf_field() }}
                        <input type="hidden" id="filename" name="filename" /> <!-- Filename -->
                        <div class="form-group">
                            <label>{{ __('main.ar_terms_conditions') }}</label>
                            <textarea id="summernote" name="ar_terms_conditions"></textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('main.en_terms_conditions') }}</label>
                            <textarea id="summernote2" name="en_terms_conditions"></textarea>
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
                    <h3 class="tile-title text-center">{{ __('main.edit_terms_conditions') }}</h3>
                    <form action="{{ route('set_terms_conditions') }}" role="form" method="post" enctype="multipart/form-data" class="image_crop_form">
                        {{ csrf_field() }}
                        <input type="hidden" id="filename" name="filename" /> <!-- Filename -->
                        <input type="hidden" name="terms_conditions_id" value="{{ $terms_conditions->id }}" /> <!-- Filename -->
                        <div class="form-group">
                            <label>{{ __('main.ar_terms_conditions') }}</label>
                            <textarea id="summernote" name="ar_terms_conditions">{{ $terms_conditions->setting }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>{{ __('main.en_terms_conditions') }}</label>
                            <textarea id="summernote2" name="en_terms_conditions">{{ $terms_conditions->setting2 }}</textarea>
                        </div>
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection