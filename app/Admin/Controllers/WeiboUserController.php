<?php

namespace App\Admin\Controllers;

use App\Models\WeiboUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class WeiboUserController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $headName = 'WeiBoUser';
    public function index(Content $content)
    {
        return $content
            ->header($this->headName)
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
            ->header($this->headName)
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
            ->header($this->headName)
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
            ->header($this->headName)
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
        $grid = new Grid(new WeiboUser);

        $grid->id('Id');
        $grid->avatar_hd('Avatar hd')->image();
        $grid->cover_image_phone('Cover image phone')->image();
        $grid->description('Description');
        $grid->follow_count('Follow count');
        $grid->followers_count('Followers count');
        $grid->gender('Gender')->using(['f'=>'girl','m'=>'boy']);
        $grid->weibo_id('Weibo id');
        $grid->screen_name('Screen name');
        $grid->statuses_count('Statuses count');
        $grid->status('Status')->select([0=>'new','old']);


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
        $show = new Show(WeiboUser::findOrFail($id));

        $show->id('Id');
        $show->avatar_hd('Avatar hd');
        $show->cover_image_phone('Cover image phone');
        $show->description('Description');
        $show->follow_count('Follow count');
        $show->followers_count('Followers count');
        $show->gender('Gender');
        $show->weibo_id('Weibo id');
        $show->mbrank('Mbrank');
        $show->mbtype('Mbtype');
        $show->screen_name('Screen name');
        $show->statuses_count('Statuses count');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->status('Status');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new WeiboUser);

        $form->text('avatar_hd', 'Avatar hd');
        $form->text('cover_image_phone', 'Cover image phone');
        $form->text('description', 'Description');
        $form->text('follow_count', 'Follow count');
        $form->text('followers_count', 'Followers count');
        $form->text('gender', 'Gender');
        $form->text('weibo_id', 'Weibo id');
        $form->number('mbrank', 'Mbrank');
        $form->number('mbtype', 'Mbtype');
        $form->text('screen_name', 'Screen name');
        $form->number('statuses_count', 'Statuses count');
        $states = [
            'on'  => ['value' => 0, 'text' => 'new', 'color' => 'primary'],
            'off' => ['value' => 1, 'text' => 'old', 'color' => 'default'],
        ];
        $form->select('status', 'Status')->default(0)->options([0=>'new',1=>'old']);

        return $form;
    }
}
