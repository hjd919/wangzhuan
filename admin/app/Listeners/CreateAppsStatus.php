<?php

namespace App\Listeners;

use App\Apps_status;
use App\Events\AppAfterSave;

// 添加app状态日志
class CreateAppsStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AppAfterSave  $event
     * @return void
     */
    public function handle(AppAfterSave $event)
    {
        $app  = $event->app;
        $data = [
            'app_id'       => $app->id,
            'brush_number' => $app->brush_num,
            'start_rank'   => $app->last_start_rank,
        ];
        Apps_status::create($data);

        return true;
    }
}
