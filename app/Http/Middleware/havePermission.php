<?php

namespace App\Http\Middleware;

use Closure;

class havePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $page)
    {
        $permission = \auth('admins')->user()->permissions;

        if(\auth('admins')->user()->admin == 1)
        {
            return $next($request);
        }

        if (\auth('admins')->user())
        {
            if ($page == 'send_notification' || $page == 'set_send_notification')
            {
                if ($permission->statistics[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_teacher' || $page == 'set_teacher')
            {
                if ($permission->teachers[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_teachers' || $page == 'find_teacher')
            {
                if ($permission->teachers[1] == 1 || $permission->teachers[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_teacher' || $page == 'update_teacher_data')
            {
                if ($permission->teachers[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_teacher')
            {
                if ($permission->teachers[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'change_teacher_level' || $page == 'set_teacher_level')
            {
                if ($permission->teachers[3] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'add_teacher_to_groups')
            {
                if ($permission->teachers[4] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'notify_all_teachers' || $page == 'set_notify_all_teachers')
            {
                if ($permission->teachers[5] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'notify_teacher' || $page == 'set_notify_teacher')
            {
                if ($permission->teachers[6] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }


            if ($page == 'add_admin' || $page == 'set_admin')
            {
                if ($permission->admins[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_admins' || $page == 'find_admin')
            {
                if ($permission->admins[1] == 1 || $permission->admins[2] == 1 || $permission->admins[3] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_admin' || $page == 'update_admin_data')
            {
                if ($permission->admins[1] == 1 || $permission->admins[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_admin')
            {
                if ($permission->admins[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_admin_permissions' || $page == 'change_permissions')
            {
                if ($permission->admins[3] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_country' || $page == 'set_country')
            {
                if ($permission->countries[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_countries' || $page == 'find_country')
            {
                if ($permission->countries[1] == 1 || $permission->countries[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_country' || $page == 'update_country_data')
            {
                if ($permission->countries[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_country')
            {
                if ($permission->countries[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_student' || $page == 'set_student')
            {
                if ($permission->students[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_students' || $page == 'find_student')
            {
                if ($permission->students[1] == 1 || $permission->students[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_student' || $page == 'update_student_data')
            {
                if ($permission->students[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_student')
            {
                if ($permission->students[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'change_student_level' || $page == 'set_student_level')
            {
                if ($permission->students[3] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'change_student_group')
            {
                if ($permission->students[4] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'student_assignment_log')
            {
                if ($permission->students[5] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'notify_all_students' || $page == 'set_notify_all_students')
            {
                if ($permission->students[6] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'notify_student' || $page == 'set_notify_student')
            {
                if ($permission->students[7] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_level' || $page == 'set_level')
            {
                if ($permission->levels[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_levels' || $page == 'find_level')
            {
                if ($permission->levels[1] == 1 || $permission->levels[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_level' || $page == 'update_level_data')
            {
                if ($permission->levels[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_level')
            {
                if ($permission->levels[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_sub_level' || $page == 'set_sub_level')
            {
                if ($permission->sub_levels[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_sub_levels' || $page == 'find_sub_level')
            {
                if ($permission->sub_levels[1] == 1 || $permission->sub_levels[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_sub_level' || $page == 'update_sub_level')
            {
                if ($permission->sub_levels[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_sub_level')
            {
                if ($permission->sub_levels[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_homework' || $page == 'set_homework')
            {
                if ($permission->home_work[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_homework' || $page == 'find_homework')
            {
                if ($permission->home_work[1] == 1 || $permission->home_work[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_homework' || $page == 'update_homework_data')
            {
                if ($permission->home_work[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_homework')
            {
                if ($permission->home_work[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_week' || $page == 'set_week')
            {
                if ($permission->weeks[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_weeks')
            {
                if ($permission->weeks[1] == 1 || $permission->weeks[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_week' || $page == 'update_week')
            {
                if ($permission->weeks[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_week')
            {
                if ($permission->weeks[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_group' || $page == 'set_group')
            {
                if ($permission->groups[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_groups' || $page == 'find_group')
            {
                if ($permission->groups[1] == 1 || $permission->groups[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_group' || $page == 'update_groups_data')
            {
                if ($permission->groups[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_group')
            {
                if ($permission->groups[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }

            if ($page == 'add_sub_group' || $page == 'set_sub_group')
            {
                if ($permission->sub_groups[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'all_sub_groups')
            {
                if ($permission->sub_groups[1] == 1 || $permission->sub_groups[2] == 1 ||
                    $permission->sub_groups[3] == 1 || $permission->sub_groups[4] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'modify_sub_group' || $page == 'update_sub_groups_data')
            {
                if ($permission->sub_groups[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'delete_sub_group')
            {
                if ($permission->sub_groups[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'change_group_teacher')
            {
                if ($permission->sub_groups[3] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'add_group_students')
            {
                if ($permission->sub_groups[4] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'ayat_test' || $page == 'set_ayat_test' || $page == 'delete_ayat_test' || $page == 'modify_ayah' || $page == 'set_ayat_update')
            {
                if ($permission->settings[0] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'app_guide' || $page == 'set_app_guide' || $page == 'delete_app_guid' || $page == 'app_guide' || $page == 'update_app_guide')
            {
                if ($permission->settings[1] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'about_us' || $page == 'set_about_us' || $page == 'set_about_us_update')
            {
                if ($permission->settings[2] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'terms_conditions' || $page == 'set_terms_conditions' || $page == 'update_terms_conditions')
            {
                if ($permission->settings[3] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'contact_us' || $page == 'delete_contact_us')
            {
                if ($permission->settings[4] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'support' || $page == 'delete_support')
            {
                if ($permission->settings[5] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'main_video' || $page == 'set_main_video')
            {
                if ($permission->settings[6] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
            if ($page == 'app_login_logs')
            {
                if ($permission->settings[7] == 1)
                {
                    return $next($request);
                }
                else
                {
                    abort(404);
                }
            }
        }
        return redirect('/login');
    }
}
