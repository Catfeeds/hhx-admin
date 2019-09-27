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
    $router->post('weibo/sync_data', 'WeiboController@syncData');
    $router->resource('weibos', 'WeiboController');
    $router->resource('hhx', 'HhxController');
    $router->resource('hebe', 'HebeController');
    $router->resource('yyy', 'YyyController');
    $router->resource('mycf', 'MycfController');
    $router->resource('wqf', 'WqfController');
    $router->resource('net_ease', 'NetEaseController');
    $router->resource('csv', 'CsvController');
    $router->resource('weibo_user', 'WeiboUserController');
    $router->post('net_ease/import', 'NetEaseController@import');
    $router->resource('net_ease_hebe', 'NetEaseHebeController');
    $router->resource('net_ease_wqf', 'NetEaseWqfController');
    $router->resource('net_ease_yoga', 'NetEaseYogaController');
    $router->resource('net_ease_jj', 'NetEaseJJController');
    $router->resource('net_ease_eason', 'NetEaseEasonController');
    $router->resource('net_ease_yeung', 'NetEaseYeungController');
    $router->resource('net_ease_she', 'NetEaseSheController');
    $router->resource('travil', 'TravilController');
    $router->resource('daily', 'DailyController');
    $router->resource('interest', 'InterestController');
    $router->resource('interest_log', 'InterestLogController');
    $router->resource('direction', 'directionController');
    $router->resource('direction_log', 'directionLogController');
    $router->resource('flight', 'FlightController');
    $router->resource('direction_week', 'DirectionWeekController');
    $router->resource('to_do_list', 'ToDoListController');
    $router->resource('db_top', 'DbTopController');
    $router->resource('travil_traffic', 'TravilTrafficController');
    $router->resource('travil_bill', 'TravilBillController');
    $router->resource('hhx_travil', 'HhxTravilController');
    $router->resource('travil_equip', 'TravilEquipController');

});
