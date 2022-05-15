<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sub_group extends Model
{
    Public function main_group()
    {
        return $this->belongsTo('App\Group', 'group_id');
    }
    Public function teacher()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }
    Public function week()
    {
        return $this->belongsTo('App\Week', 'week_id');
    }

}
