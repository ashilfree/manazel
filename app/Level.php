<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    Public function homeworks()
    {
        return $this->hasMany('App\Home_work', 'level_id');
    }
}
