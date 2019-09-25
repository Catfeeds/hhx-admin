<?php

namespace App\Admin\Controllers;

use App\Models\DbTop;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class DbTopController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = '豆瓣Top250';
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
        $grid = new Grid(new DbTop);

        $grid->id('Id');
        $grid->no('No');
        $grid->img('Img');
        $grid->c_title('C title');
        $grid->w_title('W title');
        $grid->rating_num('Rating num');
        $grid->inq('Inq');
        $grid->comment_num('Comment num');
        $grid->url('Url');
        $grid->director('Director');
        $grid->screen_writer('Screen writer');
        $grid->actor('Actor');
        $grid->type('Type');
        $grid->time_long('Time long');
        $grid->release_date('Release date');
        $grid->intro('Intro');
        $grid->status('Status');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->year('Year');

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
        $show = new Show(DbTop::findOrFail($id));

        $show->id('Id');
        $show->no('No');
        $show->img('Img');
        $show->c_title('C title');
        $show->w_title('W title');
        $show->rating_num('Rating num');
        $show->inq('Inq');
        $show->comment_num('Comment num');
        $show->url('Url');
        $show->director('Director');
        $show->screen_writer('Screen writer');
        $show->actor('Actor');
        $show->type('Type');
        $show->time_long('Time long');
        $show->release_date('Release date');
        $show->intro('Intro');
        $show->status('Status');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->year('Year');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new DbTop);

        $form->number('no', 'No');
        $form->image('img', 'Img');
        $form->text('c_title', 'C title');
        $form->text('w_title', 'W title');
        $form->text('rating_num', 'Rating num');
        $form->text('inq', 'Inq');
        $form->text('comment_num', 'Comment num');
        $form->url('url', 'Url');
        $form->text('director', 'Director');
        $form->text('screen_writer', 'Screen writer');
        $form->text('actor', 'Actor');
        $form->text('type', 'Type');
        $form->text('time_long', 'Time long');
        $form->text('release_date', 'Release date');
        $form->text('intro', 'Intro');
        $form->number('status', 'Status');
        $form->text('year', 'Year');

        return $form;
    }
}
