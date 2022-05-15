<?php

namespace App\Http\Controllers;

use App\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Helper\MyHelper;
use Response;
use View;

class LevelController extends Controller
{
    public function add_level()
    {
        return view('/levels/add_level');
    }

    public function all_levels()
    {
        $levels = Level::orderBy('id', 'DESC')->paginate(20);
        return view('/levels/all_levels', [ 'levels' => $levels ]);
    }

    public function modify_level($id)
    {
        $level = Level::where('id', $id)->firstOrFail();
        return view('/levels/modify_level', [ 'level' => $level ]);
    }

    public function set_level(Request $Request)
    {
        $rules = array(
            'ar_level_name' => 'required',
            'ar_the_level' => 'required',
            'en_level_name' => 'required',
            'en_the_level' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ar_level_name.required'=>'برجاء أدخال أسم المستوي بالغة العربية',
                'ar_the_level.required'=>'برجاء أدخال المستوي بالغة العربية',
                'en_level_name.required'=>'برجاء أدخال أسم المستوي بالغة الانجليزية',
                'en_the_level.required'=>'برجاء أدخال المستوي بالغة الانجليزية',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ar_level_name.required'=>'Please enter level name in arabic',
                'ar_the_level.required'=>'Please enter the level in arabic',
                'en_level_name.required'=>'Please enter level name in english',
                'en_the_level.required'=>'Please enter the level in english',
            );
        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('ar_level_name', 'ar_the_level', 'en_level_name', 'en_the_level');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }

        $level = new Level();
        $level->name = $Request->ar_level_name;
        $level->en_name = $Request->en_level_name;
        $level->level = $Request->ar_the_level;
        $level->en_level = $Request->en_the_level;
        $level->save();

        $redirct_message = MyHelper::ReturnMessageByLang("تم أضافة المستوي بنجاح", "Level successfully added");
        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function update_level_data(Request $Request)
    {
        $level = Level::where('id', $Request->level_id)->firstOrFail();
        $rules = array(
            'ar_level_name' => 'required',
            'ar_the_level' => 'required',
            'en_level_name' => 'required',
            'en_the_level' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ar_level_name.required'=>'برجاء أدخال أسم المستوي بالغة العربية',
                'ar_the_level.required'=>'برجاء أدخال المستوي بالغة العربية',
                'en_level_name.required'=>'برجاء أدخال أسم المستوي بالغة الانجليزية',
                'en_the_level.required'=>'برجاء أدخال المستوي بالغة الانجليزية',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ar_level_name.required'=>'Please enter level name in arabic',
                'ar_the_level.required'=>'Please enter the level in arabic',
                'en_level_name.required'=>'Please enter level name in english',
                'en_the_level.required'=>'Please enter the level in english',
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
        $level->level = $Request->ar_the_level;
        $level->en_level = $Request->en_the_level;
        $level->save();

        $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل المستوي بنجاح", "Level successfully edited");
        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function find_level(Request $Request)
    {
        $keyword = $Request->keyword;
        $all = $Request->all;

        if($all == 'yes')
        {
            $levels = Level::orderBy('id', 'DESC')->paginate(20);
            $levels->setPath('/levels');
        }
        else
        {
            if(app()->getLocale() == "ar")
            {
                $levels = Level::where('name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
            elseif (app()->getLocale() == "en")
            {
                $levels = Level::where('en_name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);

            }
            else
            {
                $levels = Level::where('name','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
        }
        return Response::json(View::make('levels.find_level_tl', array('levels' => $levels, 'all' => $all))->render());
    }

    public function delete_level(Request $request)
    {
        $level_id = $request->level_id;

        $level = Level::where('id', $level_id)->firstOrFail();

        if($level->delete())
        {
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
