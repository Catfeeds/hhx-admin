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

class SyncCtrip extends AbstractTool
{
    protected function script()
    {
        return <<<EOT
        $("#syn-ctrip-data").click(function (e) {
            $.ajax({
                    method: 'post',
                    url: 'ctrip/sync_data',
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

        return view('admin.tools.syncCtrip');
    }
}