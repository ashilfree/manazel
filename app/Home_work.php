<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home_work extends Model
{
    Public function level()
    {
        return $this->belongsTo('App\Level', 'level_id');
    }
}
