<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Login_log;
use App\Test_audio;
use App\User;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\Validator;
use Response;
use JWTFactory;
use JWTAuth;

class AuthController extends Controller
{
    public function register_teacher(Request $Request)
    {
        $rules = array(
            'username' => 'required|string|max:25|unique:users',
            //'email' => 'required|string|max:25|unique:users',
            'password' => 'required|string|min:5',
            //'phoneNumber' => 'required',
            //'bDate' => 'required',
            'type' => 'required',
            'quranParts' => 'required',
            'availableTimes' => 'required',
            'workingHours' => 'required',
            'mastery_certificates' => 'required',
        );

        if(isset($Request->email))
        {
            $rules['email'] = 'string|max:25|unique:users';
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
                'mastery_certificates.required'=>'برجاء أدخال عدد شهادات الاتقان',
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
                'type.required'=>'خطأ برجاء إعادة المحاولة',
                'quranParts.required'=>'Please enter your Quran hifth parts',
                'availableTimes.required'=>'Please enter your available times',
                'workingHours.required'=>'Please enter your working hours',
                'mastery_certificates.required'=>'Please enter mastery certificates number',
            );
        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }

        $output = array("state"=>0);
        return response()->json($output);
    }

    public function complete_teacher_registration(Request $Request)
    {
        $rules = array(
            'username' => 'required|string|max:25|unique:users',
            //'email' => 'required|string|max:25|unique:users',
            'password' => 'required|string|min:5',
            //'phoneNumber' => 'required',
            //'bDate' => 'required',
            'type' => 'required',
            'quranParts' => 'required',
            'availableTimes' => 'required',
            'workingHours' => 'required',
            'mastery_certificates' => 'required',
            'file' => 'mimetypes:application/octet-stream,audio/mpeg,mpga,audio/x-m4a,m4a,audio/x-wav,wav,audio/ogg,ogg,audio/x-hx-aac-adts,audio/aac'
        );

        if(isset($Request->email))
        {
            $rules['email'] = 'string|max:25|unique:users';
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
                'file.mimetypes'=>'عفوا الملف الصوتي يجب ان يكون من نوع mp4,mp3,wav,ogg',
                'mastery_certificates.required'=>'برجاء أدخال عدد شهادات الاتقان',
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
                'file.mimetypes'=>'The audio file must be mp4,mp3,wav or ogg file',
                'mastery_certificates.required'=>'Please enter mastery certificates number',
            );
        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }


        $user = new User();
        $user->username = $Request->username;
        $user->email = $Request->email;
        $user->phone = $Request->phoneNumber;
        $user->birthday = $Request->bDate;
        $user->quran_parts = $Request->quranParts;
        $user->spare_time = $Request->availableTimes;
        $user->workـhours = $Request->workingHours;
        $user->country_id = $Request->country_id;
        $user->type = $Request->type;
        $user->password = Hash::make($Request->password);
        $user->mogazh = $Request->mogazh;
        $user->mastery_certificates = $Request->mastery_certificates;
        $user->save();

        if($Request->hasFile('file'))
        {
            $test_audio = new Test_audio();
            if ($Request->file('file')->isValid())
            {
                $path = $Request->file('file')->storeAs('records_files', $Request->file('file')->getClientOriginalName());
                if ($path)
                {
                    $test_audio->file_path = storage_path('app/'.$path) ;
                    $test_audio->file_name = $Request->file('file')->getClientOriginalName();
                    $test_audio->user_id = $user->id;
                    $test_audio->save();
                }
            }
        }

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
    }

    public function register_student(Request $Request)
    {
        Input::get();
        $rules = array(
            'username' => 'required|string|max:25|unique:users',
            //'email' => 'required|string|max:25|unique:users',
            'password' => 'required|string|min:5',
            //'phoneNumber' => 'required',
            //'bDate' => 'required',
            'type' => 'required',
            'quranParts' => 'required',
        );

        if(isset($Request->email))
        {
            $rules['email'] = 'string|max:25|unique:users';
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
                'type.required'=>'خطأ برجاء إعادة المحاولة',
                'quranParts.required'=>'Please enter your Quran hifth parts',
            );
        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }

        $output = array("state"=>0);
        return response()->json($output);
    }

    public function complete_student_registration(Request $Request)
    {
        $rules = array(
            'username' => 'required|string|max:25|unique:users',
            //'email' => 'required|string|max:25|unique:users',
            'password' => 'required|string|min:5',
            //'phoneNumber' => 'required',
            //'bDate' => 'required',
            'type' => 'required',
            'quranParts' => 'required',
            'file' => 'mimetypes:application/octet-stream,audio/mpeg,mpga,audio/x-m4a,m4a,audio/x-wav,wav,audio/ogg,ogg,audio/x-hx-aac-adts,audio/aac'
        );

        if(isset($Request->email))
        {
            $rules['email'] = 'string|max:25|unique:users';
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
                'file.mimetypes'=>'عفوا الملف الصوتي يجب ان يكون من نوع mp4,mp3,wav,ogg'
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
                'type.required'=>'خطأ برجاء إعادة المحاولة',
                'quranParts.required'=>'Please enter your Quran hifth parts',
                'file.mimetypes'=>'The audio file must be mp4,mp3,wav or ogg file',
            );
        }
        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }


        $user = new User();
        $user->username = $Request->username;
        $user->email = $Request->email;
        $user->phone = $Request->phoneNumber;
        $user->birthday = $Request->bDate;
        $user->quran_parts = $Request->quranParts;
        $user->type = $Request->type;
        $user->country_id = $Request->country_id;
        $user->password = Hash::make($Request->password);
        $user->save();

        if($Request->hasFile('file'))
        {
            $test_audio = new Test_audio();
            if ($Request->file('file')->isValid())
            {
                $path = $Request->file('file')->storeAs('ayah_test_records', $Request->file('file')->getClientOriginalName());
                if ($path)
                {
                    $test_audio->file_path = storage_path('app/'.$path) ;
                    $test_audio->file_name = $Request->file('file')->getClientOriginalName();
                    $test_audio->user_id = $user->id;
                    $test_audio->save();
                }
            }
        }

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
    }

    public function login(Request $Request)
    {
        $rules = array(
            'username' => 'required|string|max:25',
            'password' => 'required|string|min:5',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'username.required'=>'برجاء أدخال أسم المستخدم',
                'username.max'=>'أسم المستخدم يجب أن لا يزيد عن 25 حرف',
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

        $credentials = $Request->only('username', 'password');

        try
        {
            if (! $token = auth('api')->attempt($credentials))
            {
                $output = array("state"=>0, "error"=> MyHelper::ReturnMessageByLang("أسم المستخدم و كلمة المرور غير صحيحة", "Invalid username and password"));
                return response()->json($output);
            }
        }
        catch (JWTException $e)
        {
            $output = array("state"=>0, "error"=> MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "could not create token"));
            return response()->json($output);
        }
        $user = auth('api')->user();
        $logout_log = new Login_log();
        $logout_log->type = "login";
        $logout_log->user_id = $user->id;
        $logout_log->save();
        return $this->respondWithToken($token);
    }

    public function checkToken()
    {
        //$output = array("state"=>1);
        return response()->json(auth('api')->user());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = auth('api')->user();

        $logout_log = new Login_log();
        $logout_log->type = "logout";
        $logout_log->user_id = $user->id;
        $logout_log->save();

        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function forgot(Request $Request)
    {
        if(isset($_GET['lang']))
        {
            app()->setLocale($_GET['lang']);
        }

        $email = $Request->email;

        $rules = array('email' => 'required|email');

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'email.required'=>'برجاء أدخال البريد الإلكتروني',
                'email.email'=>'برجاء أدخال بريد الإلكتروني صحيح',);
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'email.required'=>'Please enter your email address',
                'email.email'=>'Please enter valid email address',
            );
        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return response()->json(array('error' => $FirstError));
        }

        $user = User::where('email', $email)->first();

        if($user)
        {
            DB::table(config('auth.passwords.users.table'))->where('email', $user->email)->delete();
            //$token = md5(str_random(32)).md5(str_random(32).now());
            $token = str_random(64);

            DB::table(config('auth.passwords.users.table'))->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => \Carbon\Carbon::now(),
            ]);
            $user->notify(new ResetPassword($token));
            $output = array("state"=>1, "error"=>MyHelper::ReturnMessageByLang("تم أرسال الرسالة بنجاح, رابط إعادة تعين كلمة المرور صالح لمدة ٢٤ ساعة", " Email sent successfully, The password reset link is valid for 24 hours"));
            return response()->json($output);
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("البريد الإلكتروني الذي أدخلته غير صحيح", " The email you entered is invalid"));
            return response()->json($output);
        }
    }

    public function check_reset(Request $Request)
    {
        if(isset($_GET['lang']))
        {
            app()->setLocale($_GET['lang']);
        }

        $token = $Request->token;
        if($token)
        {
            $now = \Carbon\Carbon::now();
            $one_day_ago = \Carbon\Carbon::now()->subDay();

            $user_reset = DB::table(config('auth.passwords.users.table'))->where('token', $token)->where('created_at', '<=', $now)->where('created_at', '>', $one_day_ago)->first();
            if(!empty($user_reset))
            {
                return response()->json(["state" => 1, "success"=> 'valid']);
            }
            else
            {
                $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("الرابط غير صحيح", "The link is invalid"));
                return response()->json($output);
            }
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("الرابط غير صحيح", "The link is invalid"));
            return response()->json($output);
        }
    }

    public function reset_password(Request $Request)
    {
        if(isset($_GET['lang']))
        {
            app()->setLocale($_GET['lang']);
        }

        $rules = array('password' => 'required|string|min:5',);

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'password.string'=>'كلمة المرور يجب انت تحتوي علي حروف',
                'password.min'=>'كلمة المرور يجب الا تقل عن 5 حروف',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
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

        $token = $Request->token;
        $password = $Request->password;

        if($token)
        {
            $now = \Carbon\Carbon::now();
            $one_day_ago = \Carbon\Carbon::now()->subDay();

            $user_reset = DB::table(config('auth.passwords.users.table'))->where('token', $token)->where('created_at', '<=', $now)->where('created_at', '>', $one_day_ago)->first();
            if(!empty($user_reset))
            {
                $user = User::where('email', $user_reset->email)->first();
                $user->password = $user->password = Hash::make($password);
                $user->save();

                DB::table(config('auth.passwords.users.table'))->where('email', $user->email)->delete();

                return response()->json(["state" => 1, "success"=> MyHelper::ReturnMessageByLang("تم إعادة تعين كلمة المرور بنجاح", "Your password has been reset successfully")]);
            }
            else
            {
                $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("الرابط غير صحيح", "The link is invalid"));
                return response()->json($output);
            }
        }
        else
        {
            $output = array("state"=>0, "error"=>MyHelper::ReturnMessageByLang("الرابط غير صحيح", "The link is invalid"));
            return response()->json($output);
        }
    }
}
