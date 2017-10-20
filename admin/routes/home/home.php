<?php
Route::group(['middleware' => [], 'namespace' => 'Home'], function () {
    Route::post('/comment/uploadLog', 'CommentController@uploadLog');
    Route::get('/comment/stat/{appid?}', 'CommentController@statistics2')->name('comment.statistics2');
});

Route::group(['middleware' => ['web', 'auth', 'home'], 'namespace' => 'Home', 'prefix' => 'home'], function () {
    Route::any('/', 'HomeController@index');

    // comment
    Route::get('/comment/index/{app_id}', 'CommentController@index')->name('comment.index');
    Route::any('/comment/import', 'CommentController@import')->name('comment.import');
    Route::any('/comment/statistics/{appid?}', 'CommentController@statistics')->name('comment.statistics');

    // app
    Route::get('/app/index', 'AppController@index')->name('app.index');
    Route::any('/app/create', 'AppController@create')->name('app.create');
    Route::any('/app/update/{id}', 'AppController@update')->name('app.update');
    Route::any('/app/delete/{id?}', 'AppController@delete')->name('app.delete');
    Route::any('/app/update_is_brushing/{is_brushing}/{id?}'
        , 'AppController@update_is_brushing')->name('app.update_is_brushing');
    Route::any('/app/copy/{id}', 'AppController@copy')->name('app.copy');
    Route::any('/app/ready_list', 'AppController@readyList')->name('app.ready_list');
    Route::any('/app/import', 'AppController@import')->name('app.import');
    Route::any('/app/stat_brush', 'AppController@statBrush')->name('app.stat_brush');

    // config
    Route::get('/config/index', 'ConfigController@index')->name('config.index');
    Route::any('/config/create', 'ConfigController@create')->name('config.create');
    Route::any('/config/update/{id}', 'ConfigController@update')->name('config.update');
    Route::any('/config/delete/{id}', 'ConfigController@delete')->name('config.delete');

    // appleid
    Route::get('/appleid/index', 'AppleidController@index')->name('appleid.index');
    Route::any('/appleid/import_emails', 'AppleidController@importEmails')->name('appleid.import_emails');
    Route::any('/appleid/export_appleids', 'AppleidController@exportAppleids')->name('appleid.export_appleids');
    Route::any('/appleid/add_jishua_appleids', 'AppleidController@addJishuaAppleids')->name('appleid.add_jishua_appleids');

    // user
    Route::get('/user/index', 'UserController@index')->name('user.index');
    Route::any('/user/create', 'UserController@create')->name('user.create');
    // ->middleware('needsPermission:user.create');
    Route::any('/user/update_password/{id}', 'UserController@updatePassword')->name('user.update_password');
    Route::any('/user/attach_role/{id}', 'UserController@attachRole')->name('user.attach_role');
    Route::any('/user/delete/{id}', 'UserController@delete')->name('user.delete');

    // role
    Route::get('/role/index', 'RoleController@index')->name('role.index');
    Route::any('/role/create', 'RoleController@create')->name('role.create');
    Route::any('/role/update/{id}', 'RoleController@update')->name('role.update');
    Route::any('/role/delete/{id}', 'RoleController@delete')->name('role.delete');

    // permission
    Route::get('/permission/index', 'PermissionController@index')->name('permission.index');
    Route::any('/permission/create', 'PermissionController@create')->name('permission.create');
    Route::any('/permission/update/{id}', 'PermissionController@update')->name('permission.update');
    Route::any('/permission/delete/{id}', 'PermissionController@delete')->name('permission.delete');
    Route::any('/permission/import', 'PermissionController@import')->name('permission.import');
});
