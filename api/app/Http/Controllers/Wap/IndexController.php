<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use App\Models\Channel;
use App\Models\Menu;
use App\Support\Util;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function get(
        Request $request,
        Menu $menuModel,
        Carousel $carouselModel,
        Channel $channelModel
    ) {
        $channels = $channelModel->getList();

        $menus = $menuModel->getList();

        $carousels = $carouselModel->getList();

        Util::die_json(compact('channels', 'menus', 'carousels'));
    }

    public function submitFeedback(
        Request $request
    ) {
        $a = $request->all();
        print_r($a);
    }
}
