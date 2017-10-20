<?php

namespace App\Observers;

use App\App;
use App\Apps_ready;
use App\Apps_status;

// app观察者
class AppObserver
{
    // 监听修改状态后的事件
    public function updated(App $app)
    {
        logger("监听创建的updated事件");
    }

    // 监听创建或者复制后的事件
    public function updating(App $app)
    {
        logger("监听创建的updating事件");
    }

    // 监听创建或者复制后的事件
    public function created(App $app)
    {
        logger("监听创建的created事件");
    }

    // 监听创建或者复制后的事件
    public function creating(App $app)
    {
        logger("监听创建的creating事件");
    }

    // 监听修改状态后的事件
    public function saved(App $app)
    {
        logger("监听创建的saved事件");

        // 如果是开刷is_brushing=1则重置当前app的is_brushing=0，并添加到准备app队列中
        if (1 == $app->is_brushing) {

            // 重置当前任务为不在刷，is_brushing=0
            App::where('id', $app->id)->update(['is_brushing' => 0]);

            // 删除队列任务
            Apps_ready::where('app_id', $app->id)->delete();

            $apps_ready = [
                'app_id' => $app->id, //创建后才有id,所以放在saved事件里处理
                'ssid'   => $app->ssid,
                'ord'    => $app->ord,
            ];
            // 添加队列任务
            Apps_ready::firstOrCreate($apps_ready);

            // 记录添加任务记录
            $app_status = [
                'app_id'    => $app->id,
                'brush_num' => $app->brush_num,
            ];
            Apps_status::create($app_status);
        }
    }

    // 监听创建或者复制后的事件
    public function saving(App $app)
    {
        logger("监听创建的saving事件");
        if (isset($app->ssid) && is_array($app->ssid)) {
            $app->ssid = join(',', $app->ssid);
        }
    }
}
