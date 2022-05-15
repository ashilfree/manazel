<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Helper\MyHelper;
use App\Home_work;
use App\Level;
use Illuminate\Http\Request;
use File;

class HomeworkController extends Controller
{
    public function add_homework()
    {
        $levels = Level::all();
        return view('/homework/add_homework', ['levels' => $levels]);
    }

    public function all_homework()
    {
        $homeworks = Home_work::orderBy('id', 'DESC')->paginate(20);
        return view('/homework/all_homework', [ 'homeworks' => $homeworks ]);
    }

    public function modify_homework($id)
    {
        $homework = Home_work::where('id', $id)->firstOrFail();
        $levels = Level::all();
        return view('/homework/modify_homework', [ 'homework' => $homework, 'levels' => $levels ]);
    }

    public function set_homework(Request $Request)
    {
        $level_id = $Request->level;
        $homework_file = $Request->homework_file;

        $level = Level::where('id', $Request->level)->first();

        if(empty($level))
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار المستوي", "Please select the level");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }

        if ($level_id && $homework_file)
        {
            if ($Request->hasFile('homework_file'))
            {

                $rules = array(
                    'level' => 'required',
                    'homework_file' => 'mimes:pdf',
                );

                if(app()->getLocale() == 'ar')
                {
                    $messages = array(
                        'level.required'=>'برجاء أختيار المستوي',
                        'homework_file.mimes'=>'عفوا ملف الواجب يجب ان يكون من نوع PDF'
                    );
                }
                elseif (app()->getLocale() == 'en')
                {
                    $messages = array(
                        'level.required'=>'Please select the level',
                        'homework_file.mimes'=>'The homework file must be PDF file',
                    );

                }

                $validator = Validator::make($Request->all(), $rules,$messages);
                if($validator->fails())
                {
                    $FirstError =$validator->errors()->first();
                    return Redirect::back()->withErrors(array('error' => $FirstError));

                }

                if ($Request->file('homework_file')->isValid())
                {
                    $file_name = md5(uniqid(time())) . '.' . $Request->file('homework_file')->getClientOriginalExtension();
                    $path = base_path() . "/resources/homework_files/";


                    $file_url = url('homework_files/'.$file_name, $parameters = [], $secure = null);

                    if($homework_file->move($path, $file_name))
                    {
                        $homework = new Home_work();
                        $homework->file_path = $path.$file_name;
                        $homework->file_url = $file_url;
                        $homework->file_name = $file_name;
                        $homework->tajweed_link = $Request->tajweed_link;
                        $homework->tafsir_link = $Request->tafsir_link;
                        $homework->level_id = $level_id;
                        $homework->save();

                        $redirct_message = MyHelper::ReturnMessageByLang("تم أصافة الملف بنجاح", "File successfully added");
                        return Redirect::back()->withErrors(array('success' => $redirct_message));
                    }
                }
            }
            else
            {
                $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار ملف الواجب", "Please select the homework file");
                return Redirect::back()->withErrors(array('error' => $redirct_message));
            }
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أدخال جميع البيانات", "Please enter all data");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

    public function update_homework_data(Request $Request)
    {
        $homework_id = $Request->homework_id;
        $level_id = $Request->level;
        $homework_file = $Request->homework_file;

        $homework = Home_work::where('id', $homework_id)->firstOrFail();

        $level = Level::where('id', $Request->level)->first();

        if(empty($level))
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار المستوي", "Please select the level");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
        if ($Request->hasFile('homework_file'))
        {
            $rules = array(
                'level' => 'required',
                'homework_file' => 'mimes:pdf',
            );

            if(app()->getLocale() == 'ar')
            {
                $messages = array(
                    'level.required'=>'برجاء أختيار المستوي',
                    'homework_file.mimes'=>'عفوا ملف الواجب يجب ان يكون من نوع PDF'
                );
            }
            elseif (app()->getLocale() == 'en')
            {
                $messages = array(
                    'level.required'=>'Please select the level',
                    'homework_file.mimes'=>'The homework file must be PDF file',
                );

            }

            $validator = Validator::make($Request->all(), $rules,$messages);
            if($validator->fails())
            {
                $FirstError =$validator->errors()->first();
                return Redirect::back()->withErrors(array('error' => $FirstError));

            }

            if ($Request->file('homework_file')->isValid())
            {
                $file_name = md5(uniqid(time())) . '.' . $Request->file('homework_file')->getClientOriginalExtension();
                $path = base_path() . "/resources/homework_files/";


                $file_url = url('homework_files/'.$file_name, $parameters = [], $secure = null);

                if($homework_file->move($path, $file_name))
                {
                    File::delete($homework->file_path);

                    $homework->file_path = $path.$file_name;
                    $homework->file_url = $file_url;
                    $homework->file_name = $file_name;
                    $homework->tajweed_link = $Request->tajweed_link;
                    $homework->tafsir_link = $Request->tafsir_link;
                    $homework->level_id = $level_id;
                    $homework->save();

                    $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل الواجب بنجاح", "Homework successfully modified");
                    return Redirect::back()->withErrors(array('success' => $redirct_message));
                }
            }
        }
        else
        {
            $homework->level_id = $level_id;
            $homework->tajweed_link = $Request->tajweed_link;
            $homework->tafsir_link = $Request->tafsir_link;
            $homework->save();

            $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل الواجب بنجاح", "Homework successfully modified");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
    }

    public function delete_homework(Request $request)
    {
        $homework_id = $request->homework_id;

        $homework = Home_work::where('id', $homework_id)->firstOrFail();

        //$slide_path = base_path() . "/resources/assets/images/slider_images/" . $slide->image_name;

        File::delete($homework->file_path);

        if($homework->delete())
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف الواجب بنجاح", "Homework successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));

        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

}
