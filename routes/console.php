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
\Illuminate\Support\Facades\Artisan::command('dailys', function () {
    \App\Handlers\DailyHandler::getHhx();
})->describe('日报');




