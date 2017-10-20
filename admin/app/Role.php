<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    // 定义关联权限
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }

    // 定义关联权限
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
