@extends('layout.layout')
@section('title', __('main.edit_del_level'))

@section('content')
    @php
        //echo Route::current()->getName();
        //var_dump(session()->get('lang'));
        //var_dump(app()->getLocale());
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-flag"></i> {{ __('main.levels') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_del_level') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_del_level') }}</h3>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>{{ __('main.level_search') }}</label>
                            <input type="text" name="name" class="form-control f-size-090" id="find_level" placeholder="{{ __('main.level_name_by_lang') }}" autocomplete='off'>
                        </div>
                    </div>
                </div>
                <div class="level_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.level_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.the_level') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($levels as $level)
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ $level->name }} - {{ $level->en_name }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $level->level }} - {{ $level->en_level }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->levels[1] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_level', $level->id) }}" title="{{ __('main.edit_level') }}"><i class="fas fa-edit no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->levels[2] == 1)
                                            <form action="{{ route('delete_level') }}" method="POST" class="delete_level_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="level_id" value="{{ $level->id }}">
                                                <button class="btn btn-primary btn-sm delete_level_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_level') }}"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $levels->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection