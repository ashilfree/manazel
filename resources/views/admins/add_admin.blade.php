@extends('layout.layout')
@section('title',  __('main.add_admin') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-user-cog"></i> {{ __('main.admins_acc') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.add_admin') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.add_admin') }}</h3>
                <form action="{{ route('set_admin') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" class="image_crop_form game_upload">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('main.full_name') }}</label>
                        <input class="form-control" type="text" name="full_name" value="{{ old('full_name') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.username') }}</label>
                        <input class="form-control" type="text" name="username" value="{{ old('username') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.password') }}</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.c_password') }}</label>
                        <input class="form-control" type="password" name="password_confirmation"  required>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h3 class="acc_prem_h3">{{ __('main.acc_prem') }}</h3>
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
                                                    <input type="checkbox" name="statistics_access" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="send_notification" class="js-switch" />
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
                                                    <input type="checkbox" name="add_teacher" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_teacher') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_teacher_data" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_teacher') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_teacher" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.select_teacher_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="select_teacher_level" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.change_teacher_groups') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="change_teacher_groups" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_all_teachers_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="send_all_teachers_notification" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_teacher_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="send_teacher_notification" class="js-switch" />
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
                                                    <input type="checkbox" name="add_student" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_student') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_student_data" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_student') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_student" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.select_student_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="select_student_level" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.change_student_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="change_student_group" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.student_assignment_log') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="student_assignment_log" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_all_students_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="send_all_students_notification" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.send_student_notification') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="send_student_notification" class="js-switch" />
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
                                                    <input type="checkbox" name="add_admin" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_admin') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_admin_data" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.change_perm') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="change_admin_perm" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_admin') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_admin" class="js-switch" />
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
                                                    <input type="checkbox" name="add_country" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_country') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_country_data" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_country') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_country" class="js-switch" />
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
                                                    <input type="checkbox" name="add_level" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_level_data" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_level" class="js-switch" />
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
                                                    <input type="checkbox" name="add_sub_level" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_sub_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_sub_level" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_sub_level') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_sub_level" class="js-switch" />
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
                                                    <input type="checkbox" name="add_homework" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_homework') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_homework_data" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_homework') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_homework" class="js-switch" />
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
                                                    <input type="checkbox" name="add_group" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_group_data" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_group" class="js-switch" />
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
                                                    <input type="checkbox" name="add_sub_group" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_sub_group_data" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_group') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_sub_group" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.select_sub_group_teacher') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="select_sub_group_teacher" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.select_sub_group_students') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="select_sub_group_students" class="js-switch" />
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
                                                    <input type="checkbox" name="ayat_test" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.app_guide') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="app_guide" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.about_us') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="about_us" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.terms_conditions') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="terms_conditions" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.contact_us') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="contact_us" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.support') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="support" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.main_video') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="main_video" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.app_login_logs') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="login_logs" class="js-switch" />
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
                                                    <input type="checkbox" name="add_week" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.edit_week') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="edit_week" class="js-switch" />
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <span>{{ __('main.delete_week') }} </span>
                                                </div>
                                                <div class="col-6 d-flex align-items-center justify-content-center">
                                                    <input type="checkbox" name="delete_week" class="js-switch" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection