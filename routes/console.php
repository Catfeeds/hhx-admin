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
\Illuminate\Support\Facades\Artisan::command('damai', function () {
    \App\Handlers\DamaiHandler::carbonGet();
})->describe('大麦同步');
\Illuminate\Support\Facades\Artisan::command('ctrip', function () {
    \App\Handlers\CtripHandler::getData();
})->describe('携程同步');
\Illuminate\Support\Facades\Artisan::command('daily', function () {
    \App\Handlers\DailyHandler::getData();
})->describe('日报');


