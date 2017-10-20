<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class PermissionController extends Controller
{
    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $path     = $request->file('file')->store('permissions');
        $filepath = public_path('storage') . '/' . $path;

        // 数据库字段和导入文件字段的map
        $field_map = [
            '权限点' => 'name',
            '描述'  => 'readable_name',
        ];

        // 导入权限
        $reader  = Excel::load($filepath);
        $results = $reader->get();

        try {
            DB::beginTransaction();

            foreach ($results as $key => $row) {

                // 验证excel的数据
                $validator = Validator::make($row->toArray(), [
                    '权限点' => 'required',
                    '描述'  => 'required',
                ]);
                $errors = $validator->fails();
                if ($errors) {
                    $errors = $validator->errors();
                    throw new \Exception("第" . ($key + 1) . "行---" . $errors->first(), 1);
                    break;
                }

                // 添加权限
                $data = [
                    $field_map['权限点'] => $row->权限点,
                    $field_map['描述']  => $row->描述,
                ];
                $bool = Permission::firstOrCreate($data);
                if (!$bool) {
                    throw new \Exception('插入数据库失败', 1);
                    break;
                }
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            // 删除导入的文件
            unlink($filepath);

            return redirect()->route('permission.index')->with('error', $e->getMessage());
        }

        // 删除导入的文件
        unlink($filepath);

        return redirect()->route('permission.index')->with('success', '导入权限成功');
    }

    public function delete(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $bool = $permission->delete();
        if (!$bool) {
            return redirect()->back()->with('error', '删除权限失败');
        }

        $bool = $permission->roles()->detach();

        return redirect()->route('permission.index')->with('success', '删除权限成功');
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'name'          => 'required',
                'readable_name' => 'required',
            ]);

            $permission->name          = $request->name;
            $permission->readable_name = $request->readable_name;
            $bool                      = $permission->save();
            if (!$bool) {
                return redirect()->back()->with('error', '修改权限失败');
            }

            return redirect()->route('permission.index')->with('success', '修改权限成功');
        }

        return view('home/permission/update', [
            'permission' => $permission,
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('POST')) {

            $this->validate($request, [
                'name'          => 'required',
                'readable_name' => 'required',
            ]);

            $permission                = new Permission;
            $permission->name          = $request->name;
            $permission->readable_name = $request->readable_name;
            $bool                      = $permission->save();
            if (!$bool) {
                return redirect()->back()->with('error', '添加权限失败');
            }

            return redirect()->route('permission.index')->with('success', '添加权限成功');

        }

        return view('home/permission/create');
    }

    public function index()
    {
        $list = Permission::orderBy('name', 'asc')->paginate(10);

        return view('home/permission/index', [
            'list' => $list,
        ]);
    }
}
