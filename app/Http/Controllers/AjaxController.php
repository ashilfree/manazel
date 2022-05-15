<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Response;
use View;

class AjaxController extends Controller
{
    public function find_teacher(Request $Request)
    {
        $keyword = $Request->keyword;
        $all = $Request->all;
        $search_by = $Request->search_by;

        if($all == 'yes')
        {
            $teachers = User::where('type', 'teacher')->orderBy('id', 'DESC')->paginate(20);
            $teachers->setPath('/teachers');
        }
        else
        {
            if($search_by == "email")
            {
                $teachers = User::where('email','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
            elseif ($search_by == "username")
            {
                $teachers = User::where('username','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
            else
            {
                $teachers = User::where('username','LIKE','%'.$keyword.'%')->orderBy('id', 'DESC')->paginate(10);
            }
        }
        return Response::json(View::make('teachers.find_teacher_tl', array('teachers' => $teachers, 'all' => $all))->render());
    }
}
