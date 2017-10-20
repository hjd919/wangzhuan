<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 获取菜单
        $navs = config('nav', []);
        View::share('navs', $navs);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
