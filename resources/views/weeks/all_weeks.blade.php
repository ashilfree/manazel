@extends('layout.layout')
@section('title', __('main.edit_del_week'))

@section('content')
    @php
        //echo Route::current()->getName();
        //var_dump(session()->get('lang'));
        //var_dump(app()->getLocale());
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-calendar-alt"></i> {{ __('main.weeks') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_del_week') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_del_week') }}</h3>
                <div class="homework_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.week_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.week_name_en') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.week_number_num') }}</span>
                            </th>
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
                        @foreach($weeks as $week)
                            @php
                                //$level = \App\Level::find($homework->level_id);
                            @endphp
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ $week->week_name }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <span>{{ $week->week_en_name }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <span>{{ $week->week_number }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    @if($week->sub_level)
                                        <span>{{ $week->sub_level->name }} - {{ $week->sub_level->en_name }}</span>
                                    @endif
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <a href="{{ $week->homework_file_url }}" style="font-weight: bold; text-decoration: underline;" target="_blank">{{ __('main.the_file') }}</a>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <a href="{{ $week->tajweed_link }}" style="font-weight: bold; text-decoration: underline;" target="_blank">{{ $week->tajweed_link }}</a>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <a href="{{ $week->tafsir_link }}" style="font-weight: bold; text-decoration: underline;" target="_blank">{{ $week->tafsir_link }}</a>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->home_work[1] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_week', $week->id) }}" title="{{ __('main.edit_homework') }}"><i class="fas fa-edit no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->home_work[2] == 1)
                                            <form action="{{ route('delete_week') }}" method="POST" class="delete_week_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="week_id" value="{{ $week->id }}">
                                                <button class="btn btn-primary btn-sm delete_week_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_homework') }}"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $weeks->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
