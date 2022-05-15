@extends('layout.layout')
@section('title', __('main.contact_us'))

@section('content')
    @php
        //echo Route::current()->getName();
        //var_dump(session()->get('lang'));
        //var_dump(app()->getLocale());
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-cog"></i> {{ __('main.settings') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.contact_us') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.contact_us') }}</h3>
                <div class="homework_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.phone') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.message') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contact_us_messages as $message)
                            @php
                                //$level = \App\Level::find($homework->level_id);
                            @endphp
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ $message->name }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <span>{{ $message->phone_number }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <span>{{ $message->message }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->settings[4] == 1)
                                            <form action="{{ route('delete_contact_us') }}" method="POST" class="delete_contact_us_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="contact_us_id" value="{{ $message->id }}">
                                                <button class="btn btn-primary btn-sm delete_contact_us_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_contact_us') }}"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $contact_us_messages->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection