<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public $table      = 'backend_menus';
    public $timestamps = false;

    // 子菜单
    public function childMenus()
    {
        return $this->hasMany('App\Menu', 'parent');
    }

    // 父级菜单
    public function parentMenu()
    {
        return $this->belongsTo('App\Menu', 'parent');
    }
}
