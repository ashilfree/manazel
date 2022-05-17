@extends('layout.layout')
@section('title', __('main.edit_del_sub_group'))

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
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_del_sub_group') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_del_sub_group') }}</h3>
                <div class="homework_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.group_name') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.main_group') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.group_level') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.group_current_week') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.sub_group_teacher') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.sub_group_student_num') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.group_status') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i < count($sub_groups); $i++)
                            @php
                                //$level = \App\Level::find($homework->level_id);
                            @endphp
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>
                                        @if(app()->getLocale() == "ar")
                                            {{ $sub_groups[$i]->name }} - {{ $sub_groups[$i]->en_name }}
                                        @else
                                            {{ $sub_groups[$i]->en_name }} - {{ $sub_groups[$i]->name }}
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>
                                        @if(app()->getLocale() == "ar")
                                            {{ $sub_groups[$i]->main_group->name }} - {{ $sub_groups[$i]->main_group->en_name }}
                                        @else
                                            {{ $sub_groups[$i]->main_group->en_name }} - {{ $sub_groups[$i]->main_group->name }}
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>
                                        @if(app()->getLocale() == "ar")
                                            <a href="{{ route('modify_level', $sub_groups[$i]->main_group->level ? $sub_groups[$i]->main_group->level : "") }}" style="font-weight: bold; text-decoration: underline;">{{ $sub_groups[$i]->main_group->level->name }}</a>
                                            {{ $sub_groups[$i]->main_group->sub_level ? " --> " : "" }}
                                            <a href="{{ route('modify_level', $sub_groups[$i]->main_group->sub_level ? $sub_groups[$i]->main_group->sub_level : "") }}" style="font-weight: bold; text-decoration: underline;">{{ $sub_groups[$i]->main_group->sub_level ? $sub_groups[$i]->main_group->sub_level->name : "" }}</a>
                                        @else
                                            <a href="{{ route('modify_level', $sub_groups[$i]->main_group->level ? $sub_groups[$i]->main_group->level : "") }}" style="font-weight: bold; text-decoration: underline;">{{ $sub_groups[$i]->main_group->level->en_name }}</a>
                                            {{ $sub_groups[$i]->main_group->sub_level ? " --> " : "" }}
                                            <a href="{{ route('modify_level', $sub_groups[$i]->main_group->sub_level ? $sub_groups[$i]->main_group->sub_level : "") }}" style="font-weight: bold; text-decoration: underline;">{{ $sub_groups[$i]->main_group->sub_level ? $sub_groups[$i]->main_group->sub_level->en_name : "" }}</a>
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>
                                        @if(app()->getLocale() == "ar")
                                            <a href="{{ route('modify_week', $sub_groups[$i]->week ? $sub_groups[$i]->week->id : "") }}" style="font-weight: bold; text-decoration: underline;">{{ $sub_groups[$i]->week ? $sub_groups[$i]->week->week_name : "" }}</a>
                                        @else
                                            <a href="{{ route('modify_week', $sub_groups[$i]->week ? $sub_groups[$i]->week->id : "") }}" style="font-weight: bold; text-decoration: underline;">{{ $sub_groups[$i]->week ? $sub_groups[$i]->week->week_en_name : "" }}</a>
                                        @endif
                                    </span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <a href="{{ route('modify_teacher', $sub_groups[$i]->teacher ? $sub_groups[$i]->teacher->id : "") }}" style="font-weight: bold; text-decoration: underline;">{{ $sub_groups[$i]->teacher ? $sub_groups[$i]->teacher->username : "" }}</a>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $sub_groups[$i]->max_students }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    @php
                                        $status = null;
                                        $status_text = null;

                                        $now = \Carbon\Carbon::now();
                                        if($sub_groups[$i]->ban_to > $now && $sub_groups[$i]->ban_from < $now)
                                        {
                                            $status_text = __('main.stopped');
                                            $status = false;
                                        }
                                        else
                                        {
                                            $status_text = __('main.work');
                                            $status = true;
                                        }
                                    @endphp
                                    <span style="font-weight:bold;color: {{ $status ? 'green' : 'red' }}">{{ $status_text }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->sub_groups[3] == 1)
                                            <button class="btn btn-primary btn-sm delete_sub_group_btn" data-toggle="modal" data-target="#select_teacher_model{{ $i }}" title="{{ __('main.select_sub_group_teacher') }}"><i class="fas fa-chalkboard-teacher no-margin"></i></button>
                                        @endif
                                        @if(auth('admins')->user()->permissions->sub_groups[4] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_sub_group', $sub_groups[$i]->id). '#sub_group_students' }}" title="{{ __('main.select_sub_group_students') }}"><i class="fas fa-user-graduate no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->sub_groups[1] == 1)
                                            <a class="btn btn-primary btn-sm" style="color: #FFFFFF" data-toggle="modal" data-target="#ban_group_model{{ $i }}" title="{{ __('main.ban_group') }}"><i class="far fa-calendar-times no-margin"></i></a>
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_sub_group', $sub_groups[$i]->id) }}" title="{{ __('main.edit_group') }}"><i class="fas fa-edit no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->sub_groups[2] == 1)
                                            <form action="{{ route('delete_sub_group') }}" method="POST" class="delete_sub_group_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="sub_group_id" value="{{ $sub_groups[$i]->id }}">
                                                <button class="btn btn-primary btn-sm delete_sub_group_btn btn-border-red" type="submit" title="{{ __('main.delete_group') }}"><i class="far fa-trash-alt no-margin"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @if(auth('admins')->user()->permissions->sub_groups[3] == 1)
                                <!-- Modal -->
                                @php
                                    $teachers = \App\User::where('type', 'teacher')->where('level_id', $sub_groups[$i]->main_group->level_id)->get();
                                @endphp
                                <div class="modal fade" id="select_teacher_model{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="select_teacher_model" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('main.select_sub_group_teacher') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('change_group_teacher') }}" method="post" enctype="application/x-www-form-urlencoded">
                                                <input type="hidden" name="group_id" value="{{ $sub_groups[$i]->id }}">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <select class="chosen-select form-control" name="teacher_id" data-placeholder="{{ __('main.select_teacher') }}">
                                                            <option value=""></option>
                                                            @foreach($teachers as $teacher)
                                                                @if($teacher->id == $sub_groups[$i]->admin_id)
                                                                    <option value="{{ $teacher->id }}" selected>{{ $teacher->username }}</option>
                                                                @else
                                                                    <option value="{{ $teacher->id }}">{{ $teacher->username }}</option>
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
                            @if(auth('admins')->user()->permissions->sub_groups[1] == 1)
                                <!-- Modal -->
                                @php
                                    $teachers = \App\User::where('type', 'teacher')->where('level_id', $sub_groups[$i]->main_group->level_id)->get();
                                @endphp
                                <div class="modal fade" id="ban_group_model{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="ban_group_model" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('main.ban_group') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('ban_group') }}" method="post" enctype="application/x-www-form-urlencoded" id="group_stop_form">
                                                <input type="hidden" name="group_id" value="{{ $sub_groups[$i]->id }}">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div style="display: flex;">
                                                        <div class="form-group" style="flex: 1;margin: 0px 5px;">
                                                            <label>{{ __('main.from') }}</label>
                                                            <input class="form-control birthday_select" type="text" placeholder="{{ __('main.pick_birthday') }}" name="ban_from" value="{{ old('birthday') }}" required>
                                                        </div>
                                                        <div class="form-group" style="flex: 1;margin: 0px 5px;">
                                                            <label>{{ __('main.to') }}</label>
                                                            <input class="form-control birthday_select" type="text" placeholder="{{ __('main.pick_birthday') }}" name="ban_to" value="{{ old('birthday') }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="modal-footer" style="direction: ltr;justify-content: space-between;">
                                                <div>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.close') }}</button>
                                                    <button type="button" class="btn btn-primary" id="submit_dates">{{ __('main.change') }}</button>
                                                </div>
                                                @if(!$status)
                                                    <form action="{{ route('activate_group') }}" method="post" enctype="application/x-www-form-urlencoded">
                                                        <input type="hidden" name="group_id" value="{{ $sub_groups[$i]->id }}">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-primary" style="background-color: green;border-color: green;" group="{{ $sub_groups[$i]->id }}">{{ __('main.activate_group') }}</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endfor
                        </tbody>
                    </table>
                    {{ $sub_groups->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
