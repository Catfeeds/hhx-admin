<?php

namespace App\Admin\Controllers;

use App\Models\DirectionLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

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
        $grid->ok('Ok');
        $grid->illustration('Illustration');
        $grid->money('Money');
        $grid->week_day('Week day');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show->status('Status');
        $show->ok('Ok');
        $show->illustration('Illustration');
        $show->money('Money');
        $show->week_day('Week day');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

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

        $form->number('direction_id', 'Direction id');
        $form->number('daily_id', 'Daily id');
        $form->number('status', 'Status');
        $form->number('ok', 'Ok');
        $form->text('illustration', 'Illustration');
        $form->decimal('money', 'Money')->default(0.00);
        $form->number('week_day', 'Week day');

        return $form;
    }
}
