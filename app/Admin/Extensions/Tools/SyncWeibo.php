<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/17
 * Time : 10:01
 */

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Log;

class SyncWeibo extends AbstractTool
{

    protected function script()
    {
        return <<<EOT
        $("#syn-weibo-data").click(function (e) {
            $.ajax({
                    method: 'post',
                    url: 'weibo/sync_data',
                    data: {
                        _token:LA.token,
                    },
                    success: function () {
                        $.pjax.reload('#pjax-container');
                        toastr.success('操作成功');
                    }
                });
        });

EOT;

    }

    public function render()
    {
        Admin::script($this->script());

        return view('Admin.tools.syncWeibo');
    }
}