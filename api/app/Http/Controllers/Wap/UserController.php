<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserinfo(
        User $userModel,
        Request $request
    ) {
        $userinfo = Auth::user();

        Util::die_json(compact('userinfo'));
    }
}
