<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\SyncCtrip;
use App\Handlers\CtripHandler;
use App\Models\Ctrip;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CtripController extends Controller
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
            ->header('Ctrip')
            ->description('携程最低')
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
        $grid = new Grid(new Ctrip);

        $grid->id('Id');
        $grid->depAirportCode('出发机场代码');
        $grid->arrAirportCode('到达机场代码');
        $grid->depAirportName('出发城市');
        $grid->arrAirportName('到达城市');
        $grid->minDate('最低日期');
        $grid->minPrice('最低价格');
        $grid->status('是否爬取?')->display(function ($status) {
            return  $status==1 ? '是' : '否';
        });
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
        $grid->tools(function ($tools) {
            $tools->append(new SyncCtrip());
//            $importButton = <<<EOF
//        <a href="javascript:sync()" class="btn btn-sm btn-info">
//        <i class="fa fa-wrench"></i>同步数据</a>
//EOF;
//            $tools->append($importButton);
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

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Ctrip::findOrFail($id));

        $show->id('Id');
        $show->depAirportCode('出发机场代码');
        $show->arrAirportCode('到达机场代码');
        $show->depAirportName('出发城市');
        $show->arrAirportName('到达城市');
        $show->minDate('最低日期');
        $show->minPrice('最低价格');
        $show->status('状态')->using(['1' => '爬取', '0' => '不爬取']);
//        $show->status('Status');
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
        $form = new Form(new Ctrip);

        $form->text('depAirportCode', '出发机场代码');
        $form->text('arrAirportCode', '到达机场代码');
        $form->text('depAirportName', '出发城市');
        $form->text('arrAirportName', '到达城市');
        $form->text('minPrice', '最低价格');
        $form->radio('status','Status')->options(['0' => '不爬取', '1'=> '爬取'])->default('0');
        return $form;
    }

    public function syncData(){
       CtripHandler::getData();
    }
}
