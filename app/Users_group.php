<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_group extends Model
{
    Public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
