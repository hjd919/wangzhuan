<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */
$router->group(['middleware' => [], 'namespace' => 'Wap', 'prefix' => 'wap'], function () use ($router) {
    $router->get('/index/get', 'IndexController@get');
    $router->get('/login/wechat', 'LoginController@wechat');
    $router->get('/login/wechat/callback', 'LoginController@wechatCallback');
    $router->get('/login/weibo', 'LoginController@weibo');
    $router->get('/login/weiboCallback', 'LoginController@weiboCallback');

    $router->get('/login/phone', 'LoginController@phone');

    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->get('/user/getUserinfo', 'UserController@getUserinfo');
        $router->post('/feedback/submit', 'IndexController@submitFeedback');
    });
});
