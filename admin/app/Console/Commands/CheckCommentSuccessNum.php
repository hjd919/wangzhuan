<?php

namespace App\Console\Commands;

use App\App;
use App\BrushComment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckCommentSuccessNum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:comment-success-num';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Log::error("'handle check:comment-success-num");
        // 获取app:在跑且剩余量为0
        $app_rows = App::where([
            'comment_brush_num'   => 0,
            'comment_is_brushing' => 1,
        ])->get();

        foreach ($app_rows as $app_row) {

            // 统计这个app的有效量：app_id,app时间段,有效
            $valid_num = BrushComment::where([
                ['app_id', '=', $app_row->id],
                ['create_time', '>=', $app_row->comment_start_time],
                ['create_time', '<', $app_row->comment_end_time],
                ['status', '=', 0],
            ])->count();

            $unsuccess_num = $app_row->success_comment_num - $valid_num;
            // Log::error("'diff num'-unsuccess_num:{$unsuccess_num},valid_num:{$valid_num}app_id:{$app_row->id}");
            if ($unsuccess_num > 0) {
                Log::error("'make up num'-unsuccess_num:{$unsuccess_num},app_id:{$app_row->id}");
                App::where('id', $app_row->id)->update(
                    ['comment_brush_num' => $unsuccess_num]
                );
            }
        }
        // find check apps: comment_brush_num=0 and comment_is_brushing
        // check if is finish count brush_comments:status=0
        //  if has unfinish success , incr diff num
    }
}
