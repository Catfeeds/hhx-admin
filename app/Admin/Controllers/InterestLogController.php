<?php

namespace App\Admin\Controllers;

use App\Models\Daily;
use App\Models\Interest;
use App\Models\InterestLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class InterestLogController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $fileName = '兴趣Log';
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
        $grid = new Grid(new InterestLog);

        $grid->id('Id');
        $grid->interest_id('Interest id');
        $grid->daily_id('Daily id');
        $grid->illustration('说明');
        $grid->week_day('星期几')->using([0=>'星期日',1=>'星期一',2=>'星期二',3=>'星期三',4=>'星期四',5=>'星期五',6=>'星期六']);
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
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
        $show = new Show(InterestLog::findOrFail($id));

        $show->id('Id');
        $show->interest_id('Interest id');
        $show->daily_id('Daily id');
        $show->illustration('说明');
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
        $form = new Form(new InterestLog);

        $form->select('interest_id', 'Interest id')->options(Interest::getData());
        $form->text('illustration', '说明');
        $form->select('week_day', '星期几')->options([0=>'星期日',1=>'星期一',2=>'星期二',3=>'星期三',4=>'星期四',5=>'星期五',6=>'星期六'])->default(date("w",time( )));
        $data = Daily::getTimeDay();
        $data[0] = 0;
        $form->select('daily_id')->options($data)->default(key($data));
        return $form;
    }
}
