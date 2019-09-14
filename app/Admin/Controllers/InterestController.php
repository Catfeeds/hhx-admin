<?php

namespace App\Admin\Controllers;

use App\Models\Interest;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class InterestController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $fileName = '兴趣';
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
        $grid = new Grid(new Interest);

        $grid->id('Id');
        $grid->name('名字');
        $grid->intro('简述');
        $grid->Img('图片')->image();
        $grid->status('状态')->using(['0'=>'打开','1'=>'关闭']);
        $grid->order_num('排序');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');

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
        $show = new Show(Interest::findOrFail($id));

        $show->id('Id');
        $show->name('名字');
        $show->intro('简述');
        $show->Img('图片')->image();
        $show->status('状态')->using(['0'=>'打开','1'=>'关闭']);
        $show->order_num('排序');
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
        $form = new Form(new Interest);

        $form->text('name', '名字');
        $form->text('intro', '简述');
        $form->image('Img', '图片');
        $form->select('status', '状态')->options(['0'=>'打开','1'=>'关闭']);
        $form->number('order_num', '排序');

        return $form;
    }
}
