<?php

namespace App\Http\Controllers\Home;

use App\App;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CommentController extends Controller
{
    public function uploadLog(Request $request)
    {
        $device_id = $request->device_id;
        $data      = $request->data;
        $type      = $request->input('type', 0);

        $res = DB::connection('jishua')->table('brush_comment_log')
            ->insert([
                'device_id' => $device_id,
                'data'      => $data,
                'type'      => $type,
            ]);
        // $storage_dir = storage_path('app/public/brush_logs/' . $device_id); //定义目录
        // $filepath    = $storage_dir . '/' . date('Y_m_d_H_i_s') . '.txt'; //定义文件

        // // 判断文件目录
        // if (!is_dir($storage_dir)) {
        //     mkdir($storage_dir, 0775, 1);
        //     file_put_contents($path, 'data');
        // }

        // // 写入上传的二进制到文件中
        // $res = binary_to_file($filepath);
        if ($res) {
            return die_json('ok');
        } else {
            return die_json('fail', 1);
        }
    }

    public function comment_stat()
    {
        $rows = DB::table('brush_comments')->where('ssid', 'tp')->groupBy('status')
            ->select(DB::Raw('ssid,appid,status,count(status) as count_status'))
            ->get();
        dd($rows);
    }

    // 导入评论
    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);

        $app_id = $request->app_id;

        // 保存文件到服务器
        $path     = $request->file('file')->store('upload_tmp');
        $filepath = public_path('storage') . '/' . $path;

        // 导入excel
        $reader  = Excel::load($filepath);
        $results = $reader->get();

        try {
            DB::beginTransaction();
            $repeat_title = $fail = $success = 0;
            foreach ($results as $key => $row) {

                // 验证excel的数据
                $validator = Validator::make($row->toArray(), [
                    '标题' => 'required',
                    '内容' => 'required',
                ]);
                $errors = $validator->fails();
                if ($errors) {
                    $errors = $validator->errors();
                    Log::error("第" . ($key + 1) . "行---" . $errors->first());
                    throw new \Exception("第" . ($key + 1) . "行---" . $errors->first(), 1);
                    break;
                }

                // 标题判重
                $existComment = Comment::where([
                    'app_id' => $app_id,
                    'title'  => $row->标题,
                ])->first();
                if ($existComment) {
                    Comment::where([
                        'app_id' => $app_id,
                        'title'  => $row->标题,
                    ])->delete();

                    $repeat_title++;

                    // 删除重建，使其id变最新
                    // continue;
                }

                // 添加app
                // 用属性取回app，当结果不存在时实例化一个新实例
                $comment          = new Comment;
                $comment->app_id  = $app_id;
                $comment->title   = $row->标题;
                $comment->content = $row->内容;
                $bool             = $comment->save(); // 更新或者创建数据
                if (!$bool) {
                    $fail++;
                    continue;
                    // throw new \Exception('插入数据库失败', 1);
                    // break;
                }
                $success++;
            }
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            // 删除导入的文件
            unlink($filepath);

            return redirect()->route('comment.index', [$app_id])->with('error', $e->getMessage());
        }

        // 删除导入的文件
        unlink($filepath);

        // 重置缓存key
        Redis::set("last_comment_id-app_id:{$app_id}", 9999999999);

        return redirect()->route('comment.index', [$app_id])->with('success', '导入结果-成功:' . $success . '条,失败:' . $fail . ',已打过评论:' . $repeat_title . '条');
    }

    // 列表
    public function index(Request $request, $app_id)
    {

        // return $this->exportlala(30);
        // 输入
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
        $comments = Comment::where('app_id', $app_id)
        // 搜索条件
            ->when($app_name, function ($query) use ($app_name) {
                return $query->where('app_name', 'like', "%{$app_name}%");
            })
            ->when(null !== $is_brushing,
                function ($query) use ($is_brushing) {
                    return $query->where('is_brushing', $is_brushing);
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

        //搜索参数
        $searchParams = compact('app_name', 'is_brushing', 'ssid', 'keyword', 'id', 'ord', 'has_brush_num');

        // app
        $app = App::where('id', $app_id)->first();

        return view('home/comment/index', [
            'app'          => $app,
            'comments'     => $comments,
            'searchParams' => $searchParams,
            'sort_order'   => $sort_order,
        ]);
    }

    // 统计某个应用的评论每天刷的数据情况
    public function statistics(Request $request, $appid = null)
    {
        $appid  = $request->appid ?: $appid;
        $status = $request->status;

        $app_name = '全部';
        if ($appid) {
            $app_name = App::where('appid', $appid)->value('app_name');
        }

        $statistics = DB::table('brush_comments')
            ->when($appid, function ($query) use ($appid) {
                return $query->where('appid', $appid);
            })
            ->when(null !== $status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->select(DB::raw('date(create_time) as create_date,appid,status,count(*) as comment_count'))
            ->groupBy('create_date', 'appid', 'status')
            ->orderBy('id', 'desc')
            ->simplePaginate(10);

        foreach ($statistics as $row) {
            if ($appid) {
                $row->app_name = $app_name;
            } else {
                $row->app_name = App::where('appid', $row->appid)->value('app_name');
            }
        }

        $comment = new Comment;

        $searchParams = compact('appid', 'status');

        return view('home/comment/statistics', [
            'comment'      => $comment,
            'app_name'     => $app_name,
            'statistics'   => $statistics,
            'searchParams' => $searchParams,
        ]);
    }

    // 统计某个应用的评论每天刷的数据情况
    public function statistics2(Request $request, $appid = null)
    {
        $appid  = $request->appid ?: $appid;
        $status = $request->status;

        if (!$appid) {
            die('请输入appid-url:http://jishua.yz210.com/comment/stat/{appid}');
        }
        $app_name = App::where('appid', $appid)->value('app_name');

        $statistics = DB::table('brush_comments')
            ->where('ssid', 'tp')
            ->when($appid, function ($query) use ($appid) {
                return $query->where('appid', $appid);
            })
            ->when(null !== $status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->select(DB::raw('date(create_time) as create_date,appid,status,count(*) as comment_count'))
            ->groupBy('create_date', 'appid', 'status')
            ->orderBy('id', 'desc')
            ->simplePaginate(10);
        if ($statistics->isEmpty()) {
            die('没有该app数据');
        }

        foreach ($statistics as $row) {
            if ($appid) {
                $row->app_name = $app_name;
            } else {
                $row->app_name = App::where('appid', $row->appid)->value('app_name');
            }
        }

        $comment = new Comment;

        $searchParams = compact('appid', 'status');

        return view('home/comment/statistics2', [
            'comment'      => $comment,
            'app_name'     => $app_name,
            'statistics'   => $statistics,
            'searchParams' => $searchParams,
        ]);
    }
}
