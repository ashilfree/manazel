<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login_log extends Model
{
    Public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
