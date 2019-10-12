<?php

namespace App\Admin\Controllers;

use App\Models\Yongle;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class YongLeController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commmName = '永乐';
    public function index(Content $content)
    {
        return $content
            ->header($this->commmName)
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
            ->header($this->commmName)
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
            ->header($this->commmName)
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
            ->header($this->commmName)
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
        $grid = new Grid(new Yongle);

        $grid->id('Id');
        $grid->vname('场馆');
        $grid->yname('演唱会名字');
        $grid->status('演唱会状态');
        $grid->performer('演唱人');
        $grid->prices('价格');
        $grid->cityname('城市');
        $grid->enddate('时间');
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
        $show = new Show(Yongle::findOrFail($id));

        $show->id('Id');
        $show->vname('场馆');
        $show->yname('演唱会名字');
        $show->status('演唱会状态');
        $show->performer('演唱人');
        $show->prices('价格');
        $show->cityname('城市');
        $show->enddate('时间');
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
        $form = new Form(new Yongle);

        $form->text('vname', '场馆');
        $form->text('yname', '演唱会名字');
        $form->text('status', '演唱会状态');
        $form->text('performer', '演唱人');
        $form->text('prices', '价格');
        $form->text('cityname', '城市');
        $form->text('enddate', '时间');

        return $form;
    }
}
