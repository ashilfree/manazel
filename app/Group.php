<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    Public function level()
    {
        return $this->belongsTo('App\Level', 'level_id');
    }

    Public function teacher()
    {
        return $this->belongsTo('App\User', 'admin_id');
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    Public function week()
    {
        return $this->belongsTo('App\Week', 'week_id');
    }
}
