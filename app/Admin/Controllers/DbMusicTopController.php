<?php

namespace App\Admin\Controllers;

use App\Models\DbMusicTop;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class DbMusicTopController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $commName = '豆瓣音乐Top250';
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
        $grid = new Grid(new DbMusicTop);

        $grid->id('Id');
        $grid->no('No');
        $grid->img('图片')->image();
        $grid->title('标题');
        $grid->sing_name('歌手名');
        $grid->date('日期');
        $grid->album('专辑');
        $grid->cd('Cd');
        $grid->type('类型');
        $grid->star('评分');
        $grid->comment('评论');
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
        $show = new Show(DbMusicTop::findOrFail($id));

        $show->id('Id');
        $show->no('No');
        $show->img('图片')->image();
        $show->title('标题');
        $show->sing_name('歌手名');
        $show->date('日期');
        $show->album('专辑');
        $show->cd('Cd');
        $show->type('类型');
        $show->star('评分');
        $show->comment('评论');
        $show->intro('详情');
        $show->songs('专辑歌曲');
        $show->status('状态');
        $show->pan_code('Pan code');
        $show->pan_url('Pan url');
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
        $form = new Form(new DbMusicTop);

        $form->number('no', 'No');
        $form->image('img', 'Img');
        $form->text('title', 'Title');
        $form->text('sing_name', 'Sing name');
        $form->text('date', 'Date');
        $form->text('album', 'Album');
        $form->text('cd', 'Cd');
        $form->text('type', 'Type');
        $form->text('star', 'Star');
        $form->text('comment', 'Comment');
        $form->textarea('intro', 'Intro');
        $form->textarea('songs', 'Songs');
        $form->number('status', 'Status');
        $form->text('pan_code', 'Pan code');
        $form->text('pan_url', 'Pan url');

        return $form;
    }
}
