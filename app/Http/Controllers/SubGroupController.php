<?php

namespace App\Http\Controllers;

use App\Group;
use App\Sub_group;
use App\User;
use App\Users_group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Helper\MyHelper;
use Response;
use View;

class SubGroupController extends Controller
{
    public function add_sub_group()
    {
        $groups = Group::all();
        return view('/sub_groups/add_sub_group', ['groups' => $groups]);
    }

    public function all_sub_groups()
    {
        $sub_groups = Sub_group::orderBy('id', 'DESC')->paginate(20);
        return view('/sub_groups/all_sub_groups', [ 'sub_groups' => $sub_groups ]);
    }

    public function modify_sub_group($id)
    {
        $main_groups = Group::all();
        $group = Sub_group::where('id', $id)->firstOrFail();
        return view('/sub_groups/modify_sub_group', [ 'group' => $group, 'main_groups' => $main_groups ]);
    }

    public function set_sub_group(Request $Request)
    {
        $rules = array(
            'group_name' => 'required',
            'en_group_name' => 'required',
            'group_student_num' => 'required',
            'main_group' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'group_name.required'=>'برجاء أدخال أسم الجروب بالغة العربية',
                'en_group_name.required'=>'برجاء أدخال أسم الجروب بالغة الانجليزية',
                'group_student_num.required'=>'برجاء أدخال عدد الطلاب في الجروب',
                'main_group.required'=>'برجاء أختيار الجروب الرئيسي',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'group_name.required'=>'Please enter group name in arabic',
                'en_group_name.required'=>'Please enter group name in english',
                'group_student_num.required'=>'Please enter number of students in the group',
                'main_group.required'=>'Please select the main group',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('group_name', 'en_group_name', 'main_group');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }

        $main_group = Group::where('id', $Request->main_group)->firstOrFail();

        $group = new Sub_group();
        $group->name = $Request->group_name;
        $group->en_name = $Request->en_group_name;
        $group->max_students = $Request->group_student_num;
        $group->group_id = $Request->main_group;
        $group->level_id = $main_group->level_id;
        $group->sub_level_id = $main_group->sub_level_id;
        $group->week_id = $Request->week;
        $group->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم أنشاء الجروب الفرعي بنجاح", "Subgroup successfully created");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function update_sub_groups_data(Request $Request)
    {
        $sub_group = Sub_group::where('id', $Request->sub_group_id)->firstOrFail();
        $main_group = Group::where('id', $Request->main_group)->firstOrFail();

        $rules = array(
            'group_name' => 'required',
            'en_group_name' => 'required',
            'group_student_num' => 'required',
            'main_group' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'group_name.required'=>'برجاء أدخال أسم الجروب بالغة العربية',
                'en_group_name.required'=>'برجاء أدخال أسم الجروب بالغة الانجليزية',
                'group_student_num.required'=>'برجاء أدخال عدد الطلاب في الجروب',
                'main_group.required'=>'برجاء أختيار الجروب الرئيسي',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'group_name.required'=>'Please enter group name in arabic',
                'en_group_name.required'=>'Please enter group name in english',
                'group_student_num.required'=>'Please enter number of students in the group',
                'main_group.required'=>'Please select the main group',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            $Request->flashOnly('group_name', 'en_group_name', 'level');
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }

        if($sub_group->group_id != $Request->main_group)
        {
            $sub_groups_data = Users_group::where('sub_group_id', $sub_group->id);
            $sub_groups_data->delete();
            $sub_group->admin_id = null;
        }

        $sub_group->name = $Request->group_name;
        $sub_group->en_name = $Request->en_group_name;
        $sub_group->max_students = $Request->group_student_num;
        $sub_group->group_id = $Request->main_group;
        $sub_group->week_id = $Request->week;
        $sub_group->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم تعديل الجروب بنجاح", "Group successfully modified");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function ban_group(Request $Request)
    {
        $sub_group = Sub_group::where('id', $Request->group_id)->firstOrFail();
        //$main_group = Group::where('id', $Request->main_group)->firstOrFail();

        $rules = array(
            'ban_from' => 'required',
            'ban_to' => 'required',
        );

        if(app()->getLocale() == 'ar')
        {
            $messages = array(
                'ban_from.required'=>'برجاء أختيار تاريخ بدأ يقاف الجروب',
                'ban_to.required'=>'برجاء أختيار تاريخ أنتهاء يقاف الجروب',
            );
        }
        elseif (app()->getLocale() == 'en')
        {
            $messages = array(
                'ban_from.required'=>'Please select group ban start date',
                'ban_to.required'=>'Please select group ban end date',
            );

        }

        $validator = Validator::make($Request->all(), $rules,$messages);
        if($validator->fails())
        {
            $FirstError =$validator->errors()->first();
            return Redirect::back()->withErrors(array('error' => $FirstError));

        }

        if($Request->ban_from > $Request->ban_to)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ التاريخ غير صحيح", "Error date is invalid");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }

        $sub_group->ban_from = $Request->ban_from;
        $sub_group->ban_to = $Request->ban_to;
        $sub_group->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم أضافة تاريخ إيقاف الجروب بنجاح", "Ban group date added successfully");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function change_group_teacher(Request $Request)
    {
        $group_id = $Request->group_id;
        $teacher_id = $Request->teacher_id;

        $group = Sub_group::where('id', $group_id)->firstOrFail();
        $teacher = User::where('id', $teacher_id)->firstOrFail();

        if($group->admin_id == $teacher->id)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ المعلم الذي اخترتة هو معلم الجروب بالفعل", "Error The teacher you selected is already the group teacher");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }

        if($group->main_group->level_id != $teacher->level_id)
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ مستوي المعلم مختلف عن مستوي الجروب", "Error teacher level is different from group level");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }

        $group->admin_id = $teacher->id;
        $group->save();

        $redirect_message = MyHelper::ReturnMessageByLang("تم تعديل او أضافة معلم الجروب بنجاح", "The group teacher has been successfully changed or added");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function add_group_students(Request $Request)
    {
        $group_id = $Request->group_id;
        //$student_id = $Request->student_id;

        $group = Sub_group::where('id', $group_id)->firstOrFail();

        if(!count($Request->students_id))
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ لم يتم إختيار الطلاب", "Error no students selected");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }

        foreach ($Request->students_id as $student_id)
        {
            $student = User::where('id', $student_id)->firstOrFail();
            $user_group_exist = Users_group::where('id', $student_id)->first();

            if(!empty($user_group_exist))
            {
                $redirect_message = MyHelper::ReturnMessageByLang("خطأ احد الطلاب الذي اخترتهم موجود في جروب بالفعل", "Error one of a student you have selected already in another group");
                return Redirect::back()->withErrors(array('error' => $redirect_message));
            }

            if($group->main_group->level_id != $student->level_id)
            {
                $redirect_message = MyHelper::ReturnMessageByLang("خطأ مستوي احد الطلاب  مختلف عن مستوي الجروب", "Error one of a student level is different from group level");
                return Redirect::back()->withErrors(array('error' => $redirect_message));
            }

            $user_group = new Users_group();
            $user_group->user_id = $student_id;
            $user_group->sub_group_id = $group->id;
            $user_group->save();
        }
        $redirect_message = MyHelper::ReturnMessageByLang("تم أضافة الطلاب الي الجروب بنجاح", "Students successfully added to the group");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function activate_group(Request $Request)
    {
        $group_id = $Request->group_id;
        //$student_id = $Request->student_id;

        $group = Sub_group::where('id', $group_id)->firstOrFail();
        $group->ban_from = null;
        $group->ban_to = null;
        $group->save();
        $redirect_message = MyHelper::ReturnMessageByLang("تم تفعيل وتشغيل الجروب بنجاح", "The group successfully activated");
        return Redirect::back()->withErrors(array('success' => $redirect_message));
    }

    public function delete_sub_group(Request $Request)
    {
        $sub_group_id = $Request->sub_group_id;
        $sub_group = Sub_group::where('id', $sub_group_id)->firstOrFail();
        $sub_groups_data = Users_group::where('sub_group_id', $sub_group->id);

        if($sub_group->delete())
        {
            $sub_groups_data->delete();
            $redirect_message = MyHelper::ReturnMessageByLang("تم حذف الجروب و البيانات المرتبطة به بنجاح", "The group and associated data successfully deleted");
            return Redirect::back()->withErrors(array('success' => $redirect_message));
        }
        else
        {
            $redirect_message = MyHelper::ReturnMessageByLang("خطأ برجاء إعادة المحاولة", "Error, Please try again");
            return Redirect::back()->withErrors(array('error' => $redirect_message));
        }
    }

}
