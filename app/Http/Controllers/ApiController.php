<?php

namespace App\Http\Controllers;

use App\App_guide;
use App\Country;
use App\Groups_message;
use App\Helper\MyHelper;
use App\Home_work;
use App\Level;
use App\Notification;
use App\Setting;
use App\Sub_group;
use App\Sub_level;
use App\Support_message;
use App\User;
use App\Users_group;
use App\Users_homework;
use App\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Validator;
use Response;
use File;

class ApiController extends Controller
{
    public function ayah_test()
    {
        $ayah = Setting::where('type', 'test_ayat')->inRandomOrder()->first();
        return response()->json($ayah);
    }

    public function edit_photo(Request $request)
    {
        $rules['image'] = 'mimetypes:image/png,image/jpeg,image/gif';

        if(app()->getLocale() == 'ar')
        {
            $messages = array('image.mimetypes'=>'عفوا ملف الصورة يجب ان يكون من نوع jpg, gif, jpeg, png');
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array('image.mimetypes'=>'The image file must be png, jpeg, gif or jpg',);
        }
        $validator = Validator::make(array('image' => $request->image), $rules, $messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return Redirect::back()->withErrors(array('error' => $FirstError));
        }

        if($request->hasFile('image'))
        {
            if ($request->file('image')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $request->file('image')->getClientOriginalExtension();
                $path = $request->file('image')->storeAs('users_images', $file_name);
                if ($path)
                {

                    $user = auth('api')->user();
                    if(file_exists($user->image))
                    {
                        File::delete($user->image);
                    }
                    $user->image = storage_path('app/'.$path);
                    $user->save();
                }
            }
        }

        $output = array("state"=>1, "image"=> MyHelper::returnBase64Data($user->image));
        return response()->json($output);
    }

    public function get_photo()
    {
        $user = auth('api')->user();
        if(file_exists($user->image))
        {
            $output = array("state"=>1, "image"=> MyHelper::returnBase64Data($user->image));
            return response()->json($output);
        }
        else
        {
            $output = array("state"=>1, "error"=> "no image");
            return response()->json($output);
        }
    }

    public function country()
    {
        $countries = Country::all();

        return response()->json($countries);
    }

