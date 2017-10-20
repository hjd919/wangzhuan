<?php

namespace App\Http\Controllers\Home;

use App\App;
use App\Apps_ready;
use App\BrushApp;
use App\BrushComment;
use App\Comment;
use App\Email;
use App\Http\Controllers\Controller;
use App\Observers\AppObserver;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AppController extends Controller
{
    public function __construct()
    {
        App::observe(AppObserver::class);
    }

    // 统计刷任务
    public function statBrush(Request $request)
    {
        // 搜索
        $searchParams = [];
        $more_where   = '';
        // app_name
        $searchParams['app_name'] = $app_name = $request->input('app_name');
        if ($app_name) {
            $more_where .= " and app_name='$app_name'";
        }
        // keyword
        $searchParams['keyword'] = $keyword = $request->input('keyword');
        if ($keyword) {
            $more_where .= " and keyword='$keyword'";
        }

        // 最近两天，每个app每小时的刷量
        $latest_day = date('Y-m-d', strtotime('-3 days'));

        $page    = Paginator::resolveCurrentPage('page');
        $perPage = 20;

        $count_total = DB::select("select count(total_id) as total from (select count(id) total_id from brush_apps where create_time > ? {$more_where} group by date_format(`create_time`,'%Y-%m-%d %H'),app_id) a", [$latest_day]);

        $results = BrushApp::select(['app_id', 'app_name', 'keyword', DB::Raw("count(`id`) total"), DB::Raw("date_format(`create_time`,'%Y-%m-%d %H') hour_time")])
            ->where('create_time', '>=', $latest_day)
            ->when($app_name, function ($query) use ($app_name) {
                return $query->where('app_name', $app_name);
            })
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('keyword', $keyword);
            })
            ->limit($perPage)
            ->offset(($page - 1) * $perPage)
            ->groupBy('hour_time')
            ->groupBy('app_id')
            ->orderBy('hour_time', 'desc')
            ->get();

        $stat_hour_brush_list = new LengthAwarePaginator($results, $count_total[0]->total, $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        return view('home/app/stat_brush', [
            'stat_hour_brush_list' => $stat_hour_brush_list,
            'searchParams'         => $searchParams,
        ]);
    }

    // 导入应用
    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $path     = $request->file('file')->store('apps');
        $filepath = public_path('storage') . '/' . $path;

        // 导入权限
        $reader  = Excel::load($filepath);
        $results = $reader->get();

        try {
            DB::beginTransaction();

            foreach ($results as $key => $row) {

                // 验证excel的数据
                $validator = Validator::make($row->toArray(), [
                    'appid'     => 'required',
                    '应用名称'      => 'required',
                    'bundle_id' => 'required',
                    '进程名'       => 'required',
                    'ssid'      => 'required',
                    '关键词'       => 'required',
                    '优先级'       => 'required',
                    '数量'        => 'required',
                ]);
                $errors = $validator->fails();
                if ($errors) {
                    $errors = $validator->errors();
                    throw new \Exception("第" . ($key + 1) . "行---" . $errors->first(), 1);
                    break;
                }

                // 添加app

                // 用属性取回app，当结果不存在时实例化一个新实例
                $app = App::firstOrNew([
                    'keyword'  => $row->关键词,
                    'app_name' => $row->应用名称,
                    'ssid'     => $row->ssid,
                ]);
                $app->appid        = $row->appid;
                $app->bundle_id    = $row->bundle_id;
                $app->process_name = $row->进程名;
                $app->ord          = $row->优先级;
                $app->brush_num    = $row->数量;
                $app->is_brushing  = 1;
                $bool              = $app->save(); // 更新或者创建数据
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

            return redirect()->route('app.ready_list')->with('error', $e->getMessage());
        }

        // 删除导入的文件
        unlink($filepath);

        return redirect()->route('app.ready_list')->with('success', '导入成功');
    }

    // 准备队列
    public function readyList()
    {
        // 获取列表
        $rows = Apps_ready::limit(10)
            ->orderBy('ord', 'asc')
            ->orderBy('id', 'desc')
            ->paginate();
        return view('home/app/ready_list', [
            'rows' => $rows,
        ]);
    }

    // 复制
    public function copy(Request $request, $id)
    {
        $app = App::find($id);

        if ($request->isMethod('POST')) {

            $data = $request->App;

            // 验证输入
            $this->_validate($request);

            $app = App::create($data);
            if (isset($app->id)) {
                return redirect('home/app/index')->with('success', '复制成功！--' . $app->id);
            } else {
                return redirect()->back()->with('error', '复制失败！');
            }
        }

        return view('home/app/update', [
            'app' => $app,
        ]);
    }

    // 修改'是否开刷'
    public function update_is_brushing(Request $request, $is_brushing, $id = null)
    {
        $ids = $request->ids;
        if ($ids) {
            $ids = explode(',', $ids);
        } else {
            $ids = [$id];
        }

        $bath_res = true;
        foreach ($ids as $id) {
            $app = App::findOrFail($id);

            $app->is_brushing = $is_brushing;

            $bath_res = $bath_res && $app->save();
            logger("save res is " . var_export($bath_res, 1));

            // 如果失败，则不继续执行
            if (!$bath_res) {
                break;
            }
        }

        if ($bath_res) {
            return redirect()->back()->with('success', '修改刷成功！--' . join(',', $ids));
        } else {
            return redirect()->back()->with('error', '修改刷失败！');
        }
    }

    // 删除
    public function delete($id = null)
    {
        $ids = [$id];

        $deleteOne = function ($id) {
            $app = App::findOrFail($id);
            return $app->delete();
        };
        $bath_res = $deleteOne($id);

        if ($bath_res) {
            return redirect()->back()->with('success', '删除成功！--' . join(',', $ids));
        } else {
            return redirect()->back()->with('error', '删除失败！');
        }
    }

    // 修改
    public function update(Request $request, $id)
    {
        $app = App::findOrFail($id);

        if ($request->isMethod('POST')) {

            $data = $request->App;

            // 验证输入
            $this->_validate($request);

            $now = strtotime(date('Y-m-d', time()));

            $app->appid               = $data['appid'];
            $app->app_name            = $data['app_name'];
            $app->bundle_id           = $data['bundle_id'];
            $app->process_name        = $data['process_name'];
            $app->ssid                = $data['ssid'];
            $app->keyword             = $data['keyword'];
            $app->last_start_rank     = $data['last_start_rank'];
            $app->brush_num           = $data['brush_num'];
            $app->is_brushing         = $data['is_brushing'];
            $app->ord                 = $data['ord'];
            $app->changeip_type       = $data['changeip_type'];
            $app->last_changeip_num   = $data['last_changeip_num'];
            $app->each_changeip_num   = $data['each_changeip_num'];
            $app->comment_brush_num   = $data['comment_brush_num'];
            $app->comment_is_brushing = $data['comment_is_brushing'];
            $app->comment_start_time  = strtotime($data['comment_start_time']) > $now ? $data['comment_start_time'] : date('Y-m-d');
            $app->comment_end_time    = $data['comment_end_time'];
            $app->success_comment_num = $data['success_comment_num'];

            if ($app->save()) {
                return redirect('home/app/index')->with('success', '修改成功！--' . $id);
            } else {
                return redirect()->back()->with('error', '修改失败！');
            }
        }

        return view('home/app/update', [
            'app' => $app,
        ]);
    }

    // 添加
    public function create(Request $request)
    {
        // 保持添加
        if ($request->isMethod('POST')) {

            // 验证输入
            $this->_validate($request);

            $data = $request->App;

            $app = App::create($data);
            if ($app) {
                return redirect('home/app/index')->with('success', '添加成功了');
            } else {
                return redirect()->back()->with('error', '添加失败！');
            }
        }

        $app = new App;

        return view('home/app/create', [
            'app' => $app,
        ]);
    }

    public function exportlala($limit = 0)
    {
        $filename = date('YmdHi') . '.csv';
        $fp       = fopen(storage_path('app/emails/' . $filename), 'w');

        $cellData   = [];
        $cellData[] = ['appleid账号', 'appleid密码', '邮箱密码', '密保1', '密保2', '密保3', '生日'];
        $rows       = Email::where('is_valid', 1)->orderBy('valid_time', 'desc')->limit($limit)->get();
        foreach ($rows as $row) {
            // 你少年时代最好的朋友叫什么名字？-的感觉#你的理想工作是什么？-卖弄#你的父母是在哪里认识的？-炒股#1981-1-23
            list($mibao1, $mibao2, $mibao3, $birthday) = explode('#', $row->reg_info);

            $cellData[] = $csv_row = [
                $row->email,
                $row->appleid_password,
                $row->password,
                $mibao1,
                $mibao2,
                $mibao3,
                $birthday,
            ];

            fputcsv($fp, $csv_row);

            Email::where('id', $row->id)->delete();
        }

        Excel::create($limit . 'appleids', function ($excel) use ($cellData) {
            $excel->sheet('emails', function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    // 列表
    public function index(Request $request)
    {

        // return $this->exportlala(30);

        // 搜索
        $appid         = $request->appid;
        $app_name      = $request->app_name;
        $is_brushing   = $request->is_brushing;
        $ssid          = $request->ssid;
        $keyword       = $request->keyword;
        $id            = $request->id;
        $ord           = $request->ord;
        $has_brush_num = $request->has_brush_num;

        // 排序
        $sort_order = $request->sort_order;

        // 获取列表
        $apps = App::when($app_name,
            // 搜索条件
            function ($query) use ($app_name) {
                return $query->where('app_name', 'like', "%{$app_name}%");
            })
            ->when(null !== $is_brushing,
                function ($query) use ($is_brushing) {
                    return $query->where('is_brushing', $is_brushing);
                })
            ->when($appid,
                function ($query) use ($appid) {
                    return $query->where('appid', $appid);
                })
            ->when($ssid,
                function ($query) use ($ssid) {
                    return $query->where('ssid', 'like', "%$ssid%");
                })
            ->when($keyword,
                function ($query) use ($keyword) {
                    return $query->where('keyword', 'like', "%$keyword%");
                })
            ->when($ord,
                function ($query) use ($ord) {
                    return $query->where('ord', "$ord");
                })
            ->when($has_brush_num,
                function ($query) use ($has_brush_num) {
                    return $query->where('brush_num', '>', 0);
                })
        // 排序
            ->when($sort_order,
                function ($query) use ($sort_order) {
                    list($sort, $order) = explode('|', $sort_order);
                    $query->orderBy($sort, $order);
                },
                function ($query) {
                    $query->orderBy('id', 'desc');
                })
            ->paginate(10);

        // 查询评论总量和已评论量和可刷评论量
        foreach ($apps as $app) {
            $app->comment_total   = Comment::getCommentTotalByAppId($app->id);
            $app->commented_count = BrushComment::countCommentedByAppId($app->id);
            $app->useful_count    = $app->comment_total - $app->commented_count;
        }

        $app = new App;

        //搜索参数
        $searchParams = compact('appid', 'app_name', 'is_brushing', 'ssid', 'keyword', 'id', 'ord', 'has_brush_num');

        return view('home/app/index', [
            'apps'         => $apps,
            'app'          => $app,
            'searchParams' => $searchParams,
            'sort_order'   => $sort_order,
        ]);
    }

    // 验证输入
    private function _validate($request)
    {
        $this->validate($request, [
            'App.appid'           => 'required|integer',
            'App.app_name'        => 'required',
            'App.bundle_id'       => 'required',
            'App.process_name'    => 'required',
            'App.brush_num'       => 'required|integer',
            'App.ssid'            => 'required',
            'App.keyword'         => 'required',
            // 'App.is_brushing'     => 'required',
            'App.last_start_rank' => 'required',
            'App.ord'             => 'required',
        ], [], [
            'App.appid'           => 'appid',
            'App.app_name'        => '应用名称',
            'App.keyword'         => '关键词',
            'App.bundle_id'       => 'bundle_id',
            'App.process_name'    => '进程名',
            'App.ssid'            => 'ssid',
            // 'App.is_brushing'     => '是否在刷',
            'App.brush_num'       => '剩余数量',
            'App.last_start_rank' => '开刷前排名',
            'App.ord'             => '优先级',
        ]);
    }
}
