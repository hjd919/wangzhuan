<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Support\Util;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function getList(
        Request $request,
        Channel $menuModel
    ) {
        $menus = $menuModel->getList();
        Util::die_json(['menus' => $menus]);
    }
}
