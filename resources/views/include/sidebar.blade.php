<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user text-lang-dir">
        <img class="app-sidebar__user-avatar" src="https://s3.amazonaws.com/uifaces/faces/twitter/jsa/48.jpg" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{ auth('admins')->user()->username }}</p>
            <p class="app-sidebar__user-designation">{{ __('main.welcome') }}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item {{ Route::current()->getName() === "dashboard" ? "active" : "" }}" href="{{ route('dashboard') }}"><i class="app-menu__icon fas fa-tachometer-alt text-lang-dir"></i><span class="app-menu__label text-lang-dir">{{ __('main.c_panel') }}</span></a></li>

        @if(auth('admins')->user()->permissions->settings != 0)
            <li class="treeview {{ Route::current()->getName() === "ayat_test" || Route::current()->getName() === "modify_ayah" || Route::current()->getName() === "app_guide" ||
                                   Route::current()->getName() === "modify_app_guid" || Route::current()->getName() === "about_us" || Route::current()->getName() === "terms_conditions" ||
                                   Route::current()->getName() === "contact_us" || Route::current()->getName() === "main_video" || Route::current()->getName() === "support" ||
                                   Route::current()->getName() === "app_login_logs" ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-cog"></i><span class="app-menu__label">{{ __('main.settings') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->settings[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "ayat_test" ? "active" : "" }}" href="{{ route('ayat_test') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.ayat_test') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->settings[1] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "app_guide" ? "active" : "" }}" href="{{ route('app_guide') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.app_guide') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->settings[2] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "about_us" ? "active" : "" }}" href="{{ route('about_us') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.about_us') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->settings[3] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "terms_conditions" ? "active" : "" }}" href="{{ route('terms_conditions') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.terms_conditions') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->settings[4] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "contact_us" ? "active" : "" }}" href="{{ route('contact_us') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.contact_us') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->settings[5] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "support" ? "active" : "" }}" href="{{ route('support') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.support') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->settings[6] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "main_video" ? "active" : "" }}" href="{{ route('main_video') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.main_video') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->settings[7] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "app_login_logs" ? "active" : "" }}" href="{{ route('app_login_logs') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.app_login_logs') }} </a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(auth('admins')->user()->permissions->teachers != 0)
            <li class="treeview {{ Route::current()->getName() === "add_teacher" || Route::current()->getName() === "all_teachers" || Route::current()->getName() === "modify_teacher" ||
                                   Route::current()->getName() === "change_teacher_level" || Route::current()->getName() === "notify_all_teachers"  ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-chalkboard-teacher"></i><span class="app-menu__label">{{ __('main.teachers') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->teachers[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "add_teacher" ? "active" : "" }}" href="{{ route('add_teacher') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_teacher') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->teachers[1] == 1 || auth('admins')->user()->permissions->teachers[2] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "all_teachers" ? "active" : "" }}" href="{{ route('all_teachers') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_teacher') }}</a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->teachers[5] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "notify_all_teachers" ? "active" : "" }}" href="{{ route('notify_all_teachers') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.send_all_teachers_notification') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(auth('admins')->user()->permissions->students != 0)
            <li class="treeview {{ Route::current()->getName() === "add_student" || Route::current()->getName() === "all_students" || Route::current()->getName() === "modify_student" || Route::current()->getName() === "change_student_level" ||
                                   Route::current()->getName() === "student_assignment_log" || Route::current()->getName() === "notify_all_students"  ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-user-graduate"></i><span class="app-menu__label">{{ __('main.students') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->students[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "add_student" ? "active" : "" }}" href="{{ route('add_student') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_student') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->students[1] == 1 || auth('admins')->user()->permissions->students[2] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "all_students" ? "active" : "" }}" href="{{ route('all_students') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_student') }}</a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->students[6] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "notify_all_students" ? "active" : "" }}" href="{{ route('notify_all_students') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.send_all_students_notification') }}</a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->students[5] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "student_assignment_log" ? "active" : "" }}" href="{{ route('student_assignment_log') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.student_assignment_log') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(auth('admins')->user()->permissions->admins != 0)
            <li class="treeview {{ Route::current()->getName() === "add_admin" || Route::current()->getName() === "all_admins" || Route::current()->getName() === "modify_admin" || Route::current()->getName() === "modify_admin_permissions"  ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-user-cog"></i><span class="app-menu__label">{{ __('main.admins_acc') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->admins[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "add_admin" ? "active" : "" }}" href="{{ route('add_admin') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_admin') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->admins[1] == 1 || auth('admins')->user()->permissions->admins[2] == 1 || auth('admins')->user()->permissions->admins[3] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "all_admins" ? "active" : "" }}" href="{{ route('all_admins') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_admin') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(auth('admins')->user()->permissions->countries != 0)
            <li class="treeview {{ Route::current()->getName() === "add_country" || Route::current()->getName() === "all_countries" || Route::current()->getName() === "modify_country" ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-flag"></i><span class="app-menu__label">{{ __('main.countries') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->countries[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "add_country" ? "active" : "" }}" href="{{ route('add_country') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_country') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->countries[1] == 1 || auth('admins')->user()->permissions->countries[2] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "all_countries" ? "active" : "" }}" href="{{ route('all_countries') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_country') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(auth('admins')->user()->permissions->levels != 0)
        <li class="treeview {{ Route::current()->getName() === "add_level" || Route::current()->getName() === "all_levels" || Route::current()->getName() === "modify_level" ? "is-expanded" : "" }}">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fas fa-sort-numeric-up"></i><span class="app-menu__label">{{ __('main.levels') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
            </a>
            <ul class="treeview-menu">
                @if(auth('admins')->user()->permissions->levels[0] == 1)
                    <li><a class="treeview-item {{ Route::current()->getName() === "add_level" ? "active" : "" }}" href="{{ route('add_level') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_level') }} </a></li>
                @endif
                @if(auth('admins')->user()->permissions->levels[1] == 1 || auth('admins')->user()->permissions->levels[2] == 1)
                    <li><a class="treeview-item {{ Route::current()->getName() === "all_levels" ? "active" : "" }}" href="{{ route('all_levels') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_level') }}</a></li>
                @endif
            </ul>
        </li>
        @endif

        @if(auth('admins')->user()->permissions->weeks != 0)
            <li class="treeview {{ Route::current()->getName() === "add_week" || Route::current()->getName() === "all_weeks" || Route::current()->getName() === "modify_week" ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-calendar-alt"></i><span class="app-menu__label">{{ __('main.weeks') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->weeks[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "add_week" ? "active" : "" }}" href="{{ route('add_week') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_week') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->weeks[1] == 1 || auth('admins')->user()->permissions->weeks[2] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "all_weeks" ? "active" : "" }}" href="{{ route('all_weeks') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_week') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(auth('admins')->user()->permissions->home_work != 0)
            <li class="treeview {{ Route::current()->getName() === "add_homework" || Route::current()->getName() === "all_homework" || Route::current()->getName() === "modify_homework" ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-tasks"></i><span class="app-menu__label">{{ __('main.homework') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->home_work[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "add_homework" ? "active" : "" }}" href="{{ route('add_homework') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_homework') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->home_work[1] == 1 || auth('admins')->user()->permissions->home_work[2] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "all_homework" ? "active" : "" }}" href="{{ route('all_homework') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_homework') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(auth('admins')->user()->permissions->groups != 0)
            <li class="treeview {{ Route::current()->getName() === "add_group" || Route::current()->getName() === "all_groups" || Route::current()->getName() === "modify_group" ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fas fa-object-ungroup"></i><span class="app-menu__label">{{ __('main.groups') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->groups[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "add_group" ? "active" : "" }}" href="{{ route('add_group') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_group') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->groups[1] == 1 || auth('admins')->user()->permissions->groups[2] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "all_groups" ? "active" : "" }}" href="{{ route('all_groups') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_group') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif

        @if(auth('admins')->user()->permissions->sub_groups != 0)
            <li class="treeview {{ Route::current()->getName() === "add_sub_group" || Route::current()->getName() === "all_sub_groups" || Route::current()->getName() === "modify_sub_group" ? "is-expanded" : "" }}">
                <a class="app-menu__item" href="#" data-toggle="treeview">
                    <i class="app-menu__icon far fa-object-group"></i><span class="app-menu__label">{{ __('main.sub_groups') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
                </a>
                <ul class="treeview-menu">
                    @if(auth('admins')->user()->permissions->sub_groups[0] == 1)
                        <li><a class="treeview-item {{ Route::current()->getName() === "add_sub_group" ? "active" : "" }}" href="{{ route('add_sub_group') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.add_sub_group') }} </a></li>
                    @endif
                    @if(auth('admins')->user()->permissions->sub_groups[1] == 1 || auth('admins')->user()->permissions->sub_groups[2] == 1)
                            <li><a class="treeview-item {{ Route::current()->getName() === "all_sub_groups" ? "active" : "" }}" href="{{ route('all_sub_groups') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.edit_del_sub_group') }}</a></li>
                    @endif
                </ul>
            </li>
        @endif
        @if(auth('admins')->user()->permissions->statistics[1] == "1")
            <li><a class="app-menu__item {{ Route::current()->getName() === "send_notification" ? "active" : "" }}" href="{{ route('send_notification') }}"><i class="app-menu__icon fas fa-bell text-lang-dir"></i><span class="app-menu__label text-lang-dir">{{ __('main.send_notification') }}</span></a></li>
        @endif
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-globe"></i><span class="app-menu__label">{{ __('main.chnage_lang') }}</span><i class="treeview-indicator fas {{ app()->getLocale() == "ar" ? 'fa-angle-left' : 'fa-angle-right' }}"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{ route('language', 'ar') }}"><i class="icon far fa-circle fa-sm"></i> {{ __('main.arabic') }}</a></li>
                <li><a class="treeview-item" href="{{ route('language', 'en') }}"><i class="icon far fa-circle fa-sm"></i>{{ __('main.english') }}</a></li>
            </ul>
        </li>
    </ul>
</aside>
