<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    // 定义关联角色
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
}
