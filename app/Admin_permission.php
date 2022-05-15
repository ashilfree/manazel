<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin_permission extends Model
{
    Public function admin()
    {
        return $this->belongsTo('App\Admin', 'admin_id');
    }
}
