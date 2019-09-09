<?php

namespace App\Admin\Controllers;

use App\Models\Direction;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class DirectionController extends Controller
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
            ->header('Index')
            ->description('description')
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
            ->header('Detail')
            ->description('description')
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
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Direction);

        $grid->id('Id');
        $grid->name('Name');
        $grid->intro('Intro');
        $grid->Img('Img');
        $grid->status('Status');
        $grid->order_num('Order num');
        $grid->all_num('All num');
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
        $show = new Show(Direction::findOrFail($id));

        $show->id('Id');
        $show->name('Name');
        $show->intro('Intro');
        $show->Img('Img');
        $show->status('Status');
        $show->order_num('Order num');
        $show->all_num('All num');
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
        $form = new Form(new Direction);

        $form->text('name', 'Name');
        $form->text('intro', 'Intro');
        $form->image('Img', 'Img');
        $form->number('status', 'Status');
        $form->number('order_num', 'Order num');
        $form->decimal('all_num', 'All num')->default(0.00);

        return $form;
    }
}
