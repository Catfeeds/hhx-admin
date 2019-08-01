<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/31
 * Time : 14:12
 */

namespace App\Admin\Extensions;


use Encore\Admin\Grid\Exporters\ExcelExporter;

class WeiboExporter extends ExcelExporter
{
    protected $fileName = 'weibo.xlsx';

    protected $columns = [
        'id'      => 'ID',
        'screen_name'   => '微博用户名',
        'text' => '内容',
        'source' => '来源',
        'weibo_created_at' => '微博发表日期',
        'comments_count' =>'评论数',
        'attitudes_count' => '点赞数',
        'reposts_count' => '转发数',
    ];

}