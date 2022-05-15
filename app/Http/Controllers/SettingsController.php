<?php

namespace App\Http\Controllers;

use App\App_guide;
use App\Helper\MyHelper;
use App\Login_log;
use App\Setting;
use App\Support_message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use View;
use File;
use Image;

class SettingsController extends Controller
{
    public function ayat_test()
    {
        $ayat_test = Setting::where('type', 'test_ayat')->get();
        return view('/settings/ayat_test', [ 'ayat_test' => $ayat_test ]);
    }

    public function app_guide()
    {
        $app_guides = App_guide::all();
        return view('/settings/app_guide', [ 'app_guides' => $app_guides ]);
    }


    public function modify_ayah($id)
    {
        $ayah = Setting::where('id', $id)->firstOrFail();

        return view('/settings/modify_ayah', [ 'ayah' => $ayah, ]);
    }

    public function modify_app_guid($id)
    {
        $app_guide = App_guide::where('id', $id)->firstOrFail();

        return view('/settings/modify_app_guide', [ 'app_guide' => $app_guide, ]);
    }

    public function about_us()
    {
        $about_us = Setting::where('type', 'about_us')->orderBy('id', 'desc')->first();

        return view('/settings/about_us', [ 'about_us' => $about_us, ]);
    }

    public function contact_us()
    {
        $contact_us_messages = Support_message::where('type', 'contact_us')->orderBy('id', 'desc')->paginate(15);

        return view('/settings/contact_us_messages', [ 'contact_us_messages' => $contact_us_messages, ]);
    }

    public function support()
    {
        $support_messages = Support_message::where('type', 'support')->orderBy('id', 'desc')->paginate(15);

        return view('/settings/support_messages', [ 'support_messages' => $support_messages, ]);
    }

    public function terms_conditions()
    {
        $terms_conditions = Setting::where('type', 'terms_and_conditions')->orderBy('id', 'desc')->first();

        return view('/settings/terms_conditions', [ 'terms_conditions' => $terms_conditions, ]);
    }

    public function main_video()
    {
        $main_video = Setting::where('name', 'main_video')->orderBy('id', 'desc')->first();

        return view('/settings/main_video', [ 'main_video' => $main_video, ]);
    }

    public function app_login_logs()
    {
        $login_logs = Login_log::orderBy('id', 'desc')->paginate(30);
        return view('/settings/app_login_logs', ['login_logs' => $login_logs]);
    }

