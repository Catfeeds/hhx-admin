<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('damai', 'DamaiController');
    $router->resource('ctrip', 'CtripController');
    $router->post('ctrip/sync_data', 'CtripController@syncData');
    $router->post('damai/sync_data', 'DamaiController@syncData');
    $router->resource('weibos', 'WeiboController');
    $router->resource('hhx', 'HhxController');
    $router->resource('hebe', 'HebeController');
    $router->resource('yyy', 'YyyController');
    $router->resource('mycf', 'MycfController');

});
