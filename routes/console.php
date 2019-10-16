<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->describe('Display an inspiring quote');
\Illuminate\Support\Facades\Artisan::command('damais', function () {
    \App\Handlers\DamaiHandler::carbonGet();
})->describe('大麦同步');
\Illuminate\Support\Facades\Artisan::command('ctrips', function () {
    \App\Handlers\CtripHandler::getData();
})->describe('携程同步');
\Illuminate\Support\Facades\Artisan::command('yongle', function () {
    \App\Handlers\YongLeHandler::getData();
})->describe('永乐同步');
\Illuminate\Support\Facades\Artisan::command('dailys', function () {
    \App\Handlers\DailyHandler::getHhx();
})->describe('日报');
\Illuminate\Support\Facades\Artisan::command('daily_week', function () {
    \App\Handlers\DailyHandler::getHhxWeek();
})->describe('周报');
\Illuminate\Support\Facades\Artisan::command('weibos', function () {
    \App\Handlers\WeiboHandler::getData();
})->describe('微博定时任务');
\Illuminate\Support\Facades\Artisan::command('send', function () {
    \App\Handlers\DailyHandler::sendMessage();
})->describe('微博定时任务');




