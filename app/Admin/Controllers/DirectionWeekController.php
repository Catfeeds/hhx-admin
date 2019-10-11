<?php

namespace App\Admin\Controllers;

use App\Models\Direction;
use App\Http\Controllers\Controller;
use App\Models\DirectionLog;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use Encore\HhxEchart\HhxEchart;

class DirectionWeekController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('本周账单')
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Direction);
        $grid->name('Name');
        $week_again = date("Y-m-d",strtotime("this week"));
        $grid->id('本周')->display(function ($id)use($week_again){
            return DirectionLog::whereBetween('created_at',[$week_again,Carbon::now()])->where('direction_id',$id)->sum('money');
        });
        $grid->column('列表详情')->modal(function ()use($week_again){
            $data =  DirectionLog::whereBetween('created_at',[$week_again,Carbon::now()])->where('direction_id',$this->id)->select('illustration','money','created_at')->get()->toArray();
            return  new Table(['说明','金额','创建时间'],$data);
        });
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
        });
        $grid->disableCreateButton();
        $grid->disableRowSelector();

        return $grid;
    }

//    public function weekLine(Content $content){
//        return $content->header('echarts')
//            ->row(function (Row $row) {
//                $row->column(6, function (Column $column) {
//                    $data = DirectionLog::getData(1);
//                    $dt =[];
//                    foreach ($data as $k=>$da){
//                        $d['name'] = $k;
//                        $d['value'] = $da;
//                        $dt[] = $d;
//                    }
//                    $chartData = [
//                        'title' => '本周花销',
//                        'legends' => array_key($data),
//                        'seriesName' => '占比',
//                        'seriesData' => $dt
//                    ];
//                    $options = [
//                        'chartId' => 6,
//                        'height' => '500px',
//                        'chartJson' => json_encode($chartData)
//                    ];
//                    $column->row(new Box('饼状图', HhxEchart::pie($options)));
//                });
//            });
//    }
}
