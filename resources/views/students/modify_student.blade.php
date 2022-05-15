@extends('layout.layout')
@section('title',  __('main.edit_student') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-graduate"></i> {{ __('main.students') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_student') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_student') }}</h3>
                <form action="{{ route('update_student_data') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" id="add_std_tec">
                    {{ csrf_field() }}
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <div class="form-group">
                        <label>{{ __('main.username') }}</label>
                        <input class="form-control" type="text" name="username" value="{{ $student->username }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.email') }}</label>
                        <input class="form-control" type="text" name="email" value="{{ $student->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.password') }}</label>
                        <input class="form-control" type="password" name="password" placeholder="{{ __('main.change_pass') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.c_password') }}</label>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="{{ __('main.change_pass') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.phone') }}</label>
                        <input class="form-control" type="tel" countries-data="{{ $countries_data }}" id="phone" name="phone" value="{{ $student->phone }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.birthday') }}</label>
                        <input class="form-control birthday_select" type="text" placeholder="{{ __('main.pick_birthday') }}" name="birthday" value="{{ $student->birthday }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.quran_parts') }}</label>
                        <input class="form-control" type="number" name="quran_parts" value="{{ $student->quran_parts }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="level" id="slide_section_select">
                            @if($student->level == null)
                                <option value="null" selected>{{ __('main.notـspecified') }}</option>
                            @else
                                <option value="null">{{ __('main.notـspecified') }}</option>
                            @endif
                            @foreach($levels as $level)
                                @if($student->level_id == $level->id)
                                    <option value="{{ $level->id }}" selected>{{ $level->name }} - {{ $level->level }}</option>
                                @else
                                    <option value="{{ $level->id }}">{{ $level->name }} - {{ $level->level }}</option>
                                @endif
                            @endforeach
                        </select>
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(auth('admins')->user()->permissions->students[5] == 1)
        <div class="row justify-content-center">
            <div class="col-xs-12 col-md-9">
                <div class="tile">
                    <h3 class="tile-title text-center">{{ __('main.student_assig_log') }}</h3>
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
                            @foreach($student_assignment_log as $log)
                                <tr role="row">
                                    <td style="text-align: center;" class="">
                                        <span>{{ $log->user->username }}</span>
                                    </td>
                                    <td style="text-align: center;" class="d-none d-md-table-cell">
                                        <span>{{ \App\Helper\MyHelper::ReturnValueByLang($log->group->name." - ".$log->group->en_name , $log->group->en_name." - ".$log->group->name )}}</span>
                                    </td>
                                    @php
                                        $staus_value = null;

                                        if($log->status == "read")
                                        {
                                            $staus_value = \App\Helper\MyHelper::ReturnValueByLang("قرأ", "Read");
                                        }
                                        else
                                        {
                                            $staus_value = \App\Helper\MyHelper::ReturnValueByLang("لم يقرأ", "Not Read");
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
                        {{ $student_assignment_log->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection