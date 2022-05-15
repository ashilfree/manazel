@extends('layout.layout')
@section('title',  __('main.edit_sub_group') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="far fa-object-group"></i> {{ __('main.sub_groups') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_sub_group') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_sub_group') }}</h3>
                <form action="{{ route('update_sub_groups_data') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <input type="hidden" name="sub_group_id" value="{{ $group->id }}">
                    <div class="form-group">
                        <label>{{ __('main.ar_sub_group_name') }}</label>
                        <input class="form-control" type="text" name="group_name" value="{{ $group->name }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.en_sub_group_name') }}</label>
                        <input class="form-control" type="text" name="en_group_name" value="{{ $group->en_name }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.sub_group_student_num') }}</label>
                        <input class="form-control" type="number" name="group_student_num" value="{{ $group->max_students }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.ch_mains_groups') }}</label>
                        <select class="form-control f-size-090 mb-1" name="main_group" id="slide_section_select">
                            @php
                                $main_group_id = null;
                            @endphp
                            @foreach($main_groups as $main_group)
                                @if($main_group->id == $group->group_id)
                                    @php
                                        $main_group_data = $main_group;
                                    @endphp
                                    <option value="{{ $main_group->id }}" selected>
                                        @if(app()->getLocale() == "ar")
                                            {{ $main_group->name }} - {{ $main_group->en_name }}
                                        @else
                                            {{ $main_group->en_name }} - {{ $main_group->name }}
                                        @endif
                                    </option>
                                @else
                                    <option value="{{ $main_group->id }}">
                                        @if(app()->getLocale() == "ar")
                                            {{ $main_group->name }} - {{ $main_group->en_name }}
                                        @else
                                            {{ $main_group->en_name }} - {{ $main_group->name }}
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <small class="form-text text-muted">{{ __('main.ch_main_group_alert') }}</small>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.select_current_week') }}</label>
                        <select class="form-control f-size-090 mb-1" name="week" id="week_select">
                            <option value="">{{ __('main.select_later') }}</option>
                            @php
                                $weeks = \App\Week::where('sub_level_id', $main_group_data->sub_level_id)->get();
                            @endphp
                            @foreach($weeks as $week)
                                @if($group->week_id == $week->id)
                                    <option value="{{ $week->id }}" selected>
                                        @if(app()->getLocale() == "ar")
                                            {{ $week->week_name }}
                                        @else
                                            {{ $week->week_en_name }}
                                        @endif
                                    </option>
                                @else
                                    <option value="{{ $week->id }}">
                                        @if(app()->getLocale() == "ar")
                                            {{ $week->week_name }}
                                        @else
                                            {{ $week->week_en_name }}
                                        @endif
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.edit') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if(auth('admins')->user()->permissions->students[4] == 1)
        <div class="row justify-content-center">
            <div class="col-xs-12 col-md-9">
                <div class="tile">
                    <h3 class="tile-title text-center">{{ __('main.group_students') }}</h3>
                    <div class="level_tl_div table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr role="row">
                                <th scope="col" id="thumb" class="text-center">
                                    <span class="wc-image tips">{{ __('main.student_name') }}</span>
                                </th>
                                <th scope="col" id="thumb" class="text-center">
                                    <span class="wc-image tips">{{ __('main.edit') }}</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    $group_students = \App\Users_group::where('sub_group_id', $group->id)->get();
                                    $counter = 0;
                                @endphp
                                @foreach($group_students as $group_student)
                                    @php
                                        $counter++;
                                    @endphp
                                    <tr role="row">
                                        <td style="text-align: center;" class="">
                                            <a href="{{ route('modify_student', $group_student->user->id) }}" style="font-weight: bold; text-decoration: underline;">{{ $group_student->user->username }}</a>
                                        </td>
                                        <td style="text-align: center;" class="">
                                            <div class="btn-group">
                                                @if(auth('admins')->user()->permissions->students[4] == 1)
                                                    <button class="btn btn-primary btn-sm delete_sub_group_btn" data-toggle="modal" data-target="#change_group{{ $counter }}" title="{{ __('main.change_student_group') }}"><i class="fas fa-arrows-alt no-margin"></i></button>
                                                    <form action="{{ route('delete_student_from_group') }}" method="POST" class="delete_g_student_form">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="group_id" value="{{ $group->id }}">
                                                        <input type="hidden" name="student_id" value="{{ $group_student->user->id }}">
                                                        <button class="btn btn-primary btn-sm delete_g_student_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_student_from_g') }}"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @if(auth('admins')->user()->permissions->students[4] == 1)
                                        <!-- Modal -->
                                        @php
                                            $main_group = \App\Group::where('sub_level_id', $group_student->user->sub_level_id)->first();
                                            $student_group = \App\Users_group::where('user_id', $group_student->user->id)->first();

                                            $groups = array();
                                            if(!empty($main_group))
                                            {
                                                $groups = \App\Sub_group::where('group_id', $main_group->id)->get();
                                            }
                                        @endphp
                                        <div class="modal fade" id="change_group{{ $counter }}" tabindex="-1" role="dialog" aria-labelledby="select_teacher_model" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">{{ __('main.change_student_group') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('change_student_group') }}" method="post" enctype="application/x-www-form-urlencoded">
                                                        <input type="hidden" name="student_id" value="{{ $group_student->user->id }}">
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <select class="chosen-select form-control" name="group_id" data-placeholder="{{ __('main.select_group') }}">
                                                                    <option value=""></option>
                                                                    @foreach($groups as $group)
                                                                        @if($group->id == $student_group->sub_group_id)
                                                                            <option value="{{ $group->id }}" selected>{{ \App\Helper\MyHelper::ReturnValueByLang($group->name, $group->en_name) }}</option>
                                                                        @else
                                                                            <option value="{{ $group->id }}">{{ \App\Helper\MyHelper::ReturnValueByLang($group->name, $group->en_name) }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer" style="direction: ltr;">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.close') }}</button>
                                                            <button type="submit" class="btn btn-primary">{{ __('main.change') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if(auth('admins')->user()->permissions->sub_groups[4] == 1)
        <div class="row justify-content-center" id="sub_group_students">
            <div class="col-xs-12 col-md-9">
                <div class="tile">
                    <h3 class="tile-title text-center">{{ __('main.select_sub_group_students') }}</h3>
                    <div class="level_tl_div table-responsive">
                        <form action="{{ route('add_group_students') }}" role="form" method="post" enctype="application/x-www-form-urlencoded">
                            <input type="hidden" name="group_id" value="{{ $group->id }}">
                            {{ csrf_field() }}
                            <table class="table table-bordered">
                                <thead>
                                <tr role="row">
                                    <th scope="col" id="thumb" class="text-center">
                                        <span class="wc-image tips">{{ __('main.select') }}</span>
                                    </th>
                                    <th scope="col" id="thumb" class="text-center">
                                        <span class="wc-image tips">{{ __('main.student_name') }}</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    //$students = \App\User::where('type', 'student')->where('level_id', $sub_groups[$i]->main_group->level_id)->get();
                                    $students = \App\User::where('type', 'student')->where('sub_level_id', $group->main_group->sub_level_id)->whereNotIn('id',function($query)
                                    {
                                        $query->select('user_id')->from('users_groups');
                                    })->get();
                                @endphp
                                @foreach($students as $student)
                                    <tr role="row">
                                        <td style="text-align: center;" class="">
                                            <input type="checkbox" name="students_id[]" value="{{ $student->id }}" class="js-switch" />
                                        </td>
                                        <td style="text-align: center;" class="">
                                            <a href="{{ route('modify_student', $student->id) }}" style="font-weight: bold; text-decoration: underline;">{{ $student->username }}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="tile-footer">
                                <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection