<?php

namespace Encore\HhxEchart;

use Encore\Admin\Extension;

class HhxEchart extends Extension
{
    public $name = 'hhx-echart';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Hhxechart',
        'path'  => 'hhx-echart',
        'icon'  => 'fa-gears',
    ];
}