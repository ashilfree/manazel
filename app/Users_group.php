<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_group extends Model
{
    Public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }

    Public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id');
    }
}
