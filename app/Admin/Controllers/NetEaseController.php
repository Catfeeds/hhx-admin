<?php

namespace App\Admin\Controllers;

use App\Models\NetEase;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class NetEaseController extends Controller
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
        $grid = new Grid(new NetEase);

        $grid->id('Id');
        $grid->singNo('SingNo');
        $grid->songNo('SongNo');
        $grid->singName('SingName');
        $grid->songUrl('SongUrl');
        $grid->songLyric('SongLyric');
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
        $show = new Show(NetEase::findOrFail($id));

        $show->id('Id');
        $show->singNo('SingNo');
        $show->songNo('SongNo');
        $show->singName('SingName');
        $show->songUrl('SongUrl');
        $show->songLyric('SongLyric');
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
        $form = new Form(new NetEase);

        $form->text('singNo', 'SingNo');
        $form->text('songNo', 'SongNo');
        $form->text('singName', 'SingName');
        $form->text('songUrl', 'SongUrl');
        $form->text('songLyric', 'SongLyric');

        return $form;
    }
}
