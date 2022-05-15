@extends('layout.layout')
@section('title', __('main.edit_del_teacher'))

@section('content')
    @php
        //echo Route::current()->getName();
    @endphp
    <div class="app-title">
        <div>
            <h1><i class="fas fa-chalkboard-teacher"></i> {{ __('main.teachers') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.edit_del_teacher') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-12">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.edit_del_teacher') }}</h3>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>{{ __('main.teachers_search') }}</label>
                            <input type="text" name="name" class="form-control f-size-090" id="find_teacher" placeholder="{{ __('main.teachers_search') }}" autocomplete='off'>
                        </div>
                        <div class="form-group">
                            <label>{{ __('main.search_by') }}</label><br>
                            <input class="margin-x5-by-lang" type="radio" name="search_by" value="username" checked> {{ __('main.username') }}<br>
                            <input class="margin-x5-by-lang" type="radio" name="search_by" value="email"> {{ __('main.email') }}<br>
                            <input class="margin-x5-by-lang" type="radio" name="search_by" value="phone"> {{ __('main.phone') }}
                        </div>
                    </div>
                </div>
                <div class="teacher_tl_div table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr role="row">
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.username') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.email') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.phone') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.country') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.birthday') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.quran_parts') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.spare_time') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.workـhours') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.level') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.mogazh') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
                                <span class="wc-image tips">{{ __('main.mastery_certificates') }}</span>
                            </th>
                            <th scope="col" id="thumb" class="text-center">
                                <span class="wc-image tips">{{ __('main.edit') }}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $counter = 0;
                        @endphp
                        @foreach($teachers as $teacher)
                            <tr role="row">
                                <td style="text-align: center;" class="">
                                    <span>{{ $teacher->username }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $teacher->email }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $teacher->phone }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $teacher->country ? \App\Helper\MyHelper::ReturnValueByLang($teacher->country->phone_code." - ".$teacher->country->name , $teacher->country->phone_code." - ".$teacher->country->en_name) : ""}}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $teacher->birthday }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $teacher->quran_parts }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $teacher->spare_time }}</span>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $teacher->workـhours }}</span>
                                </td>
                                @php
                                    $teacher_level = \App\Level::where('id', $teacher->level_id)->first();
                                    $level = null;
                                    if(empty($teacher_level))
                                    {
                                        $level =  __('main.notـspecified');
                                    }
                                    else
                                    {
                                        $level = $teacher_level->name."-".$teacher_level->level;
                                    }
                                $counter++;
                                @endphp
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $level }}</span>
                                </td>
                                @php
                                    $mogaza =  __('main.no');
                                    if($teacher->mogazh == 1)
                                    {
                                        $mogaza =  __('main.yes');
                                    }
                                @endphp
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $mogaza }}</span>
                                </td>
                                </td>
                                <td style="text-align: center;" class="d-none d-md-table-cell">
                                    <span>{{ $teacher->mastery_certificates }}</span>
                                </td>
                                <td style="text-align: center;" class="">
                                    <div class="btn-group">
                                        @if(auth('admins')->user()->permissions->teachers[4] == 1)
                                            <button class="btn btn-primary btn-sm delete_sub_group_btn" data-toggle="modal" data-target="#change_group{{ $counter }}" title="{{ __('main.add_teacher_groups') }}"><i class="fas fa-plus no-margin"></i></button>
                                        @endif
                                        @if(auth('admins')->user()->permissions->teachers[3] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('change_teacher_level', $teacher->id) }}" title="{{ __('main.select_teacher_level') }}"><i class="fas fa-sort-numeric-up no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->teachers[5] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('notify_teacher', $teacher->id) }}" title="{{ __('main.send_teacher_notification') }}"><i class="fas fa-bell no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->teachers[1] == 1)
                                            <a class="btn btn-primary btn-sm" href="{{ route('modify_teacher', $teacher->id) }}" title="{{ __('main.edit_teacher') }}"><i class="fas fa-edit no-margin"></i></a>
                                        @endif
                                        @if(auth('admins')->user()->permissions->teachers[2] == 1)
                                            <form action="{{ route('delete_teacher') }}" method="POST" class="delete_teacher_form">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                <button class="btn btn-primary btn-sm delete_teacher_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_acc') }}"></i></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @if(auth('admins')->user()->permissions->teachers[4] == 1)
                                <!-- Modal -->
                                @php
                                    $main_group = \App\Group::where('level_id', $teacher->level_id)->first();

                                    $groups = array();
                                    if(!empty($main_group))
                                    {
                                        $groups = \App\Sub_group::where('group_id', $main_group->id)->where('admin_id', null)->get();
                                    }
                                @endphp
                                <div class="modal fade" id="change_group{{ $counter }}" tabindex="-1" role="dialog" aria-labelledby="select_teacher_model" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">{{ __('main.add_teacher_groups') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('add_teacher_to_groups') }}" method="post" enctype="application/x-www-form-urlencoded">
                                                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                                {{ csrf_field() }}
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <select class="chosen-select form-control" name="group_id" data-placeholder="{{ __('main.select_group') }}">
                                                            <option value=""></option>
                                                            @foreach($groups as $group)
                                                                <option value="{{ $group->id }}">{{ \App\Helper\MyHelper::ReturnValueByLang($group->name, $group->en_name) }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="direction: ltr;">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.close') }}</button>
                                                    <button type="submit" class="btn btn-primary">{{ __('main.add') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    {{ $teachers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection