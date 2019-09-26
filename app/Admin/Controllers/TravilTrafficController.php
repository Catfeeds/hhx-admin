<?php

namespace App\Admin\Controllers;

use App\Models\Daily;
use App\Models\DirectionLog;
use App\Models\HhxTravil;
use App\Models\TravilTraffic;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class TravilTrafficController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = '旅行交通';
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
        $grid = new Grid(new TravilTraffic);

        $grid->id('Id');
        $grid->img('图片')->image();
        $grid->name('名字');
        $grid->illustrate('说明');
        $grid->money('金额');
        $grid->ok('Ok')->using([0=>'0k',2=>'bad']);
        $grid->travil_at('旅行时间');
        $grid->status('状态')->using([0=>'未出发',1=>'已出发']);
        $grid->hhx_travil_id('travil id');
        $grid->created_at('创建时间');
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
        $show = new Show(TravilTraffic::findOrFail($id));

        $show->id('Id');
        $show->img('图片');
        $show->name('名字');
        $show->illustrate('说明');
        $show->money('金额');
        $show->ok('Ok')->using([0=>'0k',2=>'bad']);
        $show->travil_at('旅行时间');
        $show->status('状态')->using([0=>'未出发',1=>'已出发']);
        $show->direction_id('Direction id');
        $show->daily_id('Daily id');
        $show->hhx_travil_id('Hhx travil id');
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
        $form = new Form(new TravilTraffic);

        $form->image('img', '图片');
        $form->text('name', '名字');
        $form->text('illustrate', '说明');
        $form->decimal('money', '金额')->default(0.00);
        $form->select('ok', 'Ok')->options([0=>'0k',2=>'bad'])->default(0);
        $form->date('travil_at', '出发时间')->default(date('Y-m-d'));
        $form->select('status', '状态')->options([0=>'未出发',1=>'已出发'])->default(0);
        $data1 = DirectionLog::getIllustration();
        $data1[0] = 0;
        $form->select('direction_id', '方向LogId')->options(key($data1));
        $data = Daily::getTimeDay();
        $data[0] = 0;
        $form->number('daily_id', '日常Id')->options(key($data));
        $form->select('hhx_travil_id', 'Hhx旅行Id')->options(HhxTravil::getName());

        return $form;
    }
}
