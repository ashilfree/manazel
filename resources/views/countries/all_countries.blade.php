@extends('layout.layout')
@section('title', __('main.edit_del_country'))

@section('content')
    @php
        //echo Route::current()->getName();
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-flag"></i> {{ __('main.countries') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_del_country') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_del_country') }}</h3>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>{{ __('main.country_search') }}</label>
                            <input type="text" name="name" class="form-control f-size-090" id="find_country" placeholder="{{ __('main.enter_country_name') }}" autocomplete='off'>
                        </div>
                    </div>
                </div>
                <div class="country_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.country_ar_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.country_en_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.country_code') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($countries as $country)
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ $country->name }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $country->en_name }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $country->country_code }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->countries[1] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_country', $country->id) }}" title="{{ __('main.edit_country') }}"><i class="fas fa-edit no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->countries[2] == 1)
                                            <form action="{{ route('delete_country') }}" method="POST" class="delete_country_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="country_id" value="{{ $country->id }}">
                                                <button class="btn btn-primary btn-sm delete_country_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_country') }}"></i></button>
                                            </form>
                                         @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $countries->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection