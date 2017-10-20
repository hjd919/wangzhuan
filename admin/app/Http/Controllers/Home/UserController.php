<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // 修改用户角色
    public function attachRole(Request $request, $id)
    {
        // 获取用户
        $user = User::findOrFail($id);

        if ($request->isMethod('POST')) {

            // 验证输入
            $this->validate($request, [
                'role_ids' => 'required|array',
            ]);

            $role_ids = $request->role_ids;

            // 用户的角色记录
            $user->roles()->sync($role_ids);

            return redirect()->route('user.index')->with('success', '角色授予成功-' . $id);
        }

        // 获取用户角色
        $user_roles = [];
        foreach ($user->roles as $role) {
            $user_roles[] = $role->id;
        }

        // 获取所有角色
        $roles = Role::all();

        return view('home/user/attach_role', [
            'user_roles' => $user_roles,
            'roles'      => $roles,
        ]);
    }

    // 修改密码
    public function updatePassword(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $password = $request->password;

            // 验证输入
            $this->validate($request, [
                'password' => 'required|min:6|confirmed',
            ]);

            $user           = User::findOrFail($id);
            $user->password = bcrypt($password);
            if ($user->save()) {
                return redirect('home/user/index')->with('success', '修改用户密码成功');
            } else {
                return redirect()->back()->with('error', '修改用户密码失败');
            }
        }

        return view('home/user/update_password');
    }

    // 删除用户
    public function delete(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return redirect()->back()->with('success', '删除用户成功');
        } else {
            return redirect()->back()->with('error', '删除用户失败');
        }
    }

    // 添加用户
    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {

            $username = $request->username;
            $password = $request->password;

            // 验证输入
            $this->validate($request, [
                'username' => 'required|max:32|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);

            if (User::create([
                'name'     => $username,
                'username' => $username,
                'password' => bcrypt($password),
            ])) {
                return redirect('home/user/index')->with('success', '添加用户成功');
            } else {
                return redirect()->back()->with('error', '添加用户失败');
            }
        }

        return view('home/user/create');
    }

    // 用户列表
    public function index()
    {
        $list = User::with('roles')->paginate(10);

        return view('home/user/index', [
            'list' => $list,
        ]);
    }
}
