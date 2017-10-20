<?php

namespace App\Http\Controllers\Home;

use App\Config;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    // 删除
    public function delete($id)
    {
        $config = Config::find($id);

        if ($config->delete()) {
            return redirect('home/config/index')->with('success', '删除成功！--' . $id);
        } else {
            return redirect()->back()->with('error', '删除失败！');
        }
    }

    // 修改
    public function update(Request $request, $id)
    {
        $config = Config::find($id);
        if ($request->isMethod('POST')) {

            $data = $request->Config;
            // 验证输入
            $this->_validate($request);
            $res = Config::where('id', $id)->update($data);
            if ($res) {
                return redirect('home/config/index')->with('success', '修改成功！--' . $id);
            } else {
                return redirect()->back()->with('error', '修改失败！');
            }
        }
        return view('home/config/update', [
            'config' => $config,
        ]);
    }

    // 添加
    public function create(Request $request)
    {
        // 保持添加
        if ($request->isMethod('POST')) {

            // 验证输入
            $this->_validate($request);

            $data = $request->Config;
            print_r($data);
            if (Config::create($data)) {
                return redirect('home/config/index')->with('success', '添加成功了');
            } else {
                return redirect()->back()->with('error', '修改失败！');
            }
        }

        return view('home/config/create');
    }

    // 列表
    public function index()
    {
        // 获取列表
        $configs = Config::orderBy('id', 'desc')->paginate(10);

        return view('home/config/index', [
            'configs' => $configs,
        ]);
    }

    // 验证输入
    private function _validate($request)
    {
        $this->validate($request, [
            'Config.config_name' => 'required',
            'Config.value'       => 'required',
            'Config.description' => 'required',

        ], [], [
            'Config.config_name' => '关键词',
            'Config.value'       => '配置值',
            'Config.description' => '配置描述',
        ]);
    }
}
