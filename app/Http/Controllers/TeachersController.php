<?php

namespace App\Http\Controllers;

use App\Country;
use App\Helper\MyHelper;
use App\Level;
use App\Sub_group;
use App\Test_audio;
use App\User;
use App\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Response;
use View;
use File;

class TeachersController extends Controller
{
    public function add_teacher()
    {
        $levels = Level::all();
        $countries = Country::all();
        $countries_data = null;
        for($i =0; $i < count($countries); $i++)
        {
            // "al", "ad",
            if($i == 0)
            {
                $countries_data .= $countries[$i]->country_code;
            }
            else
            {
                $countries_data .= ','.$countries[$i]->country_code;
            }
        }
        return view('/teachers/add_teacher', [ 'levels' => $levels, 'countries_data' => $countries_data ]);
    }

    public function all_teachers()
    {
        $teachers = User::where('type', 'teacher')->orderBy('id', 'DESC')->paginate(20);
        return view('/teachers/all_teachers', [ 'teachers' => $teachers ]);
    }

    public function notify_all_teachers()
    {
        return view('/teachers/notify_all_teachers');
    }

    public function set_notify_all_teachers(Request $Request)
    {
        $notification_title = $Request->notification_title;
        $notification_body = $Request->notification;

        if($notification_title && $notification_body)
        {
            if(MyHelper::SendNotification($notification_title, $notification_body, null, 'teachers'))
            {
                $DB_notification = new Notification();
                $DB_notification->title = $notification_title;
                $DB_notification->notification = $notification_body;
                $DB_notification->type = 'teachers';
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

    public function notify_teacher($id)
    {
        $teacher = User::where('id', $id)->firstOrFail();
        return view('/teachers/notify_teacher', ['teacher' => $teacher,]);
    }

    public function set_notify_teacher(Request $Request)
    {
        $user_id = $Request->user_id;
        $notification_title = $Request->notification_title;
        $notification_body = $Request->notification;

        if($notification_title && $notification_body)
        {
            if(MyHelper::SendNotification($notification_title, $notification_body, $user_id))
            {
                $DB_notification = new Notification();
                $DB_notification->title = $notification_title;
                $DB_notification->notification = $notification_body;
                $DB_notification->user_id = $user_id;
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

    public function modify_teacher($id)
    {
        $levels = Level::all();
        $teacher = User::where('id', $id)->firstOrFail();
        $countries = Country::all();
        $countries_data = null;
        for($i =0; $i < count($countries); $i++)
        {
            // "al", "ad",
            if($i == 0)
            {
                $countries_data .= $countries[$i]->country_code;
            }
            else
            {
                $countries_data .= ','.$countries[$i]->country_code;
            }
        }

        return view('/teachers/modify_teacher', [ 'teacher' => $teacher, 'levels' => $levels, 'countries_data' => $countries_data ]);
    }

    public function change_teacher_level($id)
    {
        $levels = Level::all();
        $teacher = User::where('id', $id)->firstOrFail();
        $teacher_tests = Test_audio::where('user_id', $teacher->id)->get();

        return view('/teachers/teacher_level', [ 'teacher' => $teacher, 'levels' => $levels, 'teacher_tests' => $teacher_tests ]);
    }

    public function set_teacher_level(Request $Request)
    {
        $teacher_id = $Request->teacher_id;
        $level = Level::where('id', $Request->level)->firstOrFail();

        $teacher = User::where('id', $teacher_id)->firstOrFail();

        if($Request->level == $teacher->level_id)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ المستوي الذي اخترتة هو مستوي المعلم الحالي!", "Error The level you chose is the current level of the teacher!");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }


        $teacher->level_id = $Request->level;
        $teacher->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم تحديد و تغير مستوي المعلم بنجاح", "Teacher level successfully determined and changed");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function update_teacher_data(Request $request)
    {
        $user = User::where('id', $request->teacher_id)->firstOrFail();
        $rules = array(
            'username' => 'required|min:4|max:50',
            'phone' => 'required|min:3|max:50',
            'full_phone' => 'required',
            'country_iso' => 'required',
            'birthday' => 'required',
            'quran_parts'=>'required',
            'spare_time' => 'required',
            'workـhours'=>'required',
            'level' => 'required',
            'mogazh' => 'required',
            //'mastery_certificates_num' => 'required',
        );

        if($request->email != $user->email)
        {
            $rules['email'] = 'required|string|email|max:255|unique:users';
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
                'username.min'=>'أسم المستخدم يجب أن لا يقل عن 4 أحرف',
                'username.max'=>'أسم المستخدم يجب أن لا يزيد عن 50 حرف',
                'email.required'=>'برجاء أدخال البريد الإلكتروني',
                'email.string'=>'برجاء أدخال بريد الإلكتروني صحيح',
                'email.email'=>'برجاء أدخال بريد الإلكتروني صحيح',
                'email.max:255'=>'برجاء أدخال بريد الإلكتروني صحيح',
                'email.unique'=>'البريد الإلكتروني الذي أدخلته مُستخدم مسبقا',
                'password.required'=>'برجاء أدخال كلمة المرور',
                'password.string'=>'كلمة المرور يجب انت تحتوي علي حروف',
                'password.min'=>'كلمة المرور يجب الا تقل عن 5 حروف',
                'password.confirmed'=>'كلمة المرور و إعادة كلمة المرور غير متشابهين',
                'password_confirmation.required'=>'برجاء أدخال تأكيد كلمة المرور',
                'phone.required'=>'برجاء أدخال رقم الهاتف',
                'full_phone.required'=>'برجاء أضافة دولة اولا و أختيار الدولة عند أدخال رقم الهاتف',
                'country_iso.required'=>'أدخال أختيار الدولة',
                'birthday.required'=>'برجاء أدخال تاريخ الميلاد',
                'quran_parts.required'=>'برجاء أدخال كم جزء من القران',
                'spare_time.required'=>'برجاء أدخال وقت الفراغ',
                'workـhours.required'=>'برجاء أدخال عدد ساعات العمل',
                'level.required'=>'برجاء أختيار المستوي',
                'mogazh.required'=>'برجاء أختيار مجازة ام لا',
                'mastery_certificates_num.required'=>'برجاء أدخال عدد شهادات الاتقان',
            );
        }
        elseif (app()->getLocale() == 'en')
        {

            $messages = array(
                'username.required'=>'Please enter your username',
                'username.min'=>'Username should not be less than 4 letters',
                'username.max'=>'Username should not be more than 50 letters',
                'email.required'=>'Please enter your email address',
                'email.string'=>'Please enter valid email address',
                'email.email'=>'Please enter valid email address',
                'email.max:255'=>'Please enter valid email address',
                'email.unique'=>'The email you entered already exists',
                'password.required'=>'Please enter your password',
                'password.string'=>'Password should contains letters and numbers',
                'password.min'=>'Password should not be less than 5 letters',
                'password.confirmed'=>'Password does not match the confirm password',
                'password_confirmation.required'=>'Please enter password confirmation',
                'phone.required'=>'Please enter your phone number',
                'full_phone.required'=>'Please add country first and select country while enter phone number',
                'country_iso.required'=>'Please add country',
                'birthday.required'=>'Please enter phone number',
                'quran_parts.required'=>'Please enter quran parts',
                'spare_time.required'=>'Please enter spare time',
                'workـhours.required'=>'Please enter working hours',
                'level.required'=>'Please select the level',
                'mogazh.required'=>'Please select mogazh or not',
                'mastery_certificates_num.required'=>'Please enter mastery certificates numbers',
            );
        }

        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $request->flashOnly('username', 'email', 'phone', 'email', 'birthday', 'quran_parts', 'spare_time', 'workـhours');
            //return redirect::back()->withErrors($FirstError);
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }
        else
        {
            $country = Country::where('country_code', $request->country_iso)->first();
            if(!empty($country))
            {
                $user->username = $request->username;
                $user->email = $request->email;
                $user->phone = $request->full_phone;
                $user->birthday = $request->birthday;
                $user->quran_parts = $request->quran_parts;
                $user->spare_time = $request->spare_time;
                $user->workـhours = $request->workـhours;
                $user->country_id = $country->id;
                $user->type = "teacher";
                if($request->level != "null")
                {
                    $user->level_id = $request->level;
                }
                if (isset($request->password))
                {
                    $user->password = Hash::make($request->password);
                }
                $user->lang = app()->getLocale();
                $user->mogazh = $request->mogazh == 'yes' ? 1 : 0;
                $user->mastery_certificates = $request->mastery_certificates_num;
                $user->save();
                return redirect()->back()->withErrors(array('success' => "لقد تم تعديل البيانات بنجاح"));
            }
            else
            {
                return Redirect::back()->withErrors(array('error' => "خطأ برجاء أعادة المحاولة"));
            }
        }
    }

    public function set_teacher(Request $request)
    {
        $rules = array(
            'username' => 'required|min:4|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:5|confirmed',
            'password_confirmation'=>'required|min:5',
            'phone' => 'required|min:3|max:50',
            'full_phone' => 'required',
            'country_iso' => 'required',
            'birthday' => 'required',
            'quran_parts'=>'required',
            'spare_time' => 'required',
            'workـhours'=>'required',
            'level' => 'required',
            'mogazh' => 'required',
            //'mastery_certificates_num' => 'required',
        );


        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'username.required'=>'برجاء أدخال أسم المستخدم',
                'username.min'=>'أسم المستخدم يجب أن لا يقل عن 4 أحرف',
                'username.max'=>'أسم المستخدم يجب أن لا يزيد عن 50 حرف',
                'email.required'=>'برجاء أدخال البريد الإلكتروني',
                'email.string'=>'برجاء أدخال بريد الإلكتروني صحيح',
                'email.email'=>'برجاء أدخال بريد الإلكتروني صحيح',
                'email.max:255'=>'برجاء أدخال بريد الإلكتروني صحيح',
                'email.unique'=>'البريد الإلكتروني الذي أدخلته مُستخدم مسبقا',
                'password.required'=>'برجاء أدخال كلمة المرور',
                'password.string'=>'كلمة المرور يجب انت تحتوي علي حروف',
                'password.min'=>'كلمة المرور يجب الا تقل عن 5 حروف',
                'password.confirmed'=>'كلمة المرور و إعادة كلمة المرور غير متشابهين',
                'password_confirmation.required'=>'برجاء أدخال تأكيد كلمة المرور',
                'phone.required'=>'برجاء أدخال رقم الهاتف',
                'full_phone.required'=>'برجاء أضافة دولة اولا و أختيار الدولة عند أدخال رقم الهاتف',
                'country_iso.required'=>'أدخال أختيار الدولة',
                'birthday.required'=>'برجاء أدخال تاريخ الميلاد',
                'quran_parts.required'=>'برجاء أدخال كم جزء من القران',
                'spare_time.required'=>'برجاء أدخال وقت الفراغ',
                'workـhours.required'=>'برجاء أدخال عدد ساعات العمل',
                'level.required'=>'برجاء أختيار المستوي',
                'mogazh.required'=>'برجاء أختيار مجازة ام لا',
                'mastery_certificates_num.required'=>'برجاء أدخال عدد شهادات الاتقان',
            );
        }
        elseif (app()->getLocale() == 'en')
        {

            $messages = array(
                'username.required'=>'Please enter your username',
                'username.min'=>'Username should not be less than 4 letters',
                'username.max'=>'Username should not be more than 50 letters',
                'email.required'=>'Please enter your email address',
                'email.string'=>'Please enter valid email address',
                'email.email'=>'Please enter valid email address',
                'email.max:255'=>'Please enter valid email address',
                'email.unique'=>'The email you entered already exists',
                'password.required'=>'Please enter your password',
                'password.string'=>'Password should contains letters and numbers',
                'password.min'=>'Password should not be less than 5 letters',
                'password.confirmed'=>'Password does not match the confirm password',
                'password_confirmation.required'=>'Please enter password confirmation',
                'phone.required'=>'Please enter your phone number',
                'full_phone.required'=>'Please add country first and select country while enter phone number',
                'country_iso.required'=>'Please add country',
                'birthday.required'=>'Please enter phone number',
                'quran_parts.required'=>'Please enter quran parts',
                'spare_time.required'=>'Please enter spare time',
                'workـhours.required'=>'Please enter working hours',
                'level.required'=>'Please select the level',
                'mogazh.required'=>'Please select mogazh or not',
                'mastery_certificates_num.required'=>'Please enter mastery certificates numbers',
            );
        }

        $validator = Validator::make($request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $request->flashOnly('username', 'email', 'phone', 'email', 'birthday', 'quran_parts', 'spare_time', 'workـhours');
            //return redirect::back()->withErrors($FirstError);
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }
        else
        {

            $country = Country::where('country_code', $request->country_iso)->first();
            if(!empty($country))
            {
                $user = new User();
                $user->username = $request->username;
                $user->email = $request->email;
                $user->phone = $request->full_phone;
                $user->birthday = $request->birthday;
                $user->quran_parts = $request->quran_parts;
                $user->spare_time = $request->spare_time;
                $user->workـhours = $request->workـhours;
                $user->country_id = $country->id;
                $user->type = "teacher";
                if($request->level != "null")
                {
                    $user->level_id = $request->level;
                }
                $user->password = Hash::make($request->password);
                $user->mogazh = $request->mogazh == 'yes' ? 1 : 0;
                $user->mastery_certificates = $request->mastery_certificates_num;
                $user->lang = app()->getLocale();
                $user->save();
                return redirect()->back()->withErrors(array('success' => "لقد تم انشاء الحساب بنجاح"));
            }
            else
            {
                return Redirect::back()->withErrors(array('error' => "خطأ برجاء أعادة المحاولة"));
            }
        }
    }

    public function delete_teacher(Request $request)
    {
        $teacher_id = $request->teacher_id;

        $teacher = User::where('id', $teacher_id)->firstOrFail();
        $teacher_test_audio = Test_audio::where('user_id', $teacher->id)->first();

        if($teacher->delete())
        {
            File::delete($teacher_test_audio->file_path);
            $teacher_test_audio->delete();
            return Redirect::back()->withErrors(array('success' => "تم حذف المعلم بنجاح"));

        }
        else
        {
            return Redirect::back()->withErrors(array('error' => "خطأ برجاء أعادة المحاولة"));
        }
    }

    public function delete_teacher_from_group(Request $request)
    {
        $teacher_id = $request->teacher_id;
        $group_id = $request->group_id;

        $group = Sub_group::where('id', $group_id)->where('admin_id', $teacher_id)->firstOrFail();

        $group->admin_id = null;
        $group->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم حذف المعلم من الجروب بنجاح", "Teacher deleted from the group successfully");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function add_teacher_to_groups(Request $request)
    {
        $teacher_id = $request->teacher_id;
        $group_id = $request->group_id;


        $teacher = User::where('id', $teacher_id)->firstOrFail();

        if(!$teacher->level_id)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }

        $group = Sub_group::where('id', $group_id)->firstOrFail();

        $group->admin_id = $teacher_id;
        $group->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم أضافة المعلم الي الجروب بنجاح", "Teacher successfully added to the group");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function find_teacher(Request $Request)
    {
        $keyword = $Request->keyword;
        $all = $Request->all;
        $search_by = $Request->search_by;

        if($all == 'yes')
        {
            $teachers = User::where('type', 'teacher')->orderBy('id', 'DESC')->paginate(20);
            $teachers->setPath('/teachers');
        }
        else
        {
            if($search_by == "email")
            {
                $teachers = User::where('type', 'teacher')->where('email','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
            elseif ($search_by == "username")
            {
                $teachers = User::where('type', 'teacher')->where('username','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
            elseif($search_by == "phone")
            {
                $teachers = User::where('type', 'teacher')->where('phone','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
            else
            {
                $teachers = User::where('type', 'teacher')->where('username','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
        }
        return Response::json(View::make('teachers.find_teacher_tl', array('teachers' => $teachers, 'all' => $all))->render());
    }

}
