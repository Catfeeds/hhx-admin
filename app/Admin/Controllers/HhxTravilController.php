<?php

namespace App\Admin\Controllers;

use App\Models\HhxTravil;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class HhxTravilController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = 'HhxTravil';
    public function index(Content $content)
    {
        return $content
            ->header($this->commName)
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
            ->header($this->commName)
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
            ->header($this->commName)
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
            ->header($this->commName)
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
        $grid = new Grid(new HhxTravil);

        $grid->id('Id');
        $grid->name('名字');
        $grid->topic('主题');
        $grid->money('总金额');
        $grid->days('总天数');
        $grid->nums('总人数');
        $grid->status('状态')->select([0=>"想法",1=>"准备",2=>"未出发",3=>"已出发",4=>"已结束"]);
        $grid->travil_start('出发日期');
        $grid->travil_end('结束日期');
        $grid->rating_num('打分');
        $grid->created_at('创建日期');
        $grid->updated_at('更新日期');
        $grid->tools(function ($tools) {
            $url ='/admin/travil_traffic/create';
            $str = '<a href='.$url.'><button type="button" class="btn btn-info">Traffic</button></a>';
            $url2 = '/admin/travil_bill/create';
            $str2 = '<a href='.$url2.'><button type="button" class="btn btn-success">Bill</button></a>';
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
        $show = new Show(HhxTravil::findOrFail($id));

        $show->id('Id');
        $show->name('名字');
        $show->topic('主题');
        $show->money('总金额');
        $show->days('总天数');
        $show->nums('总人数');
        $show->status('状态')->using([0=>"想法",1=>"准备",2=>"未出发",3=>"已出发",4=>"已结束"]);;
        $show->travil_start('出发日期');
        $show->travil_end('结束日期');
        $show->rating_num('打分');
        $show->created_at('创建日期');
        $show->updated_at('更新日期');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new HhxTravil);

        $form->text('name', '名字');
        $form->text('topic', '主题');
        $form->decimal('money', '总金额')->default(0.00);
        $form->number('days', '总天数')->default(0);
        $form->number('nums', '总人数')->default(0);
        $form->editor('note');
        $form->select('status', '状态')->options([0=>"想法",1=>"准备",2=>"未出发",3=>"已出发",4=>"已结束"])->default(0);
        $form->date('travil_start', '出发日期')->default(date('Y-m-d'));
        $form->date('travil_end', '结束日期')->default(date('Y-m-d'));
        $form->text('rating_num', '打分')->default(0);

        return $form;
    }
}
