<?php
namespace App\Http\Controllers\Home;

use App\App;
use App\Email;
use App\Http\Controllers\Controller;
use App\Jobs\exportAppleidsJob;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class AppleidController extends Controller
{
    // 导出appleids
    public function exportAppleids(Request $request)
    {
        $total_num = $request->export_num;
        if (!$total_num) {
            die('no bb');
        }

        if ($total_num > 100000) {
            die('暂不支持大于10万的导出');
        }
        $user_email = $request->user()->email;
        $user_id    = $request->user()->id;

        // 放到队列处理-导出appleids
        dispatch(new exportAppleidsJob($total_num, $user_email, $user_id));

        return redirect()->back()->with('success', '正在处理中，处理完会发邮件通知');
    }

    public function addJishuaAppleids(Request $request)
    {
        $ssid       = $request->ssid;
        $add_number = $request->add_number;

        // 验证输入
        $this->validate($request, [
            'ssid'       => 'required',
            'add_number' => 'required|integer',
        ]);

        // 更新apps is_valid=ssid[is_valid] => xxx;
        $ssid_is_valid = App::SSID_IS_VALID;
        if (!isset($ssid_is_valid[$ssid])) {
            return redirect()->back()->with('error', '不合法ssid');
        }
        $is_valid = $ssid_is_valid[$ssid]['is_valid'];
        $bool     = Email::where('is_valid', 1)
            ->limit($add_number)
            ->update([
                'is_valid'           => $is_valid,
                'active_report_time' => date('Y-m-d H:i:s'),
            ]);
        logger("添加记录" . var_export($bool, 1));

        Redis::set('emails_offset', 999999999);

        if ($bool) {
            return redirect()->back()->with('success', "添加机刷账号成功：添加ssid--{$ssid}；账号数--{$add_number}；");
        } else {
            return redirect()->back()->with('error', "添加机刷账号失败");
        }
    }

    // 原始email导入
    public function importEmails(Request $request)
    {
        set_time_limit(0);

        $is_valid = $request->is_valid;

        // 上传文件
        $email_file = $request->file('email_file');
        if (!$email_file) {
            return redirect()->back()->with('error', '请选择上传的文件');
        }
        $path     = $email_file->store('upload_tmp');
        $filepath = public_path('storage') . '/' . $path;

        // 导入excel
        $reader  = Excel::load($filepath);
        $results = $reader->get();

        // 获取昵称
        $appleid_total = count($results);

        // 根据最后获取账号数量的昵称
        $last_user_id = Redis::get('last_user_id');
        $last_user_id = (int) $last_user_id;
        $nicknames    = DB::connection('today_task')->table('users')->select('id', 'user_name')->where([
            ['id', '>', $last_user_id],
            ['user_name', '!=', ''],
        ])->limit($appleid_total)->get();
        $nickname_total = count($nicknames); // 查询到的昵称数
        if ($nickname_total < $appleid_total) {
            // 如果昵称不够用了:从0查询重新一遍剩余数，并合并到原来昵称中
            $nicknames2 = DB::connection('today_task')->table('users')->select('id', 'user_name')->where([
                ['id', '>', 0],
                ['user_name', '!=', ''],
            ])->limit($appleid_total - $nickname_total)->get();
            $nicknames = array_merge($nicknames, $nicknames2);
        }
        $last_user_id = $nicknames[$appleid_total - 1]->id;
        Redis::set('last_user_id', $last_user_id); // 设置下一次获取的last_user_id

        if (count($nicknames) != $appleid_total) {
            return redirect()->back()->with('error', '账号数量和昵称数量不正确');
        }
        $i = $j = 0;
        try {
            foreach ($results as $key => $row) {
                $row = $row->toArray();

                // 验证excel的数据
                $validator = Validator::make($row, [
                    '账号' => 'required',
                    '密码' => 'required',
                ]);
                $errors = $validator->fails();
                if ($errors) {
                    $errors = $validator->errors();
                    Log::error("第" . ($key + 1) . "行---" . $errors->first());
                    throw new \Exception("第" . ($key + 1) . "行---" . $errors->first(), 1);
                    break;
                }

                // 排重
                $email_collect = Email::where('email', $row['账号'])->get()->toArray();
                if ($email_collect) {
                    $j++;
                    continue;
                }

                // 构造插入数据
                $i++;
                $password      = trim($row['密码']);
                $insert_data[] = [
                    'is_valid'         => $is_valid,
                    'email'            => trim($row['账号']),
                    'password'         => $password,
                    'appleid_password' => $password,
                    'nickname'         => $nicknames[$key]->user_name,
                    'email_domain'     => '',
                ];

                // 添加app
                if ($key % 100 == 0) {
                    $bool = Email::insert($insert_data);
                    if (!$bool) {
                        throw new \Exception('插入数据库失败', 1);
                        break;
                    }
                    $insert_data = [];
                }
            }
            // 处理剩余的
            if ($insert_data) {
                Email::insert($insert_data);
            }

        } catch (\Exception $e) {

            // 删除导入的文件
            unlink($filepath);

            return redirect()->back()->with('error', $e->getMessage());
        }

        // 删除导入的文件
        unlink($filepath);

        $message = "导入完成--总数:" . ($key + 1) . ",成功:{$i},因重复失败:{$j}";
        return redirect()->back()->with('success', $message);

        // // 导入emails到数据库
        // $data = file($full_filepath);

        // $j           = $i           = 0;
        // $insert_data = [];

        // // $glup        = $glup ?: '----';//分隔符
        // $glup = '----'; //默认分隔符

        // foreach ($data as $key => $d) {
        //     $d = rtrim($d);
        //     if (!$d) {
        //         continue;
        //     }

        //     list($email, $password) = explode($glup, $d);

        //     $email = trim($email);

        //     // 排重
        //     $email_collect = Email::where('email', $email)->get();
        //     if (!$email_collect->isEmpty()) {
        //         $j++;
        //         continue;
        //     } else {
        //         $i++;
        //     }
        //     $insert_data[] = ['is_valid' => 200, 'email' => $email, 'password' => $password, 'email_domain' => '163.com'];

        //     if ($key % 100 == 0) {
        //         $res         = Email::insert($insert_data);
        //         $insert_data = [];
        //     }
        // }

        // // 处理剩余的
        // if ($insert_data) {
        //     $res = Email::insert($insert_data);
        // }

        // $message = "导入完成：总数---" . ($key + 1) . "；成功---{$i}；因重复失败---{$j}";

        // // 删除文件
        // unlink($full_filepath);

    }

    // 首页
    public function index(Request $request)
    {
        // 查询：可注册email数，有效appleid账号数、搜索-时间段，机刷的账号数
        $reg_count     = Email::where('is_valid', 0)->where('try_times', '<=', 2)->count(); // 可注册email数
        $appleid_count = Email::where('is_valid', 1)->count(); // 有效appleid账号数

        $ssid_is_valid = App::SSID_IS_VALID;
        foreach ($ssid_is_valid as $ssid => $row) {
            $is_valid               = $row['is_valid'];
            $jishua_appleids[$ssid] = Email::where('is_valid', $is_valid)->count(); // 有效appleid账号数
        }

        // 已导出的账号
        $export_appleids = Email::where('is_valid', 127)->count();

        // 统计最近一天每时每个状态的数量

        // 搜索参数
        $searchParams = [];
        // 判断时间粒度
        $time_units                = ['时', '日']; //时间粒度
        $searchParams['time_unit'] = $time_unit = $request->input('time_unit', '时');
        if ('时' == $time_unit) {
            $time_groupby = "date_format(valid_time,'%Y-%m-%d %H') hour_time";
        } elseif ('日' == $time_unit) {
            $time_groupby = "date_format(valid_time,'%Y-%m-%d') hour_time";
        }
        // 邮箱状态
        $searchParams['is_valids'] = $is_valids = $request->input('is_valids');
        if ($is_valids) {
            $is_valids  = explode(' ', $is_valids);
            $more_where = "and is_valid in('" . join("','", $is_valids) . "')";
        } else {
            $more_where = '';
        }

        // 列表
        $page     = $request->input('page', 1);
        $perPage  = 10;
        $datetime = date('Y-m-d', strtotime('-7 days'));

        $total_arr = DB::select("select count(count_group) total from
            (select count(id) count_group, {$time_groupby} from emails where valid_time>? {$more_where}
            group by hour_time, is_valid
            ) a", [$datetime]);
        // 获取列表
        $results = Email::select(['*', DB::raw('count(id) total'), DB::raw($time_groupby)])
            ->where('valid_time', '>', $datetime)
            ->when(null !== $is_valids, function ($query) use ($is_valids) {
                return $query->whereIn('is_valid', $is_valids);
            })
            ->groupBy('hour_time')
            ->groupBy('is_valid')
            ->orderBy('hour_time', 'desc')
            ->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();
        $stat_hour_email_list = new LengthAwarePaginator($results, $total_arr[0]->total, $perPage, $page, [
            'path'     => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        $app = new App;

        return view('home/appleid/index', [
            'reg_count'            => $reg_count,
            'appleid_count'        => $appleid_count,
            'app'                  => $app,
            'jishua_appleids'      => $jishua_appleids,
            'export_appleids'      => $export_appleids,
            'stat_hour_email_list' => $stat_hour_email_list,
            'time_units'           => $time_units,
            'searchParams'         => $searchParams,
        ]);
    }
}
