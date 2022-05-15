@extends('layout.layout')
@section('title', __('main.app_login_logs'))

@section('content')
    @php
        //echo Route::current()->getName();
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-cog"></i> {{ __('main.app_login_logs') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.app_login_logs') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.app_login_logs') }}</h3>
                <div class="admin_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.username') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.status') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.time') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($login_logs as $log)
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ $log->user ? $log->user->username : "" }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    @php
                                        $status = null;
                                        if($log->type == "login")
                                        {
                                            $status = __('main.login');
                                        }
                                        else
                                        {
                                            $status = __('main.logout');
                                        }
                                    @endphp
                                    <span>{{ $status }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ \App\Helper\MyHelper::ChangeTimestampFormat($log->created_at) }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $login_logs->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection