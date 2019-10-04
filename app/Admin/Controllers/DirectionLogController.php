<?php

namespace App\Admin\Controllers;

use App\Models\Daily;
use App\Models\Direction;
use App\Models\DirectionLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Encore\HhxEchart\HhxEchart;

class DirectionLogController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $fileName = '方向Log';
    public function index(Content $content)
    {
        return $content
            ->header($this->fileName)
            ->description('列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header($this->fileName)
            ->description('详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header($this->fileName)
            ->description('编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header($this->fileName)
            ->description('创建')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new DirectionLog);
        $grid->id('Id');
        $grid->direction_id('Direction id');
        $grid->daily_id('Daily id');
        $grid->status('状态')->using([0=>'减少',1=>'增加']);
        $grid->ok('Ok')->using([0=>'good',1=>'bad']);
        $grid->illustration('说明');
        $grid->money('金额')->totalRow();
        $grid->week_day('星期几')->using([0=>'星期日',1=>'星期一',2=>'星期二',3=>'星期三',4=>'星期四',5=>'星期五',6=>'星期六']);
        $grid->created_at('创建时间');
//        $grid->updated_at('更新时间');
        $grid->model()->orderBy('id', 'desc');


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(DirectionLog::findOrFail($id));
        $show->id('Id');
        $show->direction_id('Direction id');
        $show->daily_id('Daily id');
        $show->status('状态')->using([0=>'减少',1=>'增加']);
        $show->ok('Ok')->using([0=>'good',1=>'bad']);
        $show->illustration('说明');
        $show->money('金额');
        $show->week_day('星期几')->using([0=>'星期日',1=>'星期一',2=>'星期二',3=>'星期三',4=>'星期四',5=>'星期五',6=>'星期六']);
        $show->created_at('创建时间');
        $show->updated_at('更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DirectionLog);
        $form->select('direction_id', 'Direction id')->options(Direction::getData());
        $form->select('status', 'Status')->options([0=>'减少',1=>'增加']);
        $form->select('ok', 'Ok')->options([0=>'good',1=>'bad']);
        $form->text('illustration', '说明');
        $form->decimal('money', '金额')->default(0.00);
        $form->select('week_day', '星期几')->options([0=>'星期日',1=>'星期一',2=>'星期二',3=>'星期三',4=>'星期四',5=>'星期五',6=>'星期六'])->default(date("w",time( )));
        $data = Daily::getTimeDay();
        $data[0] = 0;
        $form->select('daily_id')->options($data)->default(key($data));
        return $form;
    }


    public function week(Content $content)
    {
        return $content->header('花销分布')
            ->row(function (Row $row) {
                $row->column(6, function (Column $column){
                    $data = DirectionLog::getData(1);
                    $dt =[];
                    foreach($data as$k=> $da){
                        $d['name'] = $k;
                        $d['value'] = $da;
                        $dt[] = $d;
                    }
                    $chartData = [
                        'title' => '本周花销',
                        'legends' => array_keys($data),
                        'seriesName' => '总占比',
                        'seriesData' => $dt
                    ];
                    $options = [
                        'chartId' => 6,
                        'height' => '500px',
                        'chartJson' => json_encode($chartData)
                    ];
                    $column->row(new Box('本周花销', HhxEchart::pie($options)));
                });
            });

        }
}
