<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    Public function sub_level()
    {
        return $this->belongsTo('App\Sub_level', 'sub_level_id');
    }
}
