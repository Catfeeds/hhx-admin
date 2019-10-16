<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::group([], function (){
//    Route::post('/', '\Controller@')->name('');
//});

Route::any('/texts', 'textController@index');
Route::get('/basic', 'Basic\BasicController@getd');
Route::post('/uploadFiles', 'UploadsController@uploadImg');
Route::get('/top250','Home\DoubanController@top250');
Route::get('/music_top250','Home\DbMusicTopController@top250');
Route::get('/daily','Home\DailyController@index');
Route::get('/daily_week','Home\DailyController@week');
Route::any('/wechat', 'WeChatController@serve');
Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料
        dd($user);
    });
});

