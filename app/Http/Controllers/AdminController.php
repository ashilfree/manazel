<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Admin_permission;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Helper\MyHelper;
use Response;
use View;

class AdminController extends Controller
{
    public function add_admin()
    {
        return view('/admins/add_admin');
    }

    public function all_admins()
    {
        if(auth('admins')->user()->admin == 1)
        {
            $admins = Admin::orderBy('id', 'DESC')->paginate(20);
        }
        else
        {
            $admins = Admin::where('admin', '!=', 1)->orderBy('id', 'DESC')->paginate(20);
        }
        return view('/admins/all_admins', [ 'admins' => $admins ]);
    }

    public function send_notification()
    {
        return view('/send_notification');
    }

    public function set_send_notification(Request $Request)
    {
        $notification_title = $Request->notification_title;
        $notification_body = $Request->notification;

        if($notification_title && $notification_body)
        {
            if(MyHelper::SendNotification($notification_title, $notification_body))
            {
                $DB_notification = new Notification();
                $DB_notification->title = $notification_title;
                $DB_notification->notification = $notification_body;
                $DB_notification->type = 'all';
                $DB_notification->save();

                $redirect_message = MyHelper::ReturnMessageByLang("تم أرسال التنبية بنجاح", "Notification successfully sent");
                return Redirect::back()->withErrors(array('success' => $redirect_message));
            }
            else
            {
                $redirect_message = MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error Please try again");
                return Redirect::back()->withErrors(array('error' => $redirect_message));
            }
        }
        else
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ برجاء أدخال جميع البيانات", "Error Please enter all data");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }

    }

    public function modify_admin_permissions($id)
    {
        $admin = Admin::where('id', $id)->firstOrFail();
        $permissions = Admin_permission::where('admin_id', $admin->id)->firstOrFail();
        return view('/admins/modify_admin_permissions', [ 'admin' => $admin, 'permissions' => $permissions ]);
    }

    public function modify_admin($id)
    {
        $admin = Admin::where('id', $id)->firstOrFail();
        return view('/admins/modify_admin', [ 'admin' => $admin ]);
    }

