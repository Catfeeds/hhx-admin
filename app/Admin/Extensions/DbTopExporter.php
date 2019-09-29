<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/9/26
 * Time : 10:07
 */

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Str;

class DbTopExporter extends ExcelExporter implements FromQuery, WithMapping
{
    protected $fileName = 'DbTop250.xlsx';
    protected $columns = [
        'no'      => '编号',
        'c_title'   => '中文名',
        'w_title' => '外文名',
        'year' => '年',
        'rating_num' => '评分',
        'inq' => 'inq',
        'director' => '主演',
        'screen_writer' => '编剧',
        'actor' => '演员',
        'type' => '类型',
        'time_long' => '时长',
        'release_date' => '上映日期',
        'intro' => '简介',
    ];
    public function query()
    {
        $columns = array_keys($this->columns);
        $eagerLoads = array_keys($this->getQuery()->getEagerLoads());

        $columns = collect($columns)->reject(function ($column) use ($eagerLoads) {
            return Str::contains($column, '.') || in_array($column, $eagerLoads);
        });

        $conditions = $this->grid->getFilter()->conditions();
        $conditions[] = ['where' => ['status', 0]];
        $this->grid->model()->addConditions($conditions);
        return $this->getQuery()->select($columns->toArray());
    }


    public function map($db): array
    {

        return [
           'No'.$db->no,
            $db->c_title,
            $db->w_title,
            $db->year,
            $db->rating_num,
            $db->inq,
            $db->director,
            $db->screen_writer,
            $db->actor,
            $db->type,
            $db->time_long,
            $db->release_date,
            $db->intro,
        ];
    }
}