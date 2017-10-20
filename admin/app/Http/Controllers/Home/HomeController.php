<?php

namespace App\Http\Controllers\Home;

//控制器
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // for ($i = 0; $i < 50; $i++) {
        //     $res = Redis::delete('a' . $i, $i);
        //     // $res = Redis::delete('a' . $i);
        //     echo $i . '--' . var_dump($res);
        //     echo "<br>";
        // }
        // die;
        return view('home/home');
    }
}