    public function set_admin(Request $Request)
    {
        $rules = array(
            'username' => 'required|string|max:25|unique:admins',
            'full_name' => 'required|string|max:50',
            'password' => 'required|string|min:5',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'username.required'=>'برجاء أدخال أسم المستخدم',
                'username.max'=>'أسم المستخدم يجب أن لا يزيد عن 25 حرف',
                'username.unique'=>'أسم المستخدم الذي ادخلته موجود مسبقا',
                'full_name.required'=>'برجاء أدخال أسم السوبر ادمن باكامل',
                'full_name.max'=>'الاسم يجب أن لا يزيد عن ٥٠ حرف',
                'password.required'=>'برجاء أدخال كلمة المرور',
                'password.string'=>'كلمة المرور يجب انت تحتوي علي حروف',
                'password.min'=>'كلمة المرور يجب الا تقل عن 5 حروف',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'username.required'=>'Please enter your username',
                'username.max'=>'Username should not be more than 25 letters',
                'username.unique'=>'Username you entered is already exist',
                'full_name.required'=>'Please enter your full name',
                'full_name.max'=>'Full name should not be more than 50 letters',
                'password.required'=>'Please enter your password',
                'password.string'=>'Password should contains letters and numbers',
                'password.min'=>'Password should not be less than 5 letters',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }
        $admin = new Admin();
        $admin->username = $Request->username;
        $admin->full_name = $Request->full_name;
        $admin->admin = 2;
        $admin->password = Hash::make($Request->password);
        $admin->save();


        $dashboard_permissions = "00";
        $teacher_permissions = "0000000";
        $student_permissions = "00000000";
        $admin_permissions = "0000";
        $country_permissions = "000";
        $level_permissions = "000";
        $sub_level_permissions = "000";
        $week_permissions = "000";
        $homework_permissions = "000";
        $groups_permissions = "000";
        $sub_groups_permissions = "00000";
        $settings_permissions = "00000000";

        $all_perm = "0";
        // Control_panel pages permissions
        if(isset($Request->statistics_access))
        {
            $dashboard_permissions[0] = "1";
        }
        if(isset($Request->send_notification))
        {
            $dashboard_permissions[1] = "1";
        }

        // Teacher pages permissions
        if(isset($Request->add_teacher))
        {
            $teacher_permissions[0] = "1";
        }
        if(isset($Request->edit_teacher_data))
        {
            $teacher_permissions[1] = "1";
        }
        if(isset($Request->delete_teacher))
        {
            $teacher_permissions[2] = 1;
        }
        if(isset($Request->select_teacher_level))
        {
            $teacher_permissions[3] = 1;
        }
        if(isset($Request->change_teacher_groups))
        {
            $teacher_permissions[4] = 1;
        }
        if(isset($Request->send_all_teachers_notification))
        {
            $teacher_permissions[5] = 1;
        }
        if(isset($Request->send_teacher_notification))
        {
            $teacher_permissions[6] = 1;
        }

        // Student pages permissions
        if(isset($Request->add_student))
        {
            $student_permissions[0] = "1";
        }
        if(isset($Request->edit_student_data))
        {
            $student_permissions[1] = "1";
        }
        if(isset($Request->delete_student))
        {
            $student_permissions[2] = 1;
        }
        if(isset($Request->select_student_level))
        {
            $student_permissions[3] = 1;
        }
        if(isset($Request->change_student_group))
        {
            $student_permissions[4] = 1;
        }
        if(isset($Request->student_assignment_log))
        {
            $student_permissions[5] = 1;
        }
        if(isset($Request->send_all_students_notification))
        {
            $student_permissions[6] = 1;
        }
        if(isset($Request->send_student_notification))
        {
            $student_permissions[7] = 1;
        }

        // Admin pages permissions
        if(isset($Request->add_admin))
        {
            $admin_permissions[0] = "1";
        }
        if(isset($Request->edit_admin_data))
        {
            $admin_permissions[1] = "1";
        }
        if(isset($Request->delete_admin))
        {
            $admin_permissions[2] = 1;
        }
        if(isset($Request->change_admin_perm))
        {
            $admin_permissions[3] = 1;
        }

        // Country pages permissions
        if(isset($Request->add_country))
        {
            $country_permissions[0] = "1";
        }
        if(isset($Request->edit_country_data))
        {
            $country_permissions[1] = "1";
        }
        if(isset($Request->delete_country))
        {
            $country_permissions[2] = 1;
        }

        // Levels pages permissions
        if(isset($Request->add_level))
        {
            $level_permissions[0] = "1";
        }
        if(isset($Request->edit_level_data))
        {
            $level_permissions[1] = "1";
        }
        if(isset($Request->delete_level))
        {
            $level_permissions[2] = 1;
        }

        // Sub levels pages permissions
        if(isset($Request->add_sub_level))
        {
            $sub_level_permissions[0] = "1";
        }
        if(isset($Request->edit_sub_level))
        {
            $sub_level_permissions[1] = "1";
        }
        if(isset($Request->delete_sub_level))
        {
            $sub_level_permissions[2] = 1;
        }

        // Weeks pages permissions
        if(isset($Request->add_week))
        {
            $week_permissions[0] = "1";
        }
        if(isset($Request->edit_week))
        {
            $week_permissions[1] = "1";
        }
        if(isset($Request->delete_week))
        {
            $week_permissions[2] = 1;
        }

        // Homework pages permissions
        if(isset($Request->add_homework))
        {
            $homework_permissions[0] = "1";
        }
        if(isset($Request->edit_homework_data))
        {
            $homework_permissions[1] = "1";
        }
        if(isset($Request->delete_homework))
        {
            $homework_permissions[2] = 1;
        }

        // Groups pages permissions
        if(isset($Request->add_group))
        {
            $groups_permissions[0] = "1";
        }
        if(isset($Request->edit_group_data))
        {
            $groups_permissions[1] = "1";
        }
        if(isset($Request->delete_group))
        {
            $groups_permissions[2] = 1;
        }

        // Subgroups pages permissions
        if(isset($Request->add_sub_group))
        {
            $sub_groups_permissions[0] = "1";
        }
        if(isset($Request->edit_sub_group_data))
        {
            $sub_groups_permissions[1] = "1";
        }
        if(isset($Request->delete_sub_group))
        {
            $sub_groups_permissions[2] = 1;
        }
        if(isset($Request->select_sub_group_teacher))
        {
            $sub_groups_permissions[3] = "1";
        }
        if(isset($Request->select_sub_group_students))
        {
            $sub_groups_permissions[4] = 1;
        }

        // Settings pages permissions
        if(isset($Request->ayat_test))
        {
            $settings_permissions[0] = "1";
        }
        if(isset($Request->app_guide))
        {
            $settings_permissions[1] = "1";
        }
        if(isset($Request->about_us))
        {
            $settings_permissions[2] = 1;
        }
        if(isset($Request->terms_conditions))
        {
            $settings_permissions[3] = "1";
        }
        if(isset($Request->contact_us))
        {
            $settings_permissions[4] = 1;
        }
        if(isset($Request->support))
        {
            $settings_permissions[5] = 1;
        }
        if(isset($Request->main_video))
        {
            $settings_permissions[6] = 1;
        }
        if(isset($Request->login_logs))
        {
            $settings_permissions[7] = 1;
        }

        $permissions = new Admin_permission();
        $permissions->statistics = $dashboard_permissions;
        $permissions->teachers = $teacher_permissions;
        $permissions->students = $student_permissions;
        $permissions->home_work = $homework_permissions;
        $permissions->levels = $level_permissions;
        $permissions->sub_levels = $sub_level_permissions;
        $permissions->weeks = $week_permissions;
        $permissions->countries = $country_permissions;
        $permissions->audios = $all_perm;
        $permissions->notifications = $all_perm;
        $permissions->admins = $admin_permissions;
        $permissions->groups = $groups_permissions;
        $permissions->sub_groups = $sub_groups_permissions;
        $permissions->settings = $settings_permissions;
        $permissions->admin_id = $admin->id;
        $permissions->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم أنشاء الحساب بنجاح", "Account successfully created");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function change_permissions(Request $Request)
    {
        $permissions = Admin_permission::where('id', $Request->permissions_id)->firstOrFail();

        $dashboard_permissions = "00";
        $teacher_permissions = "0000000";
        $student_permissions = "00000000";
        $admin_permissions = "0000";
        $country_permissions = "000";
        $level_permissions = "000";
        $sub_level_permissions = "000";
        $week_permissions = "000";
        $homework_permissions = "000";
        $groups_permissions = "000";
        $sub_groups_permissions = "00000";
        $settings_permissions = "00000000";

        $all_perm = "0";
        // Control_panel pages permissions
        if(isset($Request->statistics_access))
        {
            $dashboard_permissions[0] = "1";
        }
        if(isset($Request->send_notification))
        {
            $dashboard_permissions[1] = "1";
        }

        // Teacher pages permissions
        if(isset($Request->add_teacher))
        {
            $teacher_permissions[0] = "1";
        }
        if(isset($Request->edit_teacher_data))
        {
            $teacher_permissions[1] = "1";
        }
        if(isset($Request->delete_teacher))
        {
            $teacher_permissions[2] = 1;
        }
        if(isset($Request->select_teacher_level))
        {
            $teacher_permissions[3] = 1;
        }
        if(isset($Request->change_teacher_groups))
        {
            $teacher_permissions[4] = 1;
        }
        if(isset($Request->send_all_teachers_notification))
        {
            $teacher_permissions[5] = 1;
        }
        if(isset($Request->send_teacher_notification))
        {
            $teacher_permissions[6] = 1;
        }

        // Student pages permissions
        if(isset($Request->add_student))
        {
            $student_permissions[0] = "1";
        }
        if(isset($Request->edit_student_data))
        {
            $student_permissions[1] = "1";
        }
        if(isset($Request->delete_student))
        {
            $student_permissions[2] = 1;
        }
        if(isset($Request->select_student_level))
        {
            $student_permissions[3] = 1;
        }
        if(isset($Request->change_student_group))
        {
            $student_permissions[4] = 1;
        }
        if(isset($Request->student_assignment_log))
        {
            $student_permissions[5] = 1;
        }
        if(isset($Request->send_all_students_notification))
        {
            $student_permissions[6] = 1;
        }
        if(isset($Request->send_student_notification))
        {
            $student_permissions[7] = 1;
        }

        // Admin pages permissions
        if(isset($Request->add_admin))
        {
            $admin_permissions[0] = "1";
        }
        if(isset($Request->edit_admin_data))
        {
            $admin_permissions[1] = "1";
        }
        if(isset($Request->delete_admin))
        {
            $admin_permissions[2] = 1;
        }
        if(isset($Request->change_admin_perm))
        {
            $admin_permissions[3] = 1;
        }

        // Country pages permissions
        if(isset($Request->add_country))
        {
            $country_permissions[0] = "1";
        }
        if(isset($Request->edit_country_data))
        {
            $country_permissions[1] = "1";
        }
        if(isset($Request->delete_country))
        {
            $country_permissions[2] = 1;
        }

        // Levels pages permissions
        if(isset($Request->add_level))
        {
            $level_permissions[0] = "1";
        }
        if(isset($Request->edit_level_data))
        {
            $level_permissions[1] = "1";
        }
        if(isset($Request->delete_level))
        {
            $level_permissions[2] = 1;
        }

        // Sub levels pages permissions
        if(isset($Request->add_sub_level))
        {
            $sub_level_permissions[0] = "1";
        }
        if(isset($Request->edit_sub_level))
        {
            $sub_level_permissions[1] = "1";
        }
        if(isset($Request->delete_sub_level))
        {
            $sub_level_permissions[2] = 1;
        }

        // Weeks pages permissions
        if(isset($Request->add_week))
        {
            $week_permissions[0] = "1";
        }
        if(isset($Request->edit_week))
        {
            $week_permissions[1] = "1";
        }
        if(isset($Request->delete_week))
        {
            $week_permissions[2] = 1;
        }

        // Homework pages permissions
        if(isset($Request->add_homework))
        {
            $homework_permissions[0] = "1";
        }
        if(isset($Request->edit_homework_data))
        {
            $homework_permissions[1] = "1";
        }
        if(isset($Request->delete_homework))
        {
            $homework_permissions[2] = 1;
        }

        // Groups pages permissions
        if(isset($Request->add_group))
        {
            $groups_permissions[0] = "1";
        }
        if(isset($Request->edit_group_data))
        {
            $groups_permissions[1] = "1";
        }
        if(isset($Request->delete_group))
        {
            $groups_permissions[2] = 1;
        }

        // Subgroups pages permissions
        if(isset($Request->add_sub_group))
        {
            $sub_groups_permissions[0] = "1";
        }
        if(isset($Request->edit_sub_group_data))
        {
            $sub_groups_permissions[1] = "1";
        }
        if(isset($Request->delete_sub_group))
        {
            $sub_groups_permissions[2] = 1;
        }
        if(isset($Request->select_sub_group_teacher))
        {
            $sub_groups_permissions[3] = "1";
        }
        if(isset($Request->select_sub_group_students))
        {
            $sub_groups_permissions[4] = 1;
        }

        // Settings pages permissions
        if(isset($Request->ayat_test))
        {
            $settings_permissions[0] = "1";
        }
        if(isset($Request->app_guide))
        {
            $settings_permissions[1] = "1";
        }
        if(isset($Request->about_us))
        {
            $settings_permissions[2] = 1;
        }
        if(isset($Request->terms_conditions))
        {
            $settings_permissions[3] = "1";
        }
        if(isset($Request->contact_us))
        {
            $settings_permissions[4] = 1;
        }
        if(isset($Request->support))
        {
            $settings_permissions[5] = 1;
        }
        if(isset($Request->main_video))
        {
            $settings_permissions[6] = 1;
        }
        if(isset($Request->login_logs))
        {
            $settings_permissions[7] = 1;
        }

        $permissions->statistics = $dashboard_permissions;
        $permissions->teachers = $teacher_permissions;
        $permissions->students = $student_permissions;
        $permissions->home_work = $homework_permissions;
        $permissions->levels = $level_permissions;
        $permissions->sub_levels = $sub_level_permissions;
        $permissions->weeks = $week_permissions;
        $permissions->countries = $country_permissions;
        $permissions->audios = $all_perm;
        $permissions->notifications = $all_perm;
        $permissions->admins = $admin_permissions;
        $permissions->groups = $groups_permissions;
        $permissions->sub_groups = $sub_groups_permissions;
        $permissions->settings = $settings_permissions;
        $permissions->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم تغير صلاحيات الحساب بنجاح", "Account permissions successfully changed");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function update_admin_data(Request $Request)
    {
        $admin = Admin::where('id', $Request->admin_id)->firstOrFail();
        $rules = array(
            'full_name' => 'required|string|max:50',
        );

        if($Request->username != $admin->username)
        {
            $rules['username'] = 'required|string|max:25|unique:admins';
        }

        if (isset($request->password))
        {
            $rules['password'] = 'required|string|min:5|confirmed';
            $rules['password_confirmation'] = 'required|min:5';
        }

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'username.required'=>'برجاء أدخال أسم المستخدم',
                'username.max'=>'أسم المستخدم يجب أن لا يزيد عن 25 حرف',
                'username.unique'=>'أسم المستخدم الذي ادخلته موجود مسبقا',
                'full_name.required'=>'برجاء أدخال أسم السوبر ادمن باكامل',
                'full_name.max'=>'الاسم يجب أن لا يزيد عن ٥٠ حرف',
                'password.required'=>'برجاء أدخال كلمة المرور',
                'password.string'=>'كلمة المرور يجب انت تحتوي علي حروف',
                'password.min'=>'كلمة المرور يجب الا تقل عن 5 حروف',
                'password.confirmed'=>'كلمة المرور و إعادة كلمة المرور غير متشابهين',
                'password_confirmation.required'=>'برجاء أدخال تأكيد كلمة المرور',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'username.required'=>'Please enter your username',
                'username.max'=>'Username should not be more than 25 letters',
                'username.unique'=>'Username you entered is already exist',
                'full_name.required'=>'Please enter your full name',
                'full_name.max'=>'Full name should not be more than 50 letters',
                'password.required'=>'Please enter your password',
                'password.string'=>'Password should contains letters and numbers',
                'password.min'=>'Password should not be less than 5 letters',
                'password.confirmed'=>'Password does not match the confirm password',
                'password_confirmation.required'=>'Please enter password confirmation',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }

        $admin->username = $Request->username;
        $admin->full_name = $Request->full_name;
        if (isset($request->password))
        {
            $admin->password = Hash::make($Request->password);
        }
        $admin->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم تعديل الحساب بنجاح", "Account successfully modified");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function delete_admin(Request $request)
    {
        $admin_id = $request->admin_id;

        $admin = Admin::where('id', $admin_id)->firstOrFail();

        if($admin->delete())
        {
            $redirect_message = MyHelper::ReturnMessageByLang("تم حذف الحساب بنجاح", "Account successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirect_message));
        }
        else
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }
    }

    public function find_admin(Request $Request)
    {
        $keyword = $Request->keyword;
        $all = $Request->all;
        $search_by = $Request->search_by;

        if($all == 'yes')
        {
            if(auth('admins')->user()->admin == 1)
            {
                $admins = Admin::orderBy('id', 'DESC')->paginate(20);
            }
            else
            {
                $admins = Admin::where('admin', '!=', 1)->orderBy('id', 'DESC')->paginate(20);
            }
            $admins->setPath('/admins');
        }
        else
        {
            if($search_by == "full_name")
            {
                if(auth('admins')->user()->admin == 1)
                {
                    $admins = Admin::where('full_name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
                }
                else
                {
                    $admins = Admin::where('full_name','LIKE','%'.$keyword.'%')->where('admin', '!=', 1)->orderBy('id', 'DESC')->paginate(10);
                }

            }
            elseif ($search_by == "username")
            {
                if(auth('admins')->user()->admin == 1)
                {
                    $admins = Admin::where('username','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
                }
                else
                {
                    $admins = Admin::where('username','LIKE','%'.$keyword.'%')->where('admin', '!=', 1)->orderBy('id', 'DESC')->paginate(10);
                }
            }
            else
            {
                if(auth('admins')->user()->admin == 1)
                {
                    $admins = Admin::where('username','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
                }
                else
                {
                    $admins = Admin::where('username','LIKE','%'.$keyword.'%')->where('admin', '!=', 1)->orderBy('id', 'DESC')->paginate(10);
                }
            }
        }
        return Response::json(View::make('admins.find_admin_tl', array('admins' => $admins, 'all' => $all))->render());
    }

}
