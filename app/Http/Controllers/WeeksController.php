<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Helper\MyHelper;
use App\Sub_level;
use App\Week;
use Illuminate\Http\Request;
use File;

class WeeksController extends Controller
{
    public function add_week()
    {
        $levels = Sub_level::all();
        return view('/weeks/add_week', ['levels' => $levels]);
    }

    public function modify_week($id)
    {
        $week = Week::where('id', $id)->firstOrFail();
        $levels = Sub_level::all();
        return view('/weeks/modify_week', [ 'week' => $week, 'levels' => $levels ]);
    }

    public function all_weeks()
    {
        $weeks = Week::orderBy('id', 'DESC')->paginate(20);
        return view('/weeks/all_weeks', [ 'weeks' => $weeks ]);
    }

    public function update_week(Request $Request)
    {
        $week_id = $Request->week_id;
        $level_id = $Request->level;
        $homework_file = $Request->homework_file;

        $week = Week::where('id', $week_id)->firstOrFail();

        $level = Sub_level::where('id', $Request->level)->first();

        if(empty($level))
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار المستوي الفرعي", "Please select the sub level");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
        if ($Request->hasFile('homework_file'))
        {
            $rules = array(
                'week_name' => 'required',
                'week_name_en' => 'required',
                'week_number' => 'required',
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
                    \File::delete($week->file_path);

                    $week->week_name = $Request->week_name;
                    $week->week_en_name = $Request->week_name_en;
                    $week->week_number = $Request->week_number;
                    $week->homework_file_path = $path.$file_name;
                    $week->homework_file_url = $file_url;
                    $week->homework_file_name = $file_name;
                    $week->tajweed_link = $Request->tajweed_link;
                    $week->tafsir_link = $Request->tafsir_link;
                    $week->sub_level_id = $level_id;
                    $week->save();

                    $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل الأسبوع بنجاح", "Week successfully modified");
                    return Redirect::back()->withErrors(array('success' => $redirct_message));
                }
            }
        }
        else
        {
            $week->week_name = $Request->week_name;
            $week->week_en_name = $Request->week_name_en;
            $week->week_number = $Request->week_number;
            $week->tajweed_link = $Request->tajweed_link;
            $week->tafsir_link = $Request->tafsir_link;
            $week->sub_level_id = $level_id;
            $week->save();

            $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل الأسبوع بنجاح", "Week successfully modified");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
    }

    public function set_week(Request $Request)
    {
        $level_id = $Request->level;
        $homework_file = $Request->homework_file;

        $level = Sub_level::where('id', $Request->level)->first();

        if(empty($level))
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار المستوي الفرعي", "Please select the sub level");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }

        if ($level_id && $homework_file)
        {
            if ($Request->hasFile('homework_file'))
            {

                $rules = array(
                    'week_name' => 'required',
                    'week_name_en' => 'required',
                    'week_number' => 'required',
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
                    $Request->flashOnly('week_name', 'week_name_en', 'week_number', 'tajweed_link', 'tafsir_link');
                    return Redirect::back()->withErrors(array('error' => $FirstError));

                }

                $week_number = Week::where('week_number', $Request->week_number)->first();

                if($week_number)
                {
                    $redirct_message = MyHelper::ReturnMessageByLang("رقم الأسبوع الذي أدخلته تم أدخاله من قبل", "Week number you enter is already exist");
                    return Redirect::back()->withErrors(array('error' => $redirct_message));
                }

                if ($Request->file('homework_file')->isValid())
                {
                    $file_name = md5(uniqid(time())) . '.' . $Request->file('homework_file')->getClientOriginalExtension();
                    $path = base_path() . "/resources/homework_files/";


                    $file_url = url('homework_files/'.$file_name, $parameters = [], $secure = null);

                    if($homework_file->move($path, $file_name))
                    {
                        $week = new Week();
                        $week->week_name = $Request->week_name;
                        $week->week_en_name = $Request->week_name_en;
                        $week->week_number = $Request->week_number;
                        $week->homework_file_path = $path.$file_name;
                        $week->homework_file_url = $file_url;
                        $week->homework_file_name = $file_name;
                        $week->tajweed_link = $Request->tajweed_link;
                        $week->tafsir_link = $Request->tafsir_link;
                        $week->sub_level_id = $level_id;
                        $week->save();

                        $redirct_message = MyHelper::ReturnMessageByLang("تم أصافة الأسبوع بنجاح", "Week successfully added");
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

    public function delete_week(Request $request)
    {
        $week_id = $request->week_id;

        $week = Week::where('id', $week_id)->firstOrFail();

        $file_path = base_path() . "/resources/homework_files/" . $week->homework_file_name;

        File::delete($file_path);

        if($week->delete())
        {
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف الأسبوع بنجاح", "Week successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));

        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

}
