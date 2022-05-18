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
                    <div class="form-group">
                        <select class="form-control" name="role" id="role">
                            <option value="-1">{{ __('main.role') }}</option>
                            <option value="admin">{{ __('main.admin') }}</option>
                            <option value="main_supervisor">{{ __('main.main_supervisor') }}</option>
                            <option value="assistant_supervisor">{{ __('main.assistant_supervisor') }}</option>
                        </select>
                    </div>
                    <div id="card" style="display: none">
                        <div class="card">
                            <div class="card-header text-center">
                                <h3 class="acc_prem_h3">{{ __('main.acc_prem') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mx-0">
                                    <div class="col-lg-6 col-xl-4 my-2" id="settings" style="display: none" >
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="teachers" style="display: none">
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="students" style="display: none">
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="admins_acc" style="display: none">
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="countries" style="display: none">
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="levels" style="display: none">
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="homework" style="display: none" >
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="groups" style="display: none">
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="c_panel" style="display: none">
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
                                    <div class="col-lg-6 col-xl-4 my-2" id="groups_choices" style="display: none">
                                        <div class="card">
                                            <div class="card-header text-center">
                                                <i class="app-menu__icon fas fa-object-ungroup"></i> <span class="f_size-17">{{ __('main.groups_choices') }}</span>
                                            </div>
                                            <div class="card-body text-center">
                                                <select data-placeholder="{{ __('main.select_groups') }}" multiple class="chosen-select" tabindex="8">
                                                    <option>Design</option>
                                                    <option>HTML5</option>
                                                    <option>CSS3</option>
                                                    <option>jQuery</option>
                                                    <option>BS4</option>
                                                    <option>Bootstrap</option>
                                                    <option>WordPress</option>
                                                    <option>FrontEnd</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const selectElement = document.querySelector('#role');
        const card = document.querySelector('#card');
        const card_body = document.querySelector('.card-body');
        const admins_acc = document.querySelector('#admins_acc');
        const teachers = document.querySelector('#teachers');
        const students = document.querySelector('#students');
        const homework = document.querySelector('#homework');
        const groups = document.querySelector('#groups');
        const groups_choices = document.querySelector('#groups_choices');
        const c_panel = document.querySelector('#c_panel');
        selectElement.addEventListener('change', (event) => {
            console.log(event.target.value);
            card_body.querySelectorAll('.col-lg-6').forEach(div => {
                div.style.display = 'none';
            })
            if(event.target.value !== '-1'){
                card.style.display = "block";
                if(event.target.value === 'admin'){
                    card_body.querySelectorAll('.col-lg-6').forEach(div => {
                        div.style.display = 'block';
                    })
                }else{
                    if(event.target.value === 'main_supervisor'){
                        admins_acc.style.display = 'block';
                        teachers.style.display = 'block';
                        students.style.display = 'block';
                        homework.style.display = 'block';
                        groups.style.display = 'block';
                        c_panel.style.display = 'block';
                    }else{
                        teachers.style.display = 'block';
                        students.style.display = 'block';
                        homework.style.display = 'block';
                        groups.style.display = 'block';
                        c_panel.style.display = 'block';
                        groups_choices.style.display = 'block';
                        $(".chosen-select").chosen();
                    }
                }
            }else{
                card.style.display = "none";
            }
        });
    </script>
@endsection
