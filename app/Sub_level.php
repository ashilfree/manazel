<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_level extends Model
{
    Public function main_level()
    {
        return $this->belongsTo('App\Level', 'level_id');
    }
}