    public function update_user(Request $Request)
    {

        if($Request->type == "teacher")
        {
            $rules = array(
                'phoneNumber' => 'required',
                'bDate' => 'required',
                'quranParts' => 'required',
                'availableTimes' => 'required',
                'workingHours' => 'required',
            );
        }
        elseif ($Request->type == "student")
        {
            $rules = array(
                'phoneNumber' => 'required',
                'bDate' => 'required',
                'quranParts' => 'required',
            );
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error please try again"));
            return response()->json($output);
        }

        if($Request->email != auth('api')->user()->email)
        {
            $rules['email'] = 'required|string|max:25|unique:users';
        }

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
                'password.required'=>'برجاء أدخال كلمة المرور',
                'password.string'=>'كلمة المرور يجب انت تحتوي علي حروف',
                'password.min'=>'كلمة المرور يجب الا تقل عن 5 حروف',
                'phoneNumber.required'=>'برجاء أدخال رقم الهاتف',
                'bDate.required'=>'برجاء أدخال تاريخ الميلاد',
                'type.required'=>'خطأ برجاء إعادة المحاولة',
                'quranParts.required'=>'برجاء أدخال كم جزء تحفظ من القرآن',
                'availableTimes.required'=>'برجاء أدخال ساعات الفراغ',
                'workingHours.required'=>'برجاء أدخال  ساعات العمل',
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
                'password.required'=>'Please enter your password',
                'password.string'=>'Password should contains letters and numbers',
                'password.min'=>'Password should not be less than 5 letters',
                'phoneNumber.required'=>'Please enter your phone number',
                'bDate.required'=>'Please enter your birthday',
                'type.required'=>'Error please try again',
                'quranParts.required'=>'Please enter your Quran hifth parts',
                'availableTimes.required'=>'Please enter your available times',
                'workingHours.required'=>'Please enter your working hours',
            );
        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }

        $user = auth('api')->user();

        $user->email = $Request->email;
        $user->phone = $Request->phoneNumber;
        $user->birthday = $Request->bDate;
        $user->quran_parts = $Request->quranParts;
        if($Request->type == "teacher")
        {
            $user->spare_time = $Request->availableTimes;
            $user->workـhours = $Request->workingHours;
        }
        $user->save();

        $output = array("state"=>1, "message"=>MyHelper::ReturnMessageByLang("تم تعديل البيانات بنجاح", "Profile data successfully updated"));
        return response()->json($output);
    }

    public function update_password(Request $Request)
    {
        $rules = array('password' => 'required|string|min:5',);

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'password.required'=>'برجاء أدخال كلمة المرور',
                'password.string'=>'كلمة المرور يجب انت تحتوي علي حروف',
                'password.min'=>'كلمة المرور يجب الا تقل عن 5 حروف',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'password.required'=>'Please enter your password',
                'password.string'=>'Password should contains letters and numbers',
                'password.min'=>'Password should not be less than 5 letters',
            );
        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }

        $user = auth('api')->user();
        $user->password = Hash::make($Request->password);
        $user->save();
        $output = array("state"=>1, "message"=>MyHelper::ReturnMessageByLang("تم تغير كلمة المرور بنجاح", "Password successfully updated"));
        return response()->json($output);
    }

    public function get_assignment()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        if($user->level_id == null)
        {
            $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لم يتم تحديد المستوي بعد", "Level is not specified yet"));
            return response()->json($output);
        }
        else
        {
            if ($user->type == "teacher")
            {
                $teacher_group = Sub_group::where('admin_id', $user->id)->first();
                if($teacher_group)
                {
                    $week = Week::where('id', $teacher_group->week_id)->get();
                    if($week)
                    {
                        $level = Level::where('id', $user->level_id)->first();
                        $sub_level = Sub_level::where('id', $week[0]->sub_level_id)->first();

                        $output = array("state"=>1, "assignments" => $week, "level" => $level, 'sub_level' => $sub_level);
                        return response()->json($output);
                    }
                    else
                    {
                        $assignments = Home_work::where('level_id', $user->level_id)->get();

                        if($assignments)
                        {
                            $level = Level::where('id', $user->level_id)->first();
                            $output = array("state"=>1, "assignments" => $assignments, "level" => $level);
                            return response()->json($output);
                        }
                        else
                        {
                            $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لا يوجد واجب لمستواك الحالي بعد", "There is no assignment for your current level yet"));
                            return response()->json($output);
                        }
                    }
                }
                else
                {
                    $assignments = Home_work::where('level_id', $user->level_id)->get();

                    if($assignments)
                    {
                        $level = Level::where('id', $user->level_id)->first();
                        $output = array("state"=>1, "assignments" => $assignments, "level" => $level);
                        return response()->json($output);
                    }
                    else
                    {
                        $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لا يوجد واجب لمستواك الحالي بعد", "There is no assignment for your current level yet"));
                        return response()->json($output);
                    }
                }
            }
            if($user->sub_level_id != null)
            {
                $user_group = Users_group::where('user_id', $user->id)->first();
                $group = Sub_group::where('id', $user_group->sub_group_id)->first();

                $week = Week::where('id', $group->week_id)->get();

                if($week)
                {
                    $level = Level::where('id', $user->level_id)->first();
                    $sub_level = Sub_level::where('id', $user->sub_level_id)->first();

                    $output = array("state"=>1, "assignments" => $week, "level" => $level, 'sub_level' => $sub_level);
                    return response()->json($output);
                }
                else
                {
                    $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لا يوجد واجب حاليا", "There is no assignment yet"));
                    return response()->json($output);
                }

            }
            else
            {
                $assignments = Home_work::where('level_id', $user->level_id)->get();

                if($assignments)
                {
                    $level = Level::where('id', $user->level_id)->first();
                    $output = array("state"=>1, "assignments" => $assignments, "level" => $level);
                    return response()->json($output);
                }
                else
                {
                    $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لا يوجد واجب لمستواك الحالي بعد", "There is no assignment for your current level yet"));
                    return response()->json($output);
                }
            }
        }
    }

    public function get_messages($page, $per_page)
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        if ($user->type == "teacher")
        {
            $student_id = $_GET['si'];
            Log::debug($student_id);
            $student_group = Users_group::where('user_id', $student_id)->first();
            $user_group = Sub_group::where('admin_id', $user->id)->where('id', $student_group->sub_group_id)->first();
            if($user_group)
            {
                $date = \Carbon\Carbon::parse($user_group->ban_to);
                $now = \Carbon\Carbon::now();
                if($user_group->ban_to > $now && $user_group->ban_from < $now)
                {
                    $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
                    return response()->json($output);
                }
                //$group = Sub_group::where('id', $user_group->sub_group_id)->first();
                $messages = Groups_message::where('user_id', $student_id)->where('teacher_id', $user->id)->offset($page)->limit($per_page)->orderBy('id', 'desc')->get();
                foreach ($messages as $message)
                {
                    //$username = User::select('username')->where('id', $message->user_id)->first();
                    //$message->username = $username->username;
                    if($message->type == "audio")
                    {
                        $message->record_duration = $message->message;
                        $message->message = MyHelper::returnBase64Data($message->file_path);
                    }
                }
            }
            else
            {
                $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لم يتم أضافة حسابك في جروب بعد", "Your account has not been added a group yet"));
                return response()->json($output);
            }
        }
        elseif ($user->type == "student")
        {
            $user_group = Users_group::where('user_id', $user->id)->first();
            if($user_group)
            {
                $group = Sub_group::where('id', $user_group->sub_group_id)->first();
                $date = \Carbon\Carbon::parse($group->ban_to);
                $now = \Carbon\Carbon::now();
                if($group->ban_to > $now && $group->ban_from < $now)
                {
                    $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
                    return response()->json($output);
                }
                $messages = Groups_message::where('user_id', $user->id)->where('teacher_id', $group->admin_id)->offset($page)->limit($per_page)->orderBy('id', 'desc')->get();
                foreach ($messages as $message)
                {
                    //$username = User::select('username')->where('id', $message->user_id)->first();
                    //$message->username = $username->username;
                    if($message->type == "audio")
                    {
                        $message->record_duration = $message->message;
                        $message->message = MyHelper::returnBase64Data($message->file_path);
                    }
                }
            }
            else
            {
                $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لم يتم أضافة حسابك في جروب بعد", "Your account has not been added a group yet"));
                return response()->json($output);
            }
        }

        $output = array("state"=>1, "messages"=>$messages);
        return response()->json($output);
        //echo json_encode($messages);
    }


    public function get_new_messages($last_id)
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        if ($user->type == "teacher")
        {
            $student_id = $_GET['si'];
            $student_group = Users_group::where('user_id', $student_id)->first();
            $user_group = Sub_group::where('admin_id', $user->id)->where('id', $student_group->sub_group_id)->first();
            if($user_group)
            {
                $date = \Carbon\Carbon::parse($user_group->ban_to);
                $now = \Carbon\Carbon::now();
                if($user_group->ban_to > $now && $user_group->ban_from < $now)
                {
                    $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
                    return response()->json($output);
                }
                //$group = Sub_group::where('id', $user_group->sub_group_id)->first();
                $new_messages = Groups_message::where('id', '>', $last_id)->where('user_id', $student_id)->where('teacher_id', $user->id)->get();

                foreach ($new_messages as $message)
                {
                    //$username = User::select('username')->where('id', $message->user_id)->first();
                    //$message->username = $username->username;
                    if($message->type == "audio")
                    {
                        $message->record_duration = $message->message;
                        $message->message = MyHelper::returnBase64Data($message->file_path);
                    }
                }
            }
            else
            {
                $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لم يتم أضافة حسابك في جروب بعد", "Your account has not been added a group yet"));
                return response()->json($output);
            }
        }
        elseif ($user->type == "student")
        {
            $user_group = Users_group::where('user_id', $user->id)->first();

            if($user_group)
            {
                $group = Sub_group::where('id', $user_group->sub_group_id)->first();
                $date = \Carbon\Carbon::parse($group->ban_to);
                $now = \Carbon\Carbon::now();
                if($group->ban_to > $now && $group->ban_from < $now)
                {
                    $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
                    return response()->json($output);
                }
                $new_messages = Groups_message::where('id', '>', $last_id)->where('user_id', $user->id)->where('teacher_id', $group->admin_id)->get();
                foreach ($new_messages as $message)
                {
                    //$username = User::select('username')->where('id', $message->user_id)->first();
                    //$message->username = $username->username;
                    if($message->type == "audio")
                    {
                        $message->record_duration = $message->message;
                        $message->message = MyHelper::returnBase64Data($message->file_path);
                    }
                }
            }
        }

        $output = array("state"=>1, "messages"=>$new_messages);
        return response()->json($output);
        //echo json_encode($new_messages);
    }

    public function set_message(Request $Request)
    {
        app()->setLocale($_GET['lang']);
        $message = $Request->message;
        $user = auth('api')->user();

        if ($user->type == "teacher")
        {
            $student_id = $_GET['si'];
            $student_group = Users_group::where('user_id', $student_id)->first();
            $user_group = Sub_group::where('admin_id', $user->id)->where('id', $student_group->sub_group_id)->first();
            if($user_group)
            {
                $date = \Carbon\Carbon::parse($user_group->ban_to);
                $now = \Carbon\Carbon::now();
                if($user_group->ban_to > $now && $user_group->ban_from < $now)
                {
                    $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
                    return response()->json($output);
                }
                $g_message = new Groups_message();
                $g_message->message = nl2br($message);
                $g_message->type = "text";
                $g_message->user_id = $student_id;
                $g_message->teacher_id = $user->id;
                $g_message->sender_id = $user->id;
                $g_message->sub_group_id = $user_group->id;
                $g_message->save();
                $output = array("state"=>1, "messages"=>"done");
                return response()->json($output);
            }

        }
        elseif ($user->type == "student")
        {
            $user_group = Users_group::where('user_id', $user->id)->first();
            $group = Sub_group::where('id', $user_group->sub_group_id)->first();
            $date = \Carbon\Carbon::parse($group->ban_to);
            $now = \Carbon\Carbon::now();
            if($group->ban_to > $now && $group->ban_from < $now)
            {
                $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
                return response()->json($output);
            }
            if($group->admin_id)
            {
                $g_message = new Groups_message();
                $g_message->message = nl2br($message);
                $g_message->type = "text";
                $g_message->user_id = $user->id;
                $g_message->teacher_id = $group->admin_id;
                $g_message->sender_id = $user->id;
                $g_message->sub_group_id = $group->id;
                $g_message->save();
                $output = array("state"=>1, "messages"=>"done");
                return response()->json($output);
            }
            else
            {
                $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لم يتم أضافة معلم للجروب بعد", "No teacher has been added to the group yet"));
                return response()->json($output);
            }
        }
        else
        {
            $output = array("state"=>0, "message"=> $user->type);
            return response()->json($output);
        }
    }

    public function set_rec_message(Request $Request)
    {
        app()->setLocale($Request->lang);
        $message = $Request->message;
        $user = auth('api')->user();

        if ($user->type == "teacher")
        {
            $student_id = $Request->si;
            $student_group = Users_group::where('user_id', $student_id)->first();
            $user_group = Sub_group::where('admin_id', $user->id)->where('id', $student_group->sub_group_id)->first();

            $date = \Carbon\Carbon::parse($user_group->ban_to);
            $now = \Carbon\Carbon::now();
            if($user_group->ban_to > $now && $user_group->ban_from < $now)
            {
                $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
                return response()->json($output);
            }

            if($user_group)
            {
                $file = $Request->file;
                //$user_id = $Request->user_id;
                $record_duration = $Request->record_duration;
                \Log::info($record_duration);
                if($Request->hasFile('file'))
                {
                    if ($Request->file('file')->isValid())
                    {
                        $file_name = md5(uniqid(time())) . '.' . $Request->file('file')->getClientOriginalExtension();
                        $path = $Request->file('file')->storeAs('recorded_masseges', $file_name);
                        if ($path)
                        {
                            $g_message = new Groups_message();
                            $g_message->message = $record_duration;
                            $g_message->type = "audio";
                            $g_message->file_path = storage_path('app/'.$path);
                            $g_message->file_name = $file_name;
                            $g_message->user_id = $student_id;
                            $g_message->teacher_id = $user->id;
                            $g_message->sender_id = $user->id;
                            $g_message->sub_group_id = $user_group->id;
                            $g_message->save();

                            $output = array("state"=>1, "messages"=>"done");
                            return response()->json($output);
                        }
                    }
                }
            }
        }
        elseif ($user->type == "student")
        {
            $user_group = Users_group::where('user_id', $user->id)->first();
            $group = Sub_group::where('id', $user_group->sub_group_id)->first();

            $date = \Carbon\Carbon::parse($group->ban_to);
            $now = \Carbon\Carbon::now();
            if($group->ban_to > $now && $group->ban_from < $now)
            {
                $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
                return response()->json($output);
            }

            if($group->admin_id)
            {
                //$user_id = $Request->user_id;
                $record_duration = $Request->record_duration;

                if($Request->hasFile('file'))
                {
                    if ($Request->file('file')->isValid())
                    {
                        $file_name = md5(uniqid(time())) . '.' . $Request->file('file')->getClientOriginalExtension();
                        $path = $Request->file('file')->storeAs('recorded_masseges', $file_name);
                        if ($path)
                        {
                            $g_message = new Groups_message();
                            $g_message->message = $record_duration;
                            $g_message->type = "audio";
                            $g_message->file_path = storage_path('app/'.$path);
                            $g_message->file_name = $file_name;
                            $g_message->user_id = $user->id;
                            $g_message->teacher_id = $group->admin_id;
                            $g_message->sender_id = $user->id;
                            $g_message->sub_group_id = $group->id;
                            $g_message->save();

                            $output = array("state"=>1, "messages"=>"done");
                            return response()->json($output);
                        }
                    }
                }
            }
            else
            {
                $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لم يتم أضافة معلم للجروب بعد", "No teacher has been added to the group yet"));
                return response()->json($output);
            }
        }
        else
        {
            $output = array("state"=>0, "message"=> $user->type);
            return response()->json($output);
        }
    }

    public function teacher_groups()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        $groups = Sub_group::where('admin_id', $user->id)->get();
        if($groups)
        {
            foreach($groups as $group)
            {
                $date = \Carbon\Carbon::parse($group->ban_to);
                $now = \Carbon\Carbon::now();
                if($group->ban_to > $now && $group->ban_from < $now)
                {
                    $group->status = "banned";
                }
                else
                {
                    $group->status = "working";
                }
            }
            $output = array("state"=>1, "groups"=>$groups);
            return response()->json($output);
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لم يتم أضافة حسابك في جروب بعد", "Your account has not been added a group yet"));
            return response()->json($output);
        }
    }

    public function group_students()
    {
        app()->setLocale($_GET['lang']);
        $group_id = $_GET['group'];
        $user = auth('api')->user();
        $groups = Sub_group::where('id', $group_id)->first();

        if($groups)
        {
            if($groups->admin_id == $user->id)
            {
                $students_group = Users_group::where('sub_group_id', $groups->id)->get();
                $students = [];
                foreach ($students_group as $student_group)
                {
                    $user_data = User::select('id', 'username')->where('id', $student_group->user_id)->first();
                    array_push($students, $user_data);
                }


                $current_week = Week::where('id', $groups->week_id)->first();
                if($current_week)
                {
                    $next_week = Week::where('week_number', $current_week->week_number+1)->first();
                    $output = array("state"=>1, "students"=>$students, 'next_week' => $next_week);
                    return response()->json($output);
                }
                else
                {
                    $output = array("state"=>1, "students"=>$students, 'next_week' => []);
                    return response()->json($output);
                }

            }
            else
            {
                $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again"));
                return response()->json($output);
            }

        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لم يتم أضافة حسابك في جروب بعد", "Your account has not been added a group yet"));
            return response()->json($output);
        }
    }

    public function move_to_next_week()
    {
        app()->setLocale($_GET['lang']);
        $group_id = intval($_GET['group']);
        $user = auth('api')->user();
        $groups = Sub_group::where('id', $group_id)->first();

        if($groups)
        {
            if($groups->admin_id == $user->id)
            {
                $current_week = Week::where('id', $groups->week_id)->first();
                if($current_week)
                {
                    $next_week = Week::where('week_number', $current_week->week_number+1)->first();

                    if($next_week)
                    {
                        $groups->week_id = $next_week->id;
                        $groups->save();
                        $output = array("state"=>1, "message"=>MyHelper::ReturnMessageByLang("تم الانتقال الي ".$next_week->week_name." في الجروب بنجاح", "Group changed to ".$next_week->week_en_name." successfully"));
                        return response()->json($output);
                    }
                    else
                    {
                        $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("لم يتم أضافة أسبوع تالي بعد", "There no next week yet"));
                        return response()->json($output);
                    }
                }
                else
                {
                    $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لم يتم تحديد الاسبوع الحالي للجروب بعد", "Group start week has not selected yet"));
                    return response()->json($output);
                }
            }
            else
            {
                $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again"));
                return response()->json($output);
            }

        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لم يتم أضافة حسابك في جروب بعد", "Your account has not been added a group yet"));
            return response()->json($output);
        }
    }

    public function user_read(Request $Request)
    {
        app()->setLocale($_GET['lang']);
        $student_id = $Request->si;
        $read_status = $Request->status;
        $user = auth('api')->user();
        $student = User::where('id', $student_id)->first();

        $student_group = Users_group::where('user_id', $student_id)->first();
        $user_group = Sub_group::where('admin_id', $user->id)->where('id', $student_group->sub_group_id)->first();
        $home_work = Home_work::where('level_id', $student->level_id)->first();

        $date = \Carbon\Carbon::parse($user_group->ban_to);
        $now = \Carbon\Carbon::now();
        if($user_group->ban_to > $now && $user_group->ban_from < $now)
        {
            $output = array("state"=>0, "message"=>MyHelper::ReturnMessageByLang("تم أيقاف الجروب", "The group was banned"));
            return response()->json($output);
        }
        $level = Level::where('id', $student->level_id)->first();

        if($user_group && $level)
        {
            if($home_work)
            {
                $user_read = new Users_homework();
                $user_read->status = $read_status;
                $user_read->user_id = $student_id;
                $user_read->group_id = $user_group->id;
                $user_read->home_work_id = $home_work->id;
                $user_read->save();

                if($read_status == "read")
                {
                    $title = MyHelper::ReturnValueByLang("منازل الابرار",'Mnazel Alabrar');
                    $notification_body = MyHelper::ReturnValueByLang("شكرا لك, لقد قرأت الايه الخاصة بك","Thank you, you have read your ayah");
                }
                else
                {
                    $title = MyHelper::ReturnValueByLang("منازل الابرار",'Mnazel Alabrar');
                    $notification_body = MyHelper::ReturnValueByLang("لم تقرأ الايه الخاصة بك, برجاء قرأة الواجب الخاص بك","You don't read your ayah yet, please complete your assignment");
                }

                $send_notification = MyHelper::SendNotification($title, $notification_body, $user_read->user_id);
                if($send_notification)
                {
                    $notification = new Notification();
                    $notification->title = $title;
                    $notification->notification = $notification_body;
                    $notification->user_id = $user_read->user_id;
                    $notification->save();
                }

                $output = array("state"=>1, "success"=>"done");
                return response()->json($output);
            }
            else
            {
                $ar_response = " لا يوجد ملف واجب للمستوي " . "(".$level->name.")";
                $en_response = "There is no assignment file for level ". "(".$level->en_name.")";
                $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang( $ar_response, $en_response ));
                return response()->json($output);
            }
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again"));
            return response()->json($output);
        }
    }

    public function get_reads()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        $user_group = null;

        if($user)
        {
            if($user->type == "teacher")
            {
                $user_group = Sub_group::where('admin_id', $user->id)->first();
            }
            else if($user->type == "student")
            {
                $user_group = Users_group::where('user_id', $user->id)->first();
            }

            if($user_group)
            {
                $now = \Carbon\Carbon::now();
                $one_month_ago = \Carbon\Carbon::now()->subMonth();
                $users_reads = null;

                if($user->type == "teacher")
                {
                    $users_reads = Users_homework::where('group_id', $user_group->id)->where('created_at', '<=', $now)->where('created_at', '>', $one_month_ago)->orderBy('id', 'desc')->get();
                }
                else if($user->type == "student")
                {
                    $users_reads = Users_homework::where('group_id', $user_group->sub_group_id)->where('created_at', '<=', $now)->where('created_at', '>', $one_month_ago)->orderBy('id', 'desc')->get();
                }

                foreach ($users_reads as $users_read)
                {
                    $username = User::select('username')->where('id', $users_read->user_id)->first();
                    $users_read->username = $username->username;
                }
            }
            else
            {
                $home_video = Setting::where('name', 'main_video')->first();

                $output = array("state"=>1, "success"=> [], "home_video" => $home_video);
                return response()->json($output);
                //$output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again"));
                //return response()->json($output);
            }

            $home_video = Setting::where('name', 'main_video')->first();

            $output = array("state"=>1, "success"=> $users_reads, "home_video" => $home_video);
            return response()->json($output);
        }
        else
        {
            $home_video = Setting::where('name', 'main_video')->first();

            $output = array("state"=>1, "success"=> [], "home_video" => $home_video);
            return response()->json($output);
        }

    }

    public function get_level()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        if(!$user->level_id)
        {
            $output = array("state"=>1, "success"=>MyHelper::ReturnMessageByLang("لم يتم تحديد المستوي بعد", "Level is not specified yet"));
            return response()->json($output);
        }

        $level = Level::where('id', $user->level_id)->first();
        $sub_level = Sub_level::where('id', $user->sub_level_id)->first();
        $output = array("state"=>1, "success"=> $level, "sub_level" => $sub_level);
        return response()->json($output);
    }

    public function get_about_us()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        $about_us = Setting::where('type', 'about_us')->first();

        if($about_us)
        {
            if($about_us->name &&file_exists($about_us->name))
            {
                $about_us->image = MyHelper::returnBase64Data($about_us->name);
            }
            else
            {
                $about_us->image = null;
            }


            $output = array("state"=>1, "success"=> $about_us);
            return response()->json($output);
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ, لا يوجد بيانات", "Error, There is no data"));
            return response()->json($output);
        }
    }

    public function get_terms_and_conditions()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        $terms_and_conditions = Setting::where('type', 'terms_and_conditions')->first();

        if($terms_and_conditions)
        {
            $output = array("state"=>1, "success"=> $terms_and_conditions);
            return response()->json($output);
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ, لا يوجد بيانات", "Error, There is no data"));
            return response()->json($output);
        }
    }

    public function support_message(Request $Request)
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();


        $rules = array(
            'name' => 'required',
            'phone_number' => 'required',
            'message' => 'required',

        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'name.required'=>'برجاء أدخال الاسم',
                'phone_number.required'=>'برجاء أدخال رقم الهاتف',
                'message.required'=>'برجاء أدخال المشكلة او الرسالة',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'username.required'=>'Please enter your name',
                'phone_number.required'=>'Please enter your phone number',
                'message.required'=>'Please enter the problem or message',
            );
        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }

        $support_message = new Support_message();
        $support_message->name = $Request->name;
        $support_message->phone_number = $Request->phone_number;
        $support_message->message = $Request->message;
        $support_message->type = "support";
        $support_message->user_id = $user ? $user->id : null;
        $support_message->save();

        $output = array("state"=>1, "success"=> MyHelper::ReturnMessageByLang("تم أرسال المشكلة او الرسالة بنجاح", "Your problem or message was sent successfully"));
        return response()->json($output);
    }

    public function contact_us_message(Request $Request)
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();


        $rules = array(
            'name' => 'required',
            'phone_number' => 'required',
            'message' => 'required',

        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'name.required'=>'برجاء أدخال الاسم',
                'phone_number.required'=>'برجاء أدخال رقم الهاتف',
                'message.required'=>'برجاء أدخال الرسالة',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'username.required'=>'Please enter your name',
                'phone_number.required'=>'Please enter your phone number',
                'message.required'=>'Please enter the message',
            );
        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }

        $support_message = new Support_message();
        $support_message->name = $Request->name;
        $support_message->phone_number = $Request->phone_number;
        $support_message->message = $Request->message;
        $support_message->type = "contact_us";
        $support_message->user_id = $user ? $user->id : null;
        $support_message->save();

        $output = array("state"=>1, "success"=> MyHelper::ReturnMessageByLang("تم أرسال الرسالة بنجاح", "Your message sent successfully"));
        return response()->json($output);
    }


    public function get_app_guide()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        $app_guides = App_guide::all();

        if($app_guides)
        {
            foreach ($app_guides as $app_guide)
            {
                if($app_guide->type == 'image')
                {
                    if($app_guide->image && file_exists($app_guide->image))
                    {
                        $app_guide->image = MyHelper::returnBase64Data($app_guide->image);
                    }
                    else
                    {
                        $app_guide->image = null;
                    }
                }
            }

            $output = array("state"=>1, "success"=> $app_guides);
            return response()->json($output);
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ, لا يوجد بيانات", "Error, There is no data"));
            return response()->json($output);
        }
    }

    public function get_notifications()
    {
        $now = \Carbon\Carbon::now();
        $one_month_ago = \Carbon\Carbon::now()->subMonth();

        app()->setLocale($_GET['lang']);

        $user = auth('api')->user();
        $type = null;

        if($user->type = 'student')
        {
            $type = 'students';
        }
        elseif ($user->type = 'teacher')
        {
            $type = 'teachers';
        }


        $notifications = Notification::where('user_id', $user->id)->orWhere('type', $type)->where('created_at', '<=', $now)->where('created_at', '>', $one_month_ago)->orderBy('id', 'desc')->get();

        if(count($notifications))
        {
            $output = array("state"=>1, "success"=> $notifications);
            return response()->json($output);
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لا يوجد تنبيهات", "There is no notifications"));
            return response()->json($output);
        }
    }

    public function get_sub_levels()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        if(!$user->level_id)
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لم يتم تحديد مستواك بعد", "The level has already been selected"));
            return response()->json($output);
        }
        if($user->sub_level_id)
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("تم تحديد المستوي من قبل", "Your level is not specified yet"));
            return response()->json($output);
        }
        $sub_levels = Sub_level::where('level_id', $user->level_id)->get();
        if(count($sub_levels))
        {
            $output = array("state"=>1, "success"=> $sub_levels);
            return response()->json($output);
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لا يوجد مستويات فرعية للمستوي الخاص بك", "There are no sub-levels for your level"));
            return response()->json($output);
        }
    }

    public function set_sub_level()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();
        $sub_level_id = intval($_GET['level_id']);
        $sub_level = Sub_level::where('id', $sub_level_id)->first();

        if(!$sub_level)
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("خطأ, لا يوجد بيانات", "Error, There is no data"));
            return response()->json($output);
        }
        if($user->sub_level_id)
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("تم تحديد المستوي من قبل", "Your level is not specified yet"));
            return response()->json($output);
        }

        $user->sub_level_id = $sub_level_id;
        $user->save();

        $output = array("state"=>1, "success"=> MyHelper::ReturnMessageByLang("تم تحديد المستوي بنجاح", "Successfully selected"));
        return response()->json($output);

    }

    public function register_push_token(Request $Request)
    {
        $user = auth('api')->user();
        $push_token = $Request->push_token;
        if ($push_token)
        {
            $user = User::where('id', $user->id)->first();
            $user->push_token = $push_token;
            $user->save();
        }
    }

    public function get_teacher()
    {
        app()->setLocale($_GET['lang']);
        $user = auth('api')->user();

        if(!$user->level_id)
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لم يتم تحديد المستوي بعد", "Your level is not specified yet"));
            return response()->json($output);
        }

        $user_group = Users_group::where('user_id', $user->id)->first();
        if(!empty($user_group))
        {
            $group = Sub_group::where('id', $user_group->sub_group_id)->first();

            if($group->admin_id)
            {
                $group_status = "working";

                $date = \Carbon\Carbon::parse($group->ban_to);
                $now = \Carbon\Carbon::now();
                if($group->ban_to > $now && $group->ban_from < $now)
                {
                    $group_status = "banned";
                }

                $teacher = User::where('id', $group->admin_id)->first();
                $response = ["teacher_name" => $teacher->username, "group" => $group->id, "group_name" => $group->name, "en_group_name" => $group->en_name, "group_status" => $group_status];
                $output = array("state"=>1, "success"=> $response);
                return response()->json($output);
            }
            else
            {
                $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لم يتم أضافة معلم الي جروب بعد", "No teacher has been added to your group yet"));
                return response()->json($output);
            }
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("لم يتم أضافة حسابك الي جروب بعد", "Your account has not been added to a group yet"));
            return response()->json($output);
        }
    }

    public function platform_data(Request $Request)
    {
        app()->setLocale($_GET['lang']);
        $platform = $Request->platform;

        if($platform != "ios" && $platform != "android")
        {
            $output = array("state"=>0, "error"=>"error");
            return response()->json($output);
        }

        if($platform)
        {
            $platform_setting = Setting::where('type', "platform_analytics")->where('name', $platform)->first();
            if(empty($platform_setting))
            {
                $platform_analytics = new Setting();
                $platform_analytics->name = $platform;
                $platform_analytics->type = "platform_analytics";
                $platform_analytics->setting = 1;
                $platform_analytics->setting2 = 1;
                $platform_analytics->save();
                $output = array("state"=>1, "success"=> "done");
                return response()->json($output);
            }
            else
            {
                $platform_setting->setting += 1;
                $platform_setting->save();
                $output = array("state"=>1, "success"=> "done");
                return response()->json($output);
            }

        }
        else
        {
            $output = array("state"=>0, "error"=>"error");
            return response()->json($output);
        }
    }

}
