<?php

namespace App\Admin\Controllers;

use App\Models\Daily;
use App\Http\Controllers\Controller;
use App\Models\DirectionLog;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class DailyController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $fileName = '日常';
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
        $grid = new Grid(new Daily);
        $grid->header(function () {
            $week_again = date("Y-m-d",strtotime("this week"));
            $mouth_again = date("Y-m-d",strtotime("this mouth"));
            $week = DirectionLog::whereBetween('created_at',[$week_again,Carbon::now()])->sum('money');
            $mouth = DirectionLog::whereBetween('created_at',[$mouth_again,Carbon::now()])->sum('money');
            return '本周合计:'.$week.',本月合计:'.$mouth;
        });
        $grid->id('Id');
        $grid->Img('每日图片')->image();
        $grid->score('每日打分');
        $grid->collocation('每日搭配')->image();
        $grid->grow_up('每日成长')->limit(30);
        $grid->summary('每日总结')->limit(30);
        $grid->money('每日消费')->modal(function (){
            $data = DirectionLog::where('daily_id',$this->id)->select('illustration','money')->get()->toArray();
            return new Table(['说明','金额'],$data);
        });
        $grid->created_at('创建时间');
//        $grid->updated_at('更新时间');
        $grid->model()->orderBy('id', 'desc');
        $grid->tools(function ($tools) {
            $url ='/admin/direction_log/create';
            $str = '<a href='.$url.'><button type="button" class="btn btn-info">方向Log</button></a>';
            $url2 = '/admin/interest_log/create';
            $str2 = '<a href='.$url2.'><button type="button" class="btn btn-success">兴趣Log</button></a>';
            $tools->append($str);
            $tools->append($str2);
        });
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
        $show = new Show(Daily::findOrFail($id));

        $show->id('Id');
        $show->Img('每日图片')->image();
        $show->score('分数');
        $show->collocation('每日搭配')->image();
        $show->grow_up('每日成长');
        $show->summary('每日总结')->image();
        $show->money('每日消费');
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
        $form = new Form(new Daily);

        $form->image('Img', '每日图片')->uniqueName();
        $form->number('score', '每日打分')->default(5);
        $form->image('collocation', '每日穿搭')->uniqueName();
        $form->text('grow_up', '每日成长');
        $form->text('summary', '每日总结');
        return $form;
    }
}
