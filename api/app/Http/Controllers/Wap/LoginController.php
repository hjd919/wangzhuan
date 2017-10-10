<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function wechat()
    {
        return Socialite::with('weixin')->stateless()->redirect();
    }
}
