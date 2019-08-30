<?php

namespace Encore\HhxEchart\Http\Controllers;

use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;

class HhxEchartController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Title')
            ->description('Description')
            ->body(view('hhx-echart::index'));
    }
}