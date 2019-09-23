<?php

namespace App\Admin\Controllers;

use App\Models\ToDoList;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ToDoListController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $fileName ='待办清单';
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
        $grid = new Grid(new ToDoList);

        $grid->id('Id');
        $grid->title('标题');
        $grid->desc('形容')->limit(30);
        $grid->status('状态')->editable(['0'=>'未完成','1'=>'完成']);
        $grid->good_date('最好完成时间');
        $grid->comment('评价')->using(['0'=>'未定义','1'=>'按时完成','2'=>'延长时间']);
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
        $show = new Show(ToDoList::findOrFail($id));

        $show->id('Id');
        $show->title('标题');
        $show->desc('形容');
        $show->status('状态')->using(['0'=>'未完成','1'=>'完成']);
        $show->good_date('最好完成时间');
        $show->comment('评价')->using(['0'=>'未定义','1'=>'按时完成','2'=>'延长时间']);
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
        $form = new Form(new ToDoList);

        $form->text('title', '标题');
        $form->text('desc', '形容');
        $form->select('status', '状态')->options(['0'=>'未完成','1'=>'完成'])->default(0);
        $form->datetime('good_date', '最好完成时间')->default(date('Y-m-d H:i:s'));
        $form->hidden('comment')->default(0);
        $form->saving(function ($form){
            if($form->status == 1){
                if($form->good_date > Carbon::now()){
                    $form->comment = 1;
                }else{
                    $form->comment = 2;
                }
            }
        });
        return $form;
    }
}
