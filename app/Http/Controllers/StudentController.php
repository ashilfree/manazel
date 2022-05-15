<?php

namespace App\Http\Controllers;

use App\Country;
use App\Group;
use App\Helper\MyHelper;
use App\Level;
use App\Notification;
use App\Sub_group;
use App\Test_audio;
use App\User;
use App\Users_group;
use App\Users_homework;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Response;
use View;
use File;

class StudentController extends Controller
{
    public function add_student()
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
        return view('/students/add_student', [ 'levels' => $levels, 'countries_data' => $countries_data ]);
    }

    public function all_students()
    {
        $students = User::where('type', 'student')->orderBy('id', 'DESC')->paginate(20);
        return view('/students/all_students', [ 'students' => $students ]);
    }

    public function notify_all_students()
    {
        return view('/students/notify_all_students');
    }

    public function student_assignment_log()
    {

        $assignments_log = Users_homework::paginate(30);
        return view('/students/student_assignment_log', [ 'assignments_log' => $assignments_log ]);
    }

    public function change_student_level($id)
    {
        $levels = Level::all();
        $student = User::where('id', $id)->firstOrFail();
        $student_tests = Test_audio::where('user_id', $student->id)->get();

        return view('/students/student_level', [ 'student' => $student, 'levels' => $levels, 'student_tests' => $student_tests ]);
    }

    public function notify_student($id)
    {
        $student = User::where('id', $id)->firstOrFail();
        return view('/students/notify_student', ['student' => $student,]);
    }

    public function set_notify_student(Request $Request)
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

    public function set_notify_all_students(Request $Request)
    {
        $notification_title = $Request->notification_title;
        $notification_body = $Request->notification;

        if($notification_title && $notification_body)
        {
            if(MyHelper::SendNotification($notification_title, $notification_body, null, 'students'))
            {
                $DB_notification = new Notification();
                $DB_notification->title = $notification_title;
                $DB_notification->notification = $notification_body;
                $DB_notification->type = 'students';
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

    public function set_student_level(Request $Request)
    {
        $student_id = $Request->student_id;
        $level = Level::where('id', $Request->level)->firstOrFail();

        $student = User::where('id', $student_id)->firstOrFail();

       /* if($Request->level == $student->level_id)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ المستوي الذي اخترتة هو مستوي الطالب الحالي!", "Error The level you chose is the current level of the student!");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }   */


        $student->level_id = $Request->level;
        $student->sub_level_id = $Request->sub_level;
        $student->save();

        if($Request->sub_level)
        {
            //DB::enableQueryLog(); // Enable query log
            $group = DB::select("SELECT * FROM sub_groups INNER JOIN `groups` ON sub_groups.group_id = groups.id WHERE groups.sub_level_id=".$student->sub_level_id." AND (SELECT COUNT(*) FROM sub_groups INNER JOIN users_groups ON sub_groups.id = users_groups.sub_group_id) < sub_groups.max_students ORDER by sub_groups.id ASC LIMIT 1");

            //Log::debug(DB::getQueryLog());
            $group = array_shift($group);
        }
        else
        {
            //DB::enableQueryLog(); // Enable query log
            $group = DB::select("SELECT * FROM sub_groups INNER JOIN `groups` ON sub_groups.group_id = groups.id WHERE groups.level_id=".$student->level_id." AND groups.sub_level_id=null AND (SELECT COUNT(*) FROM sub_groups INNER JOIN users_groups ON sub_groups.id = users_groups.sub_group_id) < sub_groups.max_students ORDER by sub_groups.id ASC LIMIT 1");

            //Log::debug(DB::getQueryLog());
            $group = array_shift($group);
        }

        if(!$group)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("تم تحديد وتغير مستوي الطالب ولم يتم أضافة الطالب الي جروب لعدم وجود جروب متاح", "Student level successfully changed but there is no group avilable with same student level");
            return Redirect::back()->withErrors(array('success' => $redirect_message));
        }

        $users_groups = new Users_group();
        $users_groups->user_id = $student->id;
        $users_groups->sub_group_id = $group->id;
        $users_groups->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم تحديد و تغير مستوي الطالب بنجاح و تم إضافة الطالب الي جروب : " . $group->name, "Student level successfully determined and changed, student added to group : " . $group->en_name);
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function modify_student($id)
    {
        $levels = Level::all();
        $student = User::where('id', $id)->firstOrFail();
        $countries = Country::all();
        $countries_data = null;
        $student_assignment_log = Users_homework::where('user_id', $student->id)->paginate(30);

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

        return view('/students/modify_student', [ 'student' => $student, 'levels' => $levels, 'countries_data' => $countries_data, 'student_assignment_log' => $student_assignment_log ]);
    }

    public function set_student(Request $request)
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
            'level' => 'required',
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
                'country_iso.required'=>'برجاء أختيار الدولة',
                'birthday.required'=>'برجاء أدخال تاريخ الميلاد',
                'quran_parts.required'=>'برجاء أدخال كم جزء من القران',
                'level.required'=>'برجاء أختيار المستوي',
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
                'level.required'=>'Please select the level',
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
                $user->country_id = $country->id;
                $user->type = "student";
                if($request->level != "null")
                {
                    $user->level_id = $request->level;
                }
                $user->password = Hash::make($request->password);
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

    public function update_student_data(Request $request)
    {
        $user = User::where('id', $request->student_id)->firstOrFail();
        $rules = array(
            'username' => 'required|min:4|max:50',
            'phone' => 'required|min:3|max:50',
            'full_phone' => 'required',
            'country_iso' => 'required',
            'birthday' => 'required',
            'quran_parts'=>'required',
            'level' => 'required',
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
                'level.required'=>'برجاء أختيار المستوي',
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
                'level.required'=>'Please select the level',
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
                $user->type = "student";
                if($request->level != "null")
                {
                    $user->level_id = $request->level;
                }
                if (isset($request->password))
                {
                    $user->password = Hash::make($request->password);
                }
                $user->lang = app()->getLocale();
                $user->save();
                return redirect()->back()->withErrors(array('success' => "لقد تم تعديل البيانات بنجاح"));
            }
            else
            {
                return Redirect::back()->withErrors(array('error' => "خطأ برجاء أعادة المحاولة"));
            }
        }
    }

    public function change_student_group(Request $request)
    {
        $student_id = $request->student_id;
        $group_id = $request->group_id;


        $student = User::where('id', $student_id)->firstOrFail();

        if(!$student->level_id || !$student->sub_level_id)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }

        $group = Sub_group::where('id', $group_id)->firstOrFail();
        $main_group = Group::where('id', $group->group_id)->firstOrFail();

        if($student->sub_level_id != $main_group->sub_level_id)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }

        $student_groups = Users_group::where('user_id', $student->id)->get();

        foreach ($student_groups as $groups)
        {
            $groups->delete();
        }


        $student_group = new Users_group();
        $student_group->user_id = $student->id;
        $student_group->sub_group_id = $group->id;
        $student_group->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم تغير جروب الطالب بنجاح", "Student group successfully changed");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function delete_student(Request $request)
    {
        $student_id = $request->student_id;
        $student = User::where('id', $student_id)->firstOrFail();
        $student_test_audio = Test_audio::where('user_id', $student->id)->first();

        if($student->delete())
        {
            File::delete($student_test_audio->file_path);
            $student_test_audio->delete();
            return Redirect::back()->withErrors(array('success' => "تم حذف الطالب بنجاح"));

        }
        else
        {
            return Redirect::back()->withErrors(array('error' => "خطأ برجاء أعادة المحاولة"));
        }
    }

    public function delete_student_from_group(Request $request)
    {
        $student_id = $request->student_id;
        $group_id = $request->group_id;

        $group = Users_group::where('user_id', $student_id)->where('sub_group_id', $group_id)->firstOrFail();

        $group->delete();

        $redirect_message = MyHelper::ReturnMessageByLang("تم حذف الطالب من الجروب بنجاح", "Student successfully deleted from the group");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function find_student(Request $Request)
    {
        $keyword = $Request->keyword;
        $all = $Request->all;
        $search_by = $Request->search_by;

        if($all == 'yes')
        {
            $students = User::where('type', 'student')->orderBy('id', 'DESC')->paginate(20);
            $students->setPath('/students');
        }
        else
        {
            if($search_by == "email")
            {
                $students = User::where('email','LIKE','%'.$keyword.'%')->where('type', 'student')->orderBy('id', 'DESC')->paginate(10);
            }
            elseif ($search_by == "username")
            {
                $students = User::where('username','LIKE','%'.$keyword.'%')->where('type', 'student')->orderBy('id', 'DESC')->paginate(10);
            }
            else
            {
                $students = User::where('username','LIKE','%'.$keyword.'%')->where('type', 'student')->orderBy('id', 'DESC')->paginate(10);
            }
        }
        return Response::json(View::make('students.find_student_tl', array('students' => $students, 'all' => $all))->render());
    }
}
