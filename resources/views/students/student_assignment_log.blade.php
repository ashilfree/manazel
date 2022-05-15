@extends('layout.layout')
@section('title', __('main.student_assignment_log'))

@section('content')
    @php
        //echo Route::current()->getName();
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-graduate"></i> {{ __('main.students') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.student_assignment_log') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.student_assignment_log') }}</h3>
                <div class="student_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.student_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.group') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.status') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.date') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assignments_log as $log)
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                  @if($log->user)
                                    <span>{{ $log->user->username }}</span>
                                  @endif
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    @if($log->group)
                                      <span>{{ \App\Helper\MyHelper::ReturnValueByLang($log->group->name." - ".$log->group->en_name , $log->group->en_name." - ".$log->group->name )}}</span>
                                    @endif
                                </td>
                                @php
                                    $staus_value = null;

                                    if($log->status == "read")
                                    {
                                        $staus_value = \App\Helper\MyHelper::ReturnValueByLang("قرأ", "Read");
                                    }
                                    elseif($log->status == "not read")
                                    {
                                        $staus_value = \App\Helper\MyHelper::ReturnValueByLang("لم يقرأ", "Not Read");
                                    }
                                    elseif ($log->status == "trmim")
                                    {
                                        $staus_value = \App\Helper\MyHelper::ReturnValueByLang("ترميم", "Trmim");
                                    }
                                    elseif ($log->status == "stopped")
                                    {
                                        $staus_value = \App\Helper\MyHelper::ReturnValueByLang("متوقف", "Stopped");
                                    }
                                @endphp
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $staus_value }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ \App\Helper\MyHelper::ChangeTimestampFormat($log->created_at) }}</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $assignments_log->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
