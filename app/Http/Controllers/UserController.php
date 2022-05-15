<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Admin_permission;
use App\Setting;
use App\User;
use App\Users_homework;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Helper\MyHelper;
use Auth;

class UserController extends Controller
{
    public function home()
    {
        $teachers_count = User::where('type', 'teacher')->count();
        $students_count = User::where('type', 'student')->count();
        $android_user = Setting::where('type', "platform_analytics")->where('name', 'android')->first();
        $ios_user = Setting::where('type', "platform_analytics")->where('name', 'ios')->first();
        $homework_read = Users_homework::where('status', 'read')->count();
        $homework_not_read = Users_homework::where('status', 'not read')->count();
        $homework_trmim = Users_homework::where('status', 'trmim')->count();
        $homework_stopped = Users_homework::where('status', 'stopped')->count();

        $android_count = 0;
        $ios_count = 0;

        if(!empty($android_user))
        {
            $android_count = $android_user->setting;
        }

        if(!empty($ios_user))
        {
            $ios_count = $ios_user->setting;
        }

        return view('home', ['teachers_count' => $teachers_count, 'students_count' => $students_count, 'android_count' => $android_count, 'ios_count' => $ios_count,
                                   'homework_read' => $homework_read, 'homework_not_read' => $homework_not_read, 'homework_trmim' => $homework_trmim, 'homework_stopped' => $homework_stopped,]);
    }

    public function login()
    {
        return view('login');
    }

    public function AdminLogin(Request $Request)
    {
        $remember = false;
        if (isset($Request->remember))
        {
            $remember = true;
        }

        if (auth('admins')->attempt(['username' => $Request->username, 'password' => $Request->password], $remember))
        {
            if(auth('admins')->user()->admin != 1 && auth('admins')->user()->admin != 2)
            {
                auth('admins')->logout();
                $message = MyHelper::ReturnMessageByLang("لقد تم حظر حسابك", "Your account has been blocked");
                return Redirect::back()->withErrors(array('error' => $message));
            }

            return Redirect::route('dashboard')->withErrors(array('success' => MyHelper::ReturnMessageByLang("تم تسجيل الدخول بنجاح", "You have been successfully logged in")));

        }
        else
        {
            if(app()->getLocale() == 'ar')
            {
                $login_error = "خطأ أسم المستخدم و كلمة المرور غير صحيحين";

            }
            elseif (app()->getLocale() == 'en')
            {
                $login_error = "Error email and password incorrect";

            }
            return Redirect::back()->withErrors(array('error' => $login_error));
        }
    }

    public function start()
    {
        $get_admin = Admin::where("admin", 1)->first();
        if(!$get_admin)
        {

            return view('signup');
        }
        else
        {
            abort(404);
        }
    }

    public function set_start(Request $Request)
    {
        $get_admin = Admin::where("admin", 1)->first();

        if(!$get_admin)
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
                    'email.required'=>'برجاء أدخال البريد الإلكتروني',
                    'email.string'=>'برجاء أدخال بريد الإلكتروني صحيح',
                    'email.email'=>'برجاء أدخال بريد الإلكتروني صحيح',
                    'email.max:255'=>'برجاء أدخال بريد الإلكتروني صحيح',
                    'email.unique'=>'البريد الإلكتروني الذي ادخلته موجود مسبقا',
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
                    'email.required'=>'Please enter your email address',
                    'email.string'=>'Please enter valid email address',
                    'email.email'=>'Please enter valid email address',
                    'email.max:255'=>'Please enter valid email address',
                    'email.unique'=>'Email you entered is already exist',
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
            $user_name = $Request->username;
            $password = $Request->password;

            if($user_name && $password)
            {
                $admin = new Admin();
                $admin->username = $user_name;
                $admin->full_name = $Request->full_name;
                $admin->admin = 1;
                $admin->password = Hash::make($password);
                $admin->save();

                $all_perm = "1111111111";
                $permissions = new Admin_permission();
                $permissions->statistics = $all_perm;
                $permissions->teachers = $all_perm;
                $permissions->students = $all_perm;
                $permissions->countries = $all_perm;
                $permissions->home_work = $all_perm;
                $permissions->levels = $all_perm;
                $permissions->audios = $all_perm;
                $permissions->notifications = $all_perm;
                $permissions->admins = $all_perm;
                $permissions->groups = $all_perm;
                $permissions->settings = $all_perm;
                $permissions->sub_groups = $all_perm;
                $permissions->admin_id = $admin->id;
                $permissions->save();

                return Redirect::route('login')->withErrors(array('success' => "تم تسجيل الحساب يمكنك الان تسجيل الدخول"));
            }
            else
            {
                return Redirect::back()->withErrors(array('error' => "خطأ برجاء أدخال جميع البيانات"));
            }
        }
        else
        {
            abort(404);
        }
    }

    public function logout()
    {
        auth('admins')->logout();
        return Redirect::route('login');
    }

    public function changeLang($lang)
    {
        if(in_array($lang, ['ar', 'en']))
        {
            if(auth('admins')->user())
            {
                $user = auth('admins')->user();
                $user->lang = $lang;
                $user->save();
            }
            else
            {
                if(session()->has('lang'))
                {
                    session()->forget('lang');
                }
                session()->put('lang', $lang);
            }
        }
        else
        {
            if(auth('admins')->user())
            {
                $user = auth('admins')->user();
                $user->lang = 'ar';
                $user->save();
            }
            else
            {
                if(session()->has('lang'))
                {
                    session()->forget('lang');
                }
            }
            session()->put('lang', 'ar');
        }
        return back();
    }

}
