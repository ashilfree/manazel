@extends('layout.layout')
@section('title',  __('main.edit_teacher') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-chalkboard-teacher"></i> {{ __('main.teachers') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_teacher') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_teacher') }}</h3>
                <form action="{{ route('update_teacher_data') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" id="add_std_tec">
                    {{ csrf_field() }}
                    <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                    <div class="form-group">
                        <label>{{ __('main.username') }}</label>
                        <input class="form-control" type="text" name="username" value="{{ $teacher->username }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.email') }}</label>
                        <input class="form-control" type="text" name="email" value="{{ $teacher->email }}" required>
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
                        <input class="form-control" type="tel" countries-data="{{ $countries_data }}" id="phone" name="phone" value="{{ $teacher->phone }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.birthday') }}</label>
                        <input class="form-control birthday_select" type="text" placeholder="{{ __('main.pick_birthday') }}" name="birthday" value="{{ $teacher->birthday }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.quran_parts') }}</label>
                        <input class="form-control" type="number" name="quran_parts" value="{{ $teacher->quran_parts }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.spare_time') }}</label>
                        <input class="form-control" type="number" name="spare_time" value="{{ $teacher->spare_time }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.workـhours') }}</label>
                        <input class="form-control" type="number" name="workـhours" value="{{ $teacher->workـhours }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="level" id="slide_section_select">
                            @if($teacher->level == null)
                                <option value="null" selected>{{ __('main.notـspecified') }}</option>
                            @else
                                <option value="null">{{ __('main.notـspecified') }}</option>
                            @endif
                            @foreach($levels as $level)
                                @if($teacher->level_id == $level->id)
                                    <option value="{{ $level->id }}" selected>{{ $level->name }} - {{ $level->level }}</option>
                                @else
                                    <option value="{{ $level->id }}">{{ $level->name }} - {{ $level->level }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.mogazh') }}</label>
                        <select class="form-control f-size-090 mb-1" name="mogazh" id="slide_section_select">
                            @if($teacher->mogazh == 1)
                                <option value="yes" selected>{{ __('main.yes') }}</option>
                                <option value="no">{{ __('main.no') }}</option>

                            @else
                                <option value="yes">{{ __('main.yes') }}</option>
                                <option value="no" selected>{{ __('main.no') }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.mastery_certificates_num') }}</label>
                        <input class="form-control" type="number" name="mastery_certificates_num" value="{{ $teacher->mastery_certificates }}" required>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.delete_teacher_from_g') }}</h3>
                <div class="level_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.group_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $teacher_groups = \App\Sub_group::where('admin_id', $teacher->id)->get();
                        @endphp
                        @foreach($teacher_groups as $teacher_group)
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ \App\Helper\MyHelper::ReturnValueByLang($teacher_group->name, $teacher_group->en_name) }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->teachers[4] == 1)
                                            <form action="{{ route('delete_teacher_from_group') }}" method="POST" class="delete_g_teacher_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="group_id" value="{{ $teacher_group->id }}">
                                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                <button class="btn btn-primary btn-sm delete_g_teacher_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_teacher_from_g') }}"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection