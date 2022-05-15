<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_homework extends Model
{
    Public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    Public function group()
    {
        return $this->belongsTo('App\Sub_group', 'group_id');
    }

    Public function homework()
    {
        return $this->belongsTo('App\Home_work', 'home_work_id');
    }
}
