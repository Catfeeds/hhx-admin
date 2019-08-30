<?php

use Encore\HhxEchart\Http\Controllers\HhxEchartController;

Route::get('hhx-echart', HhxEchartController::class.'@index');