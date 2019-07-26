<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class CsvExporter extends AbstractExporter
{
    protected $fields;

    public function __construct($fields = [])
    {
        parent::__construct();
        $this->fields = $fields;
        ini_set('memory_limit','2048M');
        ini_set('max_execution_time',3600);
    }

    public function export()
    {
        $filename = $this->getTable();


        Excel::create($filename, function (LaravelExcelWriter $excel) {

            $excel->sheet('sheet1', function (LaravelExcelWorksheet $sheet) {

                $rows = collect($this->getData());
                $rows->transform(function ($datum) {
                    $item = $datum;
                    if (!empty($this->fields)) $item = array_only($datum, array_keys($this->fields));
                    if (array_has($datum, 'json')) {
                        //包含json字段时,恢复附属字段
                        $json = json_decode($datum['json'], true);
                        $item = array_merge($json, $item);
                        array_forget($item, 'json');
                    }
                    return $item;
                });
                $sheet->rows($rows);
                if ($rows->count() > 0) $sheet->prependRow(array_keys($rows->first()));

            });

        })->export('csv');
    }
}