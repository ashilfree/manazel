<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    Public function level()
    {
        return $this->belongsTo('App\Level', 'level_id');
    }

    Public function sudents()
    {
        return $this->belongsTo(User::class, 'group_id');
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }
}
