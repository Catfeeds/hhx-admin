<?php

namespace App\Admin\Controllers;

use App\Models\Flight;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class FlightController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $fileName = '飞猪航班';
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
        $grid = new Grid(new Flight);

        $grid->id('Id');
        $grid->depCode('出发机场代码');
        $grid->depName('出发城市');
        $grid->arrName('到达城市');
        $grid->arrCode('到达机场代码');
        $grid->price('价格');
        $grid->priceDesc('价格单元');
        $grid->discount('折扣');
        $grid->depDate('到达日期');
        $grid->priceDesc('价格单元');
        $grid->created_at('创建时间');
        $grid->disableActions();

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
        $show = new Show(Flight::findOrFail($id));

        $show->id('Id');
        $show->arrCode('ArrCode');
        $show->price('Price');
        $show->discount('Discount');
        $show->arrName('ArrName');
        $show->depName('DepName');
        $show->depDate('DepDate');
        $show->priceDesc('PriceDesc');
        $show->depCode('DepCode');
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
        $form = new Form(new Flight);

        $form->text('arrCode', 'ArrCode');
        $form->text('price', 'Price');
        $form->text('discount', 'Discount');
        $form->text('arrName', 'ArrName');
        $form->text('depName', 'DepName');
        $form->text('depDate', 'DepDate');
        $form->text('priceDesc', 'PriceDesc');
        $form->text('depCode', 'DepCode');

        return $form;
    }
}
