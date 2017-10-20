<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function delete(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // 移除角色的所有权限
        $bool = $role->permissions()->detach();
        if (!$bool) {
            return redirect()->back()->with('error', '删除角色权限失败');
        }

        // 移除角色的所有用户
        $bool = $role->users()->detach();
        if (!$bool) {
            return redirect()->back()->with('error', '删除角色的用户失败');
        }

        // 移除角色
        if ($role->delete()) {
            return redirect()->back()->with('success', '删除角色成功');
        } else {
            return redirect()->back()->with('error', '删除角色失败');
        }
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'role_name'      => 'required',
                'name'           => 'required',
                'permission_ids' => 'required|array',
            ]);

            // 角色
            $role->role_name = $request->role_name;
            $role->name      = $request->name;
            if (!$role->save()) {
                return redirect()->back()->with('error', '修改角色失败');
            }

            // 角色的权限
            $bool = $role->permissions()->sync($request->permission_ids);
            if (!$bool) {
                return redirect()->back()->with('error', '修改角色的权限失败');
            }

            return redirect()->route('role.index')->with('success', '修改角色成功');
        }

        // 所有角色
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('home/role/update', [
            'role'             => $role,
            'role_permissions' => $role->permissions, // 获取角色的所有权限
            'permissions'      => $permissions,
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'role_name'      => 'required',
                'name'           => 'required',
                'permission_ids' => 'required|array',
            ]);

            // 添加角色
            $role            = Role::firstOrNew(['name' => $request->name]); // 不存在才添加
            $role->role_name = $request->role_name;
            if (!$role->save()) {
                return redirect()->back()->with('error', '添加角色失败');
            }

            // 添加角色权限
            $bool = $role->permissions()->sync($request->permission_ids);
            if (!$bool) {
                return redirect()->back()->with('error', '添加角色失败');
            }

            return redirect()->route('role.index')->with('success', '添加角色成功');
        }

        // 所有角色
        $permissions = Permission::orderBy('name', 'asc')->get();

        return view('home/role/create', [
            'permissions' => $permissions,
        ]);
    }

    public function index()
    {
        // 获取角色列表
        $list = Role::with('permissions')->paginate(10);

        return view('home/role/index', [
            'list' => $list,
        ]);
    }
}
