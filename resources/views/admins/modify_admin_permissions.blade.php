@extends('layout.layout')
@section('title',  __('main.change_perm') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-cog"></i> {{ __('main.admins_acc') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.change_perm') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.change_perm') }}</h3>
                <form action="{{ route('change_permissions') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <input type="hidden" name="permissions_id" value="{{ $permissions->id }}">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="acc_prem_h3">{{ __('main.acc_prem') }} ({{ $admin->username }})</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mx-0">
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-tachometer-alt"></i> <span class="f_size-17">{{ __('main.c_panel') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.accessـtoـsta') }}</span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->statistics[0] == "1")
                                                        <input type="checkbox" name="statistics_access" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="statistics_access" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->statistics[1] == "1")
                                                        <input type="checkbox" name="send_notification" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="send_notification" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-chalkboard-teacher"></i> <span class="f_size-17">{{ __('main.teachers') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_teacher') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->teachers[0] == "1")
                                                        <input type="checkbox" name="add_teacher" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_teacher" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_teacher') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->teachers[1] == "1")
                                                        <input type="checkbox" name="edit_teacher_data" class="js-switch" checked/>

                                                    @else
                                                        <input type="checkbox" name="edit_teacher_data" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_teacher') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->teachers[2] == "1")
                                                        <input type="checkbox" name="delete_teacher" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_teacher" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.select_teacher_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->teachers[3] == "1")
                                                        <input type="checkbox" name="select_teacher_level" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="select_teacher_level" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.change_teacher_groups') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->teachers[4] == "1")
                                                        <input type="checkbox" name="change_teacher_groups" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="change_teacher_groups" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_all_teachers_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->teachers[5] == "1")
                                                        <input type="checkbox" name="send_all_teachers_notification" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="send_all_teachers_notification" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_teacher_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->teachers[6] == "1")
                                                        <input type="checkbox" name="send_teacher_notification" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="send_teacher_notification" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-user-graduate"></i> <span class="f_size-17">{{ __('main.students') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_student') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->students[0] == "1")
                                                        <input type="checkbox" name="add_student" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_student" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_student') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->students[1] == "1")
                                                        <input type="checkbox" name="edit_student_data" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_student_data" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_student') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->students[2] == "1")
                                                        <input type="checkbox" name="delete_student" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_student" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.select_student_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->students[3] == "1")
                                                        <input type="checkbox" name="select_student_level" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="select_student_level" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.change_student_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->students[4] == "1")
                                                        <input type="checkbox" name="change_student_group" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="change_student_group" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.student_assignment_log') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->students[5] == "1")
                                                        <input type="checkbox" name="student_assignment_log" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="student_assignment_log" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_all_students_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->students[6] == "1")
                                                        <input type="checkbox" name="send_all_students_notification" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="send_all_students_notification" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_student_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->students[7] == "1")
                                                        <input type="checkbox" name="send_student_notification" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="send_student_notification" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-user-cog"></i> <span class="f_size-17">{{ __('main.admins_acc') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_admin') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->admins[0] == "1")
                                                        <input type="checkbox" name="add_admin" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_admin" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_admin') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->admins[1] == "1")
                                                        <input type="checkbox" name="edit_admin_data" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_admin_data" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.change_perm') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->admins[3] == "1")
                                                        <input type="checkbox" name="change_admin_perm" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="change_admin_perm" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_admin') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->admins[2] == "1")
                                                        <input type="checkbox" name="delete_admin" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_admin" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-flag"></i> <span class="f_size-17">{{ __('main.countries') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_country') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->countries[0] == "1")
                                                    <input type="checkbox" name="add_country" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_country" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_country') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->countries[1] == "1")
                                                        <input type="checkbox" name="edit_country_data" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_country_data" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_country') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->countries[2] == "1")
                                                        <input type="checkbox" name="delete_country" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_country" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-sort-numeric-up"></i> <span class="f_size-17">{{ __('main.levels') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->levels[0] == "1")
                                                        <input type="checkbox" name="add_level" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_level" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->levels[1] == "1")
                                                        <input type="checkbox" name="edit_level_data" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_level_data" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->levels[2] == "1")
                                                        <input type="checkbox" name="delete_level" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_level" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-sort-amount-down"></i> <span class="f_size-17">{{ __('main.sub_levels') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_sub_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->sub_levels[0] == "1")
                                                        <input type="checkbox" name="add_sub_level" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_sub_level" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_sub_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->sub_levels[1] == "1")
                                                        <input type="checkbox" name="edit_sub_level" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_sub_level" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_sub_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->sub_levels[2] == "1")
                                                        <input type="checkbox" name="delete_sub_level" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_sub_level" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-tasks"></i> <span class="f_size-17">{{ __('main.homework') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_homework') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->home_work[0] == "1")
                                                        <input type="checkbox" name="add_homework" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_homework" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_homework') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->home_work[1] == "1")
                                                        <input type="checkbox" name="edit_homework_data" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_homework_data" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_homework') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->home_work[2] == "1")
                                                        <input type="checkbox" name="delete_homework" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_homework" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-object-ungroup"></i> <span class="f_size-17">{{ __('main.groups') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->groups[0] == "1")
                                                        <input type="checkbox" name="add_group" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_group" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->groups[1] == "1")
                                                        <input type="checkbox" name="edit_group_data" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_group_data" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->groups[2] == "1")
                                                        <input type="checkbox" name="delete_group" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_group" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon far fa-object-group"></i> <span class="f_size-17">{{ __('main.sub_groups') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->sub_groups[0] == "1")
                                                        <input type="checkbox" name="add_sub_group" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_sub_group" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->sub_groups[1] == "1")
                                                        <input type="checkbox" name="edit_sub_group_data" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_sub_group_data" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->sub_groups[2] == "1")
                                                        <input type="checkbox" name="delete_sub_group" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_sub_group" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.select_sub_group_teacher') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->sub_groups[3] == "1")
                                                        <input type="checkbox" name="select_sub_group_teacher" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="select_sub_group_teacher" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.select_sub_group_students') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->sub_groups[4] == "1")
                                                        <input type="checkbox" name="select_sub_group_students" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="select_sub_group_students" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-cog"></i> <span class="f_size-17">{{ __('main.settings') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.ayat_test') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->settings[0] == "1")
                                                        <input type="checkbox" name="ayat_test" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="ayat_test" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.app_guide') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->settings[1] == "1")
                                                        <input type="checkbox" name="app_guide" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="app_guide" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.about_us') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->settings[2] == "1")
                                                        <input type="checkbox" name="about_us" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="about_us" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.terms_conditions') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->settings[3] == "1")
                                                        <input type="checkbox" name="terms_conditions" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="terms_conditions" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.contact_us') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->settings[4] == "1")
                                                        <input type="checkbox" name="contact_us" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="contact_us" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.support') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->settings[5] == "1")
                                                        <input type="checkbox" name="support" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="support" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.main_video') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->settings[6] == "1")
                                                        <input type="checkbox" name="main_video" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="main_video" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.app_login_logs') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->settings[7] == "1")
                                                        <input type="checkbox" name="login_logs" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="login_logs" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-4 my-2">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <i class="app-menu__icon fas fa-object-ungroup"></i> <span class="f_size-17">{{ __('main.weeks') }}</span>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.add_week') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->weeks[0] == "1")
                                                        <input type="checkbox" name="add_week" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="add_week" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_week') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->weeks[1] == "1")
                                                        <input type="checkbox" name="edit_week" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="edit_week" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_week') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    @if($permissions->weeks[2] == "1")
                                                        <input type="checkbox" name="delete_week" class="js-switch" checked/>
                                                    @else
                                                        <input type="checkbox" name="delete_week" class="js-switch" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.change') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection