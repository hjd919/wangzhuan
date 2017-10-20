<?php

namespace App\Http\Middleware;

use App\Menu;
use Artesaos\Defender\Facades\Defender;
use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Home
{
    private $active_menu_ids = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 获取菜单
        $menus = Menu::with('childMenus')
            ->where('parent', '0')
            ->where('is_nav', '1')
            ->get();

        // 获取激活的菜单id
        $route_name  = Route::currentRouteName();
        $active_menu = Menu::where('route_name', $route_name)
            ->where('is_nav', '1')
            ->first();
        if ($active_menu) {
            $active_menu_ids   = [];
            $active_menu_ids[] = $active_menu->id;
            if ($active_menu->parentMenu) {
                $active_menu_ids[] = $active_menu->parentMenu->id;
            }
            $this->active_menu_ids = $active_menu_ids;
        }

        // 递归获取菜单 =》 循环获取
        $menus = $menus->filter(function ($menu) {

            if (!$menu->childMenus->isEmpty()) {

                // 二级菜单

                $menu->childMenus = $menu->childMenus->filter(function ($menu2) {

                    // 判断二级菜单是否激活
                    $menu2->active = $this->_isActiveMenu($menu2->id) ? 'active' : '';

                    return $this->_checkAccessControl($menu2);
                });
                if (!$menu->childMenus->isEmpty()) {

                    // 判断一级菜单是否激活
                    $menu->active = $this->_isActiveMenu($menu->id) ? 'active' : '';

                    return $menu;
                }
            }

            // 一级菜单

            // 判断一级菜单是否激活
            $menu->active = $this->_isActiveMenu($menu->id) ? 'active' : '';

            // 检查权限
            $menu = $this->_checkAccessControl($menu);
            return $menu;
        });

        View::share('menus', $menus);

        return $next($request);
    }

    // 检查权限
    public function _checkAccessControl($menu)
    {
        // 判断权限点,判断是否有子权限点
        if ($menu->route_name && Defender::canDo($menu->route_name)) {
            return $menu;
        } elseif (!$menu->route_name && 0 == $menu->parent) {
            $subMenus = $menu->childMenus;
            // 判断子菜单有无权限
            foreach ($subMenus as $subMenu) {
                if ($subMenu->route_name && Defender::canDo($subMenu->route_name)) {
                    return $menu;
                }
                // 判断子子菜单了。。todo 递归
            }
        }
    }

    // 判断是否显示激活
    public function _isActiveMenu($id)
    {
        if (in_array($id, $this->active_menu_ids)) {
            return true;
        } else {
            return false;
        }
    }
}
