@extends('layout.layout')
@section('title', __('main.edit_del_admin'))

@section('content')
    @php
        //echo Route::current()->getName();
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-cog"></i> {{ __('main.admins_acc') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_del_admin') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_del_admin') }}</h3>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>{{ __('main.acc_search') }}</label>
                            <input type="text" name="name" class="form-control f-size-090" id="find_admin" placeholder="{{ __('main.acc_search') }}" autocomplete='off'>
                        </div>
                        <div class="form-group">
                            <label>{{ __('main.search_by') }}</label><br>
                            <input class="margin-x5-by-lang" type="radio" name="search_by" value="username" checked> {{ __('main.username') }}<br>
                            <input class="margin-x5-by-lang" type="radio" name="search_by" value="full_name"> {{ __('main.full_name') }}
                        </div>
                    </div>
                </div>
                <div class="admin_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.username') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.full_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($admins as $admin)
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ $admin->username }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $admin->full_name }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->admins[3] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_admin_permissions', $admin->id) }}" title="{{ __('main.change_perm') }}"><i class="fas fa-lock no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->admins[1] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_admin', $admin->id) }}" title="{{ __('main.edit_admin') }}"><i class="fas fa-edit no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->admins[2] == 1)
                                            <form action="{{ route('delete_admin') }}" method="POST" class="delete_admin_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                                                <button class="btn btn-primary btn-sm delete_admin_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_acc') }}"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection