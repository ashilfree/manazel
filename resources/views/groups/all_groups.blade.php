@extends('layout.layout')
@section('title', __('main.groups'))

@section('content')
    @php
        //echo Route::current()->getName();
        //var_dump(session()->get('lang'));
        //var_dump(app()->getLocale());
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-object-ungroup"></i> {{ __('main.groups') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.groups') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.groups') }}</h3>
                <div class="homework_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.group_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.the_level') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.sub_level') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $group)
                            @php
                                //$level = \App\Level::find($homework->level_id);
                            @endphp
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>
                                        @if(app()->getLocale() == "ar")
                                            {{ $group->name }} - {{ $group->en_name }}
                                        @else
                                            {{ $group->en_name }} - {{ $group->name }}
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>
                                        @if(app()->getLocale() == "ar")
                                            {{ $group->level->name }} - {{ $group->level->level }}
                                        @else
                                            {{ $group->level->en_name }} - {{ $group->level->en_level }}
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>
                                        @if(app()->getLocale() == "ar")
                                            {{ $group->sub_level ? $group->sub_level->name : __('main.no_sub_level') }}
                                        @else
                                            {{ $group->sub_level ? $group->sub_level->en_name : __('main.no_sub_level') }}
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->groups[1] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_group', $group->id) }}" title="{{ __('main.edit_group') }}"><i class="fas fa-edit no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->groups[2] == 1)
                                            <form action="{{ route('delete_group') }}" method="POST" class="delete_group_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                                <button class="btn btn-primary btn-sm delete_group_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_group') }}"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $groups->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection