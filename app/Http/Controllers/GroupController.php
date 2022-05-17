<?php

namespace App\Http\Controllers;

use App\Group;
use App\Level;
use App\Sub_group;
use App\Sub_level;
use App\Week;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Helper\MyHelper;
use Response;
use View;

class GroupController extends Controller
{
    public function add_group()
    {
        $levels = Level::all();
        $sub_levels = Sub_level::all();
        return view('/groups/add_group', ['levels' => $levels, 'sub_levels' => $sub_levels]);
    }

    public function all_groups()
    {
        $groups = Group::orderBy('id', 'DESC')->paginate(20);
        return view('/groups/all_groups', [ 'groups' => $groups ]);
    }

    public function modify_group($id)
    {
        $levels = Level::all();
        $sub_levels = Sub_level::all();
        $group = Group::where('id', $id)->firstOrFail();
        return view('/groups/modify_group', [ 'group' => $group, 'sub_levels' => $sub_levels, 'levels' => $levels ]);
    }

    public function set_group(Request $Request)
    {
        $rules = array(
            'group_name' => 'required',
            'en_group_name' => 'required',
            'level' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'group_name.required'=>'برجاء أدخال أسم الجروب بالغة العربية',
                'en_group_name.required'=>'برجاء أدخال أسم الجروب بالغة الانجليزية',
                'level.required'=>'برجاء أختيار المستوي',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'group_name.required'=>'Please enter group name in arabic',
                'en_group_name.required'=>'Please enter group name in english',
                'level.required'=>'Please select the level',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('group_name', 'en_group_name', 'level');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }
        $group = new Group();
        $group->name = $Request->group_name;
        $group->en_name = $Request->en_group_name;
        $group->level_id = $Request->level;
        $group->sub_level_id = $Request->sub_level_id;
        $group->save();

        $redirct_message = MyHelper::ReturnMessageByLang("تم أنشاء الجروب بنجاح", "Group successfully created");
        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function update_groups_data(Request $Request)
    {
        $group = Group::where('id', $Request->group_id)->firstOrFail();
        $level = Level::where('id', $Request->level)->first();

        if(empty($level))
        {
            $redirct_message = MyHelper::ReturnMessageByLang("برجاء أختيار المستوي", "Please select the level");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
        $rules = array(
            'group_name' => 'required',
            'en_group_name' => 'required',
            'level' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'group_name.required'=>'برجاء أدخال أسم الجروب بالغة العربية',
                'en_group_name.required'=>'برجاء أدخال أسم الجروب بالغة الانجليزية',
                'level.required'=>'برجاء أختيار المستوي',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'group_name.required'=>'Please enter group name in arabic',
                'en_group_name.required'=>'Please enter group name in english',
                'level.required'=>'Please select the level',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('group_name', 'en_group_name', 'level');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }
        $group->name = $Request->group_name;
        $group->en_name = $Request->en_group_name;
        $group->level_id = $Request->level;
        $group->sub_level_id = $Request->sub_level_id;
        $group->save();

        $redirct_message = MyHelper::ReturnMessageByLang("تم تعديل الجروب بنجاح", "Group successfully modified");
        return Redirect::back()->withErrors(array('success' => $redirct_message));
    }

    public function get_group_weeks(Request $Request)
    {
        $group_id = $Request->id;
        $group = Group::where('id', $group_id)->firstOrFail();

        $weeks = Week::where('level_id', $group->sub_level_id)->get();
        return Response::json( $weeks->toArray() );

    }

    public function delete_group(Request $Request)
    {
        $group_id = $Request->group_id;
        $group = Group::where('id', $group_id)->first();
        $sub_groups = Sub_group::where('group_id', $group->id);

        if($group->delete())
        {
            $sub_groups->delete();
            $redirct_message = MyHelper::ReturnMessageByLang("تم حذف الجروب و الجروبات الفرعية المرتبطة به بنجاح", "The group and associated sub groups successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirct_message));
        }
        else
        {
            $redirct_message = MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again");
            return Redirect::back()->withErrors(array('error' => $redirct_message));
        }
    }

}
