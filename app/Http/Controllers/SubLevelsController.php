<?php

namespace App\Http\Controllers;

use App\Level;
use App\Sub_group;
use App\Sub_level;
use App\Users_group;
use App\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Helper\MyHelper;
use Response;
use View;

class SubLevelsController extends Controller
{
    public function add_sub_level()
    {
        $levels = Level::all();
        return view('/sub_levels/add_level', ['levels' => $levels]);
    }

    public function modify_sub_level($id)
    {
        $levels = Level::all();
        $level = Sub_level::where('id', $id)->firstOrFail();
        return view('/sub_levels/modify_level', [ 'level' => $level, 'levels' => $levels]);
    }

    public function all_sub_levels()
    {
        $levels = Sub_level::orderBy('id', 'DESC')->paginate(20);
        return view('/sub_levels/all_levels', [ 'levels' => $levels ]);
    }

    public function set_sub_level(Request $Request)
    {
        $rules = array(
            'ar_level_name' => 'required',
            'en_level_name' => 'required',
            'main_level' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ar_level_name.required'=>'برجاء أدخال أسم المستوي بالغة العربية',
                'en_level_name.required'=>'برجاء أدخال أسم المستوي بالغة الانجليزية',
                'main_level.required'=>'برجاء أختيار المستوي الرئيسي',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ar_level_name.required'=>'Please enter level name in arabic',
                'en_level_name.required'=>'Please enter level name in english',
                'main_level.required'=>'Please select the main level',
            );
        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('ar_level_name', 'en_level_name');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }

        $level = new Sub_level();
        $level->name = $Request->ar_level_name;
        $level->en_name = $Request->en_level_name;
        $level->level_id = $Request->main_level;
        $level->save();

        $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة المستوي بنجاح", "Level successfully added");
        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function update_sub_level(Request $Request)
    {
        $level = Sub_level::where('id', $Request->level_id)->firstOrFail();
        $rules = array(
            'ar_level_name' => 'required',
            'en_level_name' => 'required',
            'main_level' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ar_level_name.required'=>'برجاء أدخال أسم المستوي بالغة العربية',
                'en_level_name.required'=>'برجاء أدخال أسم المستوي بالغة الانجليزية',
                'main_level.required'=>'برجاء أختيار المستوي الرئيسي',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ar_level_name.required'=>'Please enter level name in arabic',
                'en_level_name.required'=>'Please enter level name in english',
                'main_level.required'=>'Please select the main level',
            );
        }


        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('ar_level_name', 'ar_the_level', 'en_level_name', 'en_the_level');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }


        $level->name = $Request->ar_level_name;
        $level->en_name = $Request->en_level_name;
        $level->level_id = $Request->main_level;
        $level->save();

        $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل المستوي بنجاح", "Level successfully edited");
        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function find_sub_level(Request $Request)
    {
        $keyword = $Request->keyword;
        $all = $Request->all;

        if($all == 'yes')
        {
            $levels = Sub_level::orderBy('id', 'DESC')->paginate(20);
            $levels->setPath('/levels');
        }
        else
        {
            if(app()->getLocale() == "ar")
            {
                $levels = Sub_level::where('name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
            elseif (app()->getLocale() == "en")
            {
                $levels = Sub_level::where('en_name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);

            }
            else
            {
                $levels = Sub_level::where('name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
        }
        return Response::json(View::make('sub_levels.find_level_tl', array('levels' => $levels, 'all' => $all))->render());
    }

    public function get_sub_levels(Request $Request)
    {
        $level_id = $Request->id;
        $sub_levels = Sub_level::where('level_id', $level_id)->get();
        return Response::json( $sub_levels->toArray() );

    }

    public function delete_sub_level(Request $request)
    {
        $level_id = $request->level_id;

        $level = Sub_level::where('id', $level_id)->firstOrFail();
        $level_sub_groups = Sub_group::where('sub_level_id', $level->id);
        $level_weeks = Week::where('sub_level_id', $level->id);



        if($level->delete())
        {
            $level_sub_groups->delete();
            $level_weeks->delete();
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف المستوي بنجاح", "Level successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء أعادة المحاولة", "Error please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

}
