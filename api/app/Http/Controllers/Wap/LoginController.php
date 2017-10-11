<?php

namespace App\Http\Controllers\Wap;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function wechat()
    {
        return Socialite::with('weixin')->stateless()->redirect();
    }

    public function wechatCallback(User $userModel)
    {
        $user = Socialite::with('weixin')->user();
        // Log::info('用户信息' . var_export($user, true));
        if (empty($user) || empty($user->user)) {
            return response()->json(['授权失败,请重试']);
        }
        $userinfo = $user->user;
        // Log::info('用户信息1' . var_export($userinfo, true));

        // 判断是否新用户
        $openid = $userinfo['openid'];
        $user   = $userModel->isNew($openid);
        if (!$user) {
            Log::info('新用户，添加用户');

            // 新用户，添加用户
            $userdata = [
                'user_name' => $userinfo['nickname'],
                'nickname'  => $userinfo['nickname'],
                'openid'    => $openid,
                'sex'       => $userinfo['sex'],
                'province'  => $userinfo['province'],
                'city'      => $userinfo['city'],
                'avatar'    => $userinfo['headimgurl'],
            ];
            // Log::info(var_export($userdata, true));
            $user = $userModel->add($userdata);
            Log::info('新 $user');
            Log::info(var_export($user, true));
        } else {
            Log::info('旧 $user');
            Log::info(var_export($user, true));
        }
        Log::info('server-get');
        Log::info(var_export($_GET, true));
        return '';
        // 登录
        // $token = JWTAuth::fromUser($user);

        // 跳转到首页 - 192.168.230.xxx
        // return redirect('http://192.168.230.230:3000?token=' . $token);
    }
}
