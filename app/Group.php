<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    Public function level()
    {
        return $this->belongsTo('App\Level', 'level_id');
    }

    Public function sub_level()
    {
        return $this->belongsTo('App\Sub_level', 'sub_level_id');
    }

}
