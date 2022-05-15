@extends('layout.layout')
@section('title', __('main.add_homework'))

@section('content')
    @php
        //echo Route::current()->getName();
        //var_dump(session()->get('lang'));
        //var_dump(app()->getLocale());
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-flag"></i> {{ __('main.homework') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.homework') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.homework') }}</h3>
                <div class="homework_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.the_level') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.homework_file') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.tajweed_link') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.tafsir_link') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($homeworks as $homework)
                            @php
                                //$level = \App\Level::find($homework->level_id);
                            @endphp
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ $homework->level->name }} - {{ $homework->level->en_name }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <a href="{{ asset("resources/homework_files/$homework->file_name") }}" style="font-weight: bold; text-decoration: underline;">{{ __('main.the_file') }}</a>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <a href="{{ $homework->file_url }}" style="font-weight: bold; text-decoration: underline;">{{ $homework->tajweed_link }}</a>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <a href="{{ $homework->file_url }}" style="font-weight: bold; text-decoration: underline;">{{ $homework->tafsir_link }}</a>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->home_work[1] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_homework', $homework->id) }}" title="{{ __('main.edit_homework') }}"><i class="fas fa-edit no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->home_work[2] == 1)
                                            <form action="{{ route('delete_homework') }}" method="POST" class="delete_homework_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="homework_id" value="{{ $homework->id }}">
                                                <button class="btn btn-primary btn-sm delete_homework_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_homework') }}"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $homeworks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
