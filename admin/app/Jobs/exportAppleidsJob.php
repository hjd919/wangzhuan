<?php

namespace App\Jobs;

use App\Email;
use App\ExportAppleidLog;
use App\Mail\AppleidFileMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class exportAppleidsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数
     *
     * @var int
     */
    public $tries = 1;

    /**
     * 任务运行的超时时间。
     *
     * @var int
     */
    public $timeout = 600;

    protected $total_num;
    protected $user_email;
    protected $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($total_num, $user_email, $user_id)
    {
        $this->total_num  = $total_num;
        $this->user_email = $user_email;
        $this->user_id    = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $total_num = $this->total_num;

        $before_export = Email::where('is_valid', 1)->count(); // 导出前的appleid数

        // 函数-导出num个邮箱
        $export_max_emails = function ($num, $file) {
            $where = ["is_valid" => 1];

            // 判断是否有那么多邮箱
            $total = Email::where($where)->count();
            if ($total < $num) {
                logger('暂时没有' . $num . '条账号了，当前只有' . $total . '可导出');
                return 0;
            }

            // 获取num个邮箱
            $rows = Email::where($where)
                ->select('id', 'email', 'appleid_password', 'reg_info')
                ->limit($num)
                ->get();
            if ($rows->isEmpty()) {
                return 0;
            }

            $success     = $fail     = 0;
            $export_time = date('Y-m-d H:i:s');

            foreach ($rows as $key => $row) {
                // 更新为127
                Email::where('id', $row->id)
                    ->update([
                        'is_valid'           => 127,
                        'active_report_time' => $export_time,
                    ]);
                unset($row->id);
                fputcsv($file, $row->toArray());
            }

            return $key + 1;
        };

        $num = $total_num;

        // $each_num = 2;
        $each_num = 1000; // 每次获取数量
        $success  = 0;

        // Storage::makeDirectory($directory); // 创建那个

        $filepath = storage_path('app/export_emails/appleid_' . date('YmdH') . '_' . $num . '.csv'); // 保存的文件路径
        $file     = fopen($filepath, 'a');

        //每10000个一个文件
        while ($num / $each_num > 1) {
            $success += $export_max_emails($each_num, $file);
            logger("正在获取{$success}");
            $num -= $each_num;
        }
        // 导出剩余的num
        $success += $export_max_emails($num, $file);

        fclose($file);

        $after_export = Email::where('is_valid', 1)->count(); // 导出后的appleid数

        // 记录导出日志
        $export_appleid_log                = new ExportAppleidLog;
        $export_appleid_log->export_number = $total_num;
        $export_appleid_log->user_id       = $this->user_id;
        $export_appleid_log->before_export = $before_export;
        $export_appleid_log->after_export  = $after_export;
        $export_appleid_log->save();

        // 把appleid文件发邮件
        Mail::to($this->user_email)
            ->cc('297538600@qq.com')
            ->send(new AppleidFileMail($filepath)); // 发送邮件-附件
    }
}
