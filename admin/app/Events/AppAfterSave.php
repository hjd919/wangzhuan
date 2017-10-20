<?php

namespace App\Events;

use App\App;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AppAfterSave
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $app;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(App $app)
    {
        // 定义事件的属性
        $this->app = $app;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