    public function set_main_video(Request $Request)
    {
        $video_id = $Request->video_id;
        $video = null;

        if($video_id)
        {
            $video = Setting::where('id', $video_id)->firstOrFail();
        }
        else
        {
            $video = new Setting();
        }

        if(isset($Request->videos_link) && !isset($Request->videos_file))
        {
            $last_link = null;
            $link_type = null;
            $youtube_id = MyHelper::GetYoutubeVideoId($Request->videos_link);
            if ($youtube_id)
            {
                $last_link = 'https://www.youtube.com/embed/' . $youtube_id;
                $link_type = "youtube";
            }
            else
            {
                $last_link = $Request->videos_link;
                $link_type = "video";
            }

            if($video && $video->type == "video")
            {
                $d_file_name = MyHelper::getFileNameFromUrl($video->setting);
                $delete_path = base_path() . "/resources/home_video/".$d_file_name;
                File::delete($delete_path);
            }

            $video->name = 'main_video';
            $video->setting = $last_link;
            $video->type = $link_type;
            $video->save();

            $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة فيديو الصفحة الرئيسية بنجاح", "Home page video added successfully");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
        elseif (isset($Request->videos_file))
        {
            //\Log::info($Request->videos_file->getMimeType());
            $rules = array(
                'videos_file' => 'mimetypes:application/octet-stream,video/mp4,application/mp4,mp4,application/ogg,video/ogg,video/webm,webm',
            );

            if(app()->getLocale() == 'ar')
            {
                $messages = array(
                    'videos_file.mimetypes'=>'عفوا ملف الفيديو يجب ان يكون من نوع mp4,ogg,webm'
                );
            }
            elseif (app()->getLocale() == 'en')
            {
                $messages = array(
                    'videos_file.mimetypes'=>'The video file must be mp4,mp3,wav or ogg',
                );

            }

            $validator = Validator::make($Request->all(), $rules,$messages);
            if($validator->fails())
            {
                $FirstError =$validator->errors()->first();
                return Redirect::back()->withErrors(array('error' => $FirstError));
            }

            if ($Request->file('videos_file')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('videos_file')->getClientOriginalExtension();
                $path = base_path() . "/resources/home_video/";


                $file_url = url('home_video/'.$file_name, $parameters = [], $secure = null);

                if($Request->videos_file->move($path, $file_name))
                {
                    if($video && $video->type == "video")
                    {
                        $d_file_name = MyHelper::getFileNameFromUrl($video->setting);
                        $delete_path = base_path() . "/resources/home_video/".$d_file_name;
                        File::delete($delete_path);
                    }

                    $video->name = 'main_video';
                    $video->setting = $file_url;
                    $video->type = 'video';
                    $video->save();
                }
                $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة فيديو الصفحة الرئيسية بنجاح", "Home page video added successfully");
                return Redirect::back()->withErrors(array('success' => $redirct_message));
            }
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار الملف", "Please select the file");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function set_terms_conditions(Request $Request)
    {
        $rules = array(
            'ar_terms_conditions' => 'required',
            'en_terms_conditions' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ar_terms_conditions.required'=>'برجاء أدخال الشروط والاحكام بالغة العربية',
                'en_terms_conditions.required'=>'برجاء أدخال الشروط والاحكام بالغة الانجليزية',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ar_terms_conditions.required'=>'Please enter terms and conditions in arabic',
                'en_terms_conditions.required'=>'Please enter terms and conditions in english',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('ar_terms_conditions', 'en_terms_conditions');
            return Redirect::back()->withErrors(array('error' => $FirstError));
        }

        if(isset($Request->terms_conditions_id) && $Request->terms_conditions_id)
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل الشروط والاحكام بنجاح", "Terms and conditions successfully modified");
            $terms_and_conditions = Setting::where('id', $Request->terms_conditions_id)->firstOrFail();
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة الشروط والاحكام بنجاح", "Terms and conditions successfully Added");
            $terms_and_conditions = new Setting();
            $terms_and_conditions->name = "terms_and_conditions";
            $terms_and_conditions->type = "terms_and_conditions";
        }

        $terms_and_conditions->setting = $Request->ar_terms_conditions;
        $terms_and_conditions->setting2 = $Request->en_terms_conditions;
        $terms_and_conditions->save();

        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function set_about_us(Request $Request)
    {
        $image = $Request->image;

        if ($Request->hasFile('image'))
        {
            $rules = array(
                'image' => 'mimetypes:image/png,image/jpeg,image/gif',
                'about_usـdata' => 'required',
                'en_about_usـdata' => 'required',
            );

            if(app()->getLocale() == 'ar')
            {
                $messages = array(
                    'about_usـdata.required'=>'برجاء أدخال بيانات عنا بالغة العربية',
                    'en_about_usـdata.required'=>'برجاء أدخال بيانات عنا بالغة الانجليزية',
                    'image.mimetypes'=>'عفوا ملف الصورة يجب ان يكون من نوع jpg, gif, jpeg, png'
                );
            }
            elseif (app()->getLocale() == 'en')
            {
                $messages = array(
                    'about_usـdata.required'=>'Please enter about us data in arabic',
                    'en_about_usـdata.required'=>'Please enter about us data in english',
                    'image.mimetypes'=>'The image file must be png, jpeg, gif or jpg'
                );

            }

            $validator = Validator::make($Request->all(), $rules,$messages);
            if($validator->fails())
            {
                $FirstError =$validator->errors()->first();
                $Request->flashOnly('about_usـdata', 'en_about_usـdata');
                return Redirect::back()->withErrors(array('error' => $FirstError));
            }

            if ($Request->file('image')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('image')->getClientOriginalExtension();
                //$path = base_path() . "/resources/images/";

                $crop_data = explode(",",$Request->image_data);
                $path = storage_path('app/settings_files/'. $file_name);
                Image::make($Request->file('image'))->crop(
                    intval($crop_data[2]),
                    intval($crop_data[3]),
                    intval($crop_data[0]),
                    intval($crop_data[1])
                )->save($path);

                $about_us = new Setting();
                $about_us->name = $path;
                $about_us->type = "about_us";
                $about_us->setting = $Request->about_usـdata;
                $about_us->setting2 = $Request->en_about_usـdata;
                $about_us->save();

                $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة معلومات عنا بنجاح", "About us successfully Added");
                return Redirect::back()->withErrors(array('success' => $redirct_message));

            }
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار الملف", "Please select the file");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function set_about_us_update(Request $Request)
    {
        $about_us_id = $Request->about_us_id;
        $about_us = Setting::where('id', $about_us_id)->firstOrFail();

        $rules = array(
            'about_usـdata' => 'required',
            'en_about_usـdata' => 'required',
        );

        if ($Request->hasFile('image'))
        {
            $rules['image'] = 'mimetypes:image/png,image/jpeg,image/gif';
        }

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'about_usـdata.required'=>'برجاء أدخال بيانات عنا بالغة العربية',
                'en_about_usـdata.required'=>'برجاء أدخال بيانات عنا بالغة الانجليزية',
                'image.mimetypes'=>'عفوا ملف الصورة يجب ان يكون من نوع jpg, gif, jpeg, png'
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'about_usـdata.required'=>'Please enter about us data in arabic',
                'en_about_usـdata.required'=>'Please enter about us data in english',
                'image.mimetypes'=>'The image file must be png, jpeg, gif or jpg'
            );

        }

        $validator = Validator::make($Request->all(), $rules, $messages);
        if ($validator->fails())
        {
            $FirstError = $validator->errors()->first();
            return Redirect::back()->withErrors(array('error' => $FirstError));
        }

        if ($Request->hasFile('image'))
        {
            if ($Request->file('image')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('image')->getClientOriginalExtension();

                $crop_data = explode(",",$Request->image_data);
                $path = storage_path('app/settings_files/'. $file_name);
                Image::make($Request->file('image'))->crop(
                    intval($crop_data[2]),
                    intval($crop_data[3]),
                    intval($crop_data[0]),
                    intval($crop_data[1])
                )->save($path);

                File::delete($about_us->name);

                $about_us->name = $path;
                $about_us->setting = $Request->about_usـdata;
                $about_us->setting2 = $Request->en_about_usـdata;
                $about_us->save();

                $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل معلومات عنا بنجاح", "About us data successfully modified");
                return Redirect::back()->withErrors(array('success' => $redirct_message));

            }
        }
        else
        {
            $about_us->setting = $Request->about_usـdata;
            $about_us->setting2 = $Request->en_about_usـdata;
            $about_us->save();

            $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل معلومات عنا بنجاح", "About us data successfully modified");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }

    }

    public function set_app_guide(Request $Request)
    {
        $image = $Request->image;

        if ($Request->hasFile('image'))
        {
            $rules = array(
                'image' => 'mimetypes:image/png,image/jpeg,image/gif',
                'title' => 'required',
                'en_title' => 'required',
                'description' => 'required',
                'en_description' => 'required',
            );

            if(app()->getLocale() == 'ar')
            {
                $messages = array(
                    'title.required'=>'برجاء أدخال العنوان بالغة العربية',
                    'en_title.required'=>'برجاء أدخال العنوان بالغة الانجليزية',
                    'description.required'=>'برجاء أدخال الوصف بالغة العربية',
                    'en_description.required'=>'برجاء أدخال الوصف بالغة الانجليزية',
                    'image.mimetypes'=>'عفوا ملف الصورة يجب ان يكون من نوع jpg, gif, jpeg, png'
                );
            }
            elseif (app()->getLocale() == 'en')
            {
                $messages = array(
                    'title.required'=>'Please enter title in arabic',
                    'en_title.required'=>'Please enter title in english',
                    'description.required'=>'Please enter description in arabic',
                    'en_description.required'=>'Please enter description in english',
                    'image.mimetypes'=>'The image file must be png, jpeg, gif or jpg'
                );

            }

            $validator = Validator::make($Request->all(), $rules,$messages);
            if($validator->fails())
            {
                $FirstError =$validator->errors()->first();
                $Request->flashOnly('ayah_name', 'en_ayah_name');
                return Redirect::back()->withErrors(array('error' => $FirstError));
            }

            if ($Request->file('image')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('image')->getClientOriginalExtension();
                //$path = base_path() . "/resources/images/";

                $crop_data = explode(",",$Request->image_data);
                $path = base_path() . "/resources/images/" . $file_name;
                Image::make($Request->file('image'))->crop(
                    intval($crop_data[2]),
                    intval($crop_data[3]),
                    intval($crop_data[0]),
                    intval($crop_data[1])
                )->save($path);

                $app_guide = new App_guide();
                $app_guide->title = $Request->title;
                $app_guide->en_title = $Request->en_title;
                $app_guide->description = $Request->description;
                $app_guide->en_description = $Request->en_description;
                $app_guide->image = $path;
                $app_guide->type = 'image';
                $app_guide->save();

                $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة صفحة الي دليل التطبيق بنجاح", "Page added to app guide successfully");
                return Redirect::back()->withErrors(array('success' => $redirct_message));

            }
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار الملف", "Please select the file");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function set_app_guide_video(Request $Request)
    {
        $rules = array(
            'title' => 'required',
            'en_title' => 'required',
            'description' => 'required',
            'en_description' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'title.required'=>'برجاء أدخال العنوان بالغة العربية',
                'en_title.required'=>'برجاء أدخال العنوان بالغة الانجليزية',
                'description.required'=>'برجاء أدخال الوصف بالغة العربية',
                'en_description.required'=>'برجاء أدخال الوصف بالغة الانجليزية',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'title.required'=>'Please enter title in arabic',
                'en_title.required'=>'Please enter title in english',
                'description.required'=>'Please enter description in arabic',
                'en_description.required'=>'Please enter description in english',
                'image.mimetypes'=>'The image file must be png, jpeg, gif or jpg'
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('title', 'en_title', 'description', 'en_description');
            return Redirect::back()->withErrors(array('error' => $FirstError));
        }

        if(isset($Request->videos_link))
        {

            $last_link = null;
            $link_type = null;
            $youtube_id = MyHelper::GetYoutubeVideoId($Request->videos_link);
            if ($youtube_id)
            {
                $last_link = 'https://www.youtube.com/embed/' . $youtube_id;
                $link_type = "youtube";
            }
            else
            {
                $last_link = $Request->videos_link;
                $link_type = "video";
            }

            $app_guide = new App_guide();
            $app_guide->title = $Request->title;
            $app_guide->en_title = $Request->en_title;
            $app_guide->description = $Request->description;
            $app_guide->en_description = $Request->en_description;
            $app_guide->image = $last_link;
            $app_guide->type = $link_type;
            $app_guide->save();
            $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة صفحة الي دليل التطبيق بنجاح", "Page added to app guide successfully");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
        elseif (isset($Request->videos_file))
        {
            \Log::info($Request->videos_file->getMimeType());
            $rules = array(
                'videos_file' => 'mimetypes:application/octet-stream,video/mp4,application/mp4,mp4,application/ogg,video/ogg,video/webm,webm',
            );

            if(app()->getLocale() == 'ar')
            {
                $messages = array(
                    'videos_file.mimetypes'=>'عفوا ملف الفيديو يجب ان يكون من نوع mp4,ogg,webm'
                );
            }
            elseif (app()->getLocale() == 'en')
            {
                $messages = array(
                    'videos_file.mimetypes'=>'The video file must be mp4,mp3,wav or ogg',
                );

            }

            $validator = Validator::make($Request->all(), $rules,$messages);
            if($validator->fails())
            {
                $FirstError =$validator->errors()->first();
                return Redirect::back()->withErrors(array('error' => $FirstError));
            }

            if ($Request->file('videos_file')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('videos_file')->getClientOriginalExtension();
                $path = base_path() . "/resources/app_guide_videos/";


                $file_url = url('app_guide_videos/'.$file_name, $parameters = [], $secure = null);

                if($Request->videos_file->move($path, $file_name))
                {
                    $app_guide = new App_guide();
                    $app_guide->title = $Request->title;
                    $app_guide->en_title = $Request->en_title;
                    $app_guide->description = $Request->description;
                    $app_guide->en_description = $Request->en_description;
                    $app_guide->image = $file_url;
                    $app_guide->type = 'video';
                    $app_guide->save();
                }
                $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة الفيديو الي دليل التطبيق بنجاح", "Video added to app guide successfully");
                return Redirect::back()->withErrors(array('success' => $redirct_message));
            }
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار الملف", "Please select the file");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function update_app_guide_video(Request $Request)
    {
        $app_guide_id = $Request->app_guide_id;
        $app_guide = App_guide::where('id', $app_guide_id)->firstOrFail();
        if(isset($Request->videos_link) && !isset($Request->videos_file))
        {
            $last_link = null;
            $link_type = null;
            $youtube_id = MyHelper::GetYoutubeVideoId($Request->videos_link);
            if ($youtube_id)
            {
                $last_link = 'https://www.youtube.com/embed/' . $youtube_id;
                $link_type = "youtube";
            }
            else
            {
                $last_link = $Request->videos_link;
                $link_type = "video";
            }

            if($app_guide->type == "video")
            {
                $d_file_name = MyHelper::getFileNameFromUrl($app_guide->image);
                $delete_path = base_path() . "/resources/app_guide_videos/".$d_file_name;
                File::delete($delete_path);
            }

            $app_guide->image = $last_link;
            $app_guide->type = $link_type;
            $app_guide->save();
            $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل فيديو دليل التطبيق بنجاح", "App guide video changed successfully");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
        elseif (isset($Request->videos_file))
        {
            //\Log::info($Request->videos_file->getMimeType());
            $rules = array(
                'videos_file' => 'mimetypes:application/octet-stream,video/mp4,application/mp4,mp4,application/ogg,video/ogg,video/webm,webm',
            );

            if(app()->getLocale() == 'ar')
            {
                $messages = array(
                    'videos_file.mimetypes'=>'عفوا ملف الفيديو يجب ان يكون من نوع mp4,ogg,webm'
                );
            }
            elseif (app()->getLocale() == 'en')
            {
                $messages = array(
                    'videos_file.mimetypes'=>'The video file must be mp4,mp3,wav or ogg',
                );

            }

            $validator = Validator::make($Request->all(), $rules,$messages);
            if($validator->fails())
            {
                $FirstError =$validator->errors()->first();
                return Redirect::back()->withErrors(array('error' => $FirstError));
            }

            if ($Request->file('videos_file')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('videos_file')->getClientOriginalExtension();
                $path = base_path() . "/resources/app_guide_videos/";


                $file_url = url('app_guide_videos/'.$file_name, $parameters = [], $secure = null);

                if($Request->videos_file->move($path, $file_name))
                {

                    if($app_guide->type == "video")
                    {
                        $d_file_name = MyHelper::getFileNameFromUrl($app_guide->image);
                        $delete_path = base_path() . "/resources/app_guide_videos/".$d_file_name;
                        File::delete($delete_path);
                    }
                    $app_guide->image = $file_url;
                    $app_guide->type = 'video';
                    $app_guide->save();
                }
                $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل فيديو دليل التطبيق بنجاح", "App guide video changed successfully");
                return Redirect::back()->withErrors(array('success' => $redirct_message));
            }
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار الملف", "Please select the file");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function update_app_guide(Request $Request)
    {
        $app_guide_id = $Request->app_guide_id;
        $app_guide = App_guide::where('id', $app_guide_id)->firstOrFail();

        $rules = array(
            'title' => 'required',
            'en_title' => 'required',
            'description' => 'required',
            'en_description' => 'required',
        );

        if ($Request->hasFile('image'))
        {
            $rules['image'] = 'mimetypes:image/png,image/jpeg,image/gif';
        }

        if (app()->getLocale() == 'ar')
        {
            $messages = array(
                'title.required' => 'برجاء أدخال العنوان بالغة العربية',
                'en_title.required' => 'برجاء أدخال العنوان بالغة الانجليزية',
                'description.required' => 'برجاء أدخال الوصف بالغة العربية',
                'en_description.required' => 'برجاء أدخال الوصف بالغة الانجليزية',
                'image.mimetypes' => 'عفوا ملف الصورة يجب ان يكون من نوع jpg, gif, jpeg, png'
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'title.required' => 'Please enter title in arabic',
                'en_title.required' => 'Please enter title in english',
                'description.required' => 'Please enter description in arabic',
                'en_description.required' => 'Please enter description in english',
                'image.mimetypes' => 'The image file must be png, jpeg, gif or jpg'
            );

        }

        $validator = Validator::make($Request->all(), $rules, $messages);
        if ($validator->fails())
        {
            $FirstError = $validator->errors()->first();
            return Redirect::back()->withErrors(array('error' => $FirstError));
        }

        if ($Request->hasFile('image'))
        {
            if ($Request->file('image')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('image')->getClientOriginalExtension();

                $crop_data = explode(",", $Request->image_data);
                $path = base_path() . "/resources/images/" . $file_name;
                Image::make($Request->file('image'))->crop(
                    intval($crop_data[2]),
                    intval($crop_data[3]),
                    intval($crop_data[0]),
                    intval($crop_data[1])
                )->save($path);

                File::delete($app_guide->image);

                $app_guide->title = $Request->title;
                $app_guide->en_title = $Request->en_title;
                $app_guide->description = $Request->description;
                $app_guide->en_description = $Request->en_description;
                $app_guide->image = $path;
                $app_guide->save();

                $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل صفحة دليل التطبيق بنجاح", "App guide Page successfully modified");
                return Redirect::back()->withErrors(array('success' => $redirct_message));

            }
        }
        else
        {

            $app_guide->title = $Request->title;
            $app_guide->en_title = $Request->en_title;
            $app_guide->description = $Request->description;
            $app_guide->en_description = $Request->en_description;
            $app_guide->save();

            $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل صفحة التطبيق بنجاح", "App guide Page successfully modified");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }

    }


    public function set_ayat_test(Request $Request)
    {
        $ayah_file = $Request->ayah_file;

        if ($Request->hasFile('ayah_file'))
        {
            $rules = array(
                'ayah_file' => 'mimetypes:application/octet-stream,audio/mpeg,mpga,audio/mp4,mp4,audio/x-wav,wav,audio/ogg,ogg',
                'ayah_name' => 'required',
                'en_ayah_name' => 'required',
            );

            if(app()->getLocale() == 'ar')
            {
                $messages = array(
                    'ayah_name.required'=>'برجاء أدخال اسم او رقم الايه بالغة العربية',
                    'en_ayah_name.required'=>'برجاء أدخال اسم او رقم الايه بالغة الانجليزية',
                    'ayah_file.mimetypes'=>'عفوا الملف الصوتي يجب ان يكون من نوع mp4,mp3,wav,ogg'
                );
            }
            elseif (app()->getLocale() == 'en')
            {
                $messages = array(
                    'ayah_name.required'=>'Please enter ayah number or name in arabic',
                    'en_ayah_name.required'=>'Please enter ayah number or name in english',
                    'ayah_file.mimetypes'=>'The audio file must be mp4,mp3,wav or ogg file',
                );

            }

            $validator = Validator::make($Request->all(), $rules,$messages);
            if($validator->fails())
            {
                $FirstError =$validator->errors()->first();
                $Request->flashOnly('ayah_name', 'en_ayah_name');
                return Redirect::back()->withErrors(array('error' => $FirstError));
            }

            if ($Request->file('ayah_file')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('ayah_file')->getClientOriginalExtension();
                $path = base_path() . "/resources/test_ayat/";


                $file_url = url('test_ayat/'.$file_name, $parameters = [], $secure = null);

                if($ayah_file->move($path, $file_name))
                {
                    $ayah_test = new Setting();
                    $ayah_test->name = $Request->ayah_name;
                    $ayah_test->type = "test_ayat";
                    $ayah_test->setting = $Request->en_ayah_name;
                    $ayah_test->setting2 = $file_url;
                    $ayah_test->save();

                    $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة الملف بنجاح", "File successfully added");
                    return Redirect::back()->withErrors(array('success' => $redirct_message));
                }
            }
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار الملف", "Please select the file");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function set_ayat_update(Request $Request)
    {
        $ayah_id = $Request->ayah_id;
        $ayah = Setting::where('id', $ayah_id)->firstOrFail();


        $rules = array(
            'ayah_name' => 'required',
            'en_ayah_name' => 'required',
        );

        if ($Request->hasFile('ayah_file'))
        {
            $rules['ayah_file'] = 'mimetypes:application/octet-stream,audio/mpeg,mpga,audio/mp4,mp4,audio/x-wav,wav,audio/ogg,ogg';
        }
        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ayah_name.required'=>'برجاء أدخال اسم او رقم الايه بالغة العربية',
                'en_ayah_name.required'=>'برجاء أدخال اسم او رقم الايه بالغة الانجليزية',
                'ayah_file.mimetypes'=>'عفوا الملف الصوتي يجب ان يكون من نوع mp4,mp3,wav,ogg'
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ayah_name.required'=>'Please enter ayah number or name in arabic',
                'en_ayah_name.required'=>'Please enter ayah number or name in english',
                'ayah_file.mimetypes'=>'The audio file must be mp4,mp3,wav or ogg file',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('ayah_name', 'en_ayah_name');
            return Redirect::back()->withErrors(array('error' => $FirstError));
        }

        if ($Request->hasFile('ayah_file'))
        {
            $ayah_file = $Request->ayah_file;

            if ($Request->file('ayah_file')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('ayah_file')->getClientOriginalExtension();
                $path = base_path() . "/resources/test_ayat/";


                $file_url = url('test_ayat/'.$file_name, $parameters = [], $secure = null);

                if($ayah_file->move($path, $file_name))
                {
                    $url_parts = parse_url($ayah->setting2);
                    $filename = basename($url_parts["path"]);
                    $delete_path = base_path() . "/resources/test_ayat/".$filename;

                    File::delete($delete_path);

                    $ayah->name = $Request->ayah_name;
                    $ayah->setting = $Request->en_ayah_name;
                    $ayah->setting2 = $file_url;
                    $ayah->save();

                    $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل بيانات الايه بنجاح", "Ayah data successfully modified");
                    return Redirect::back()->withErrors(array('success' => $redirct_message));
                }
            }
        }
        else
        {
            $ayah->name = $Request->ayah_name;
            $ayah->setting = $Request->en_ayah_name;
            $ayah->save();

            $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل بيانات الايه بنجاح", "Ayah data successfully modified");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
    }


    public function delete_ayat_test(Request $request)
    {
        $ayah_id = $request->ayah_id;

        $ayah = Setting::where('id', $ayah_id)->firstOrFail();

        $file_path = base_path() . "/resources/test_ayat/" . $ayah->setting;

        File::delete($file_path);

        if($ayah->delete())
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف الملف بنجاح", "File successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));

        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function delete_app_guid(Request $request)
    {
        $app_guide_id = $request->app_guid_id;

        $app_guide = App_guide::where('id', $app_guide_id)->firstOrFail();

        if($app_guide->type == "video")
        {
            $d_file_name = MyHelper::getFileNameFromUrl($app_guide->image);
            $delete_path = base_path() . "/resources/app_guide_videos/".$d_file_name;
            File::delete($delete_path);
        }
        else
        {
            $file_path = base_path() . "/resources/images/" . $app_guide->image;
            File::delete($file_path);
        }

        if($app_guide->delete())
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف الصفحة بنجاح", "Page successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));

        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function delete_contact_us(Request $request)
    {
        $contact_us_id = $request->contact_us_id;

        $contact_us = Setting::where('id', $contact_us_id)->firstOrFail();

        if($contact_us->delete())
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف الرسالة بنجاح", "Message successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));

        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function delete_support(Request $request)
    {
        $support_id = $request->support_id;

        $support = Setting::where('id', $support_id)->firstOrFail();

        if($support->delete())
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف الرسالة بنجاح", "Message successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));

        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

}
