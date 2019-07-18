<?php

namespace App\Admin\Controllers;

use App\Models\Weibo;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class WeiboController extends Controller
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
        $grid = new Grid(new Weibo);
        $grid->model()->where('is_flag', '=', 0);
        $grid->id('Id');
        $grid->screen_name('微博用户名');
        $grid->column('text')->display(function () {
            return $this->text;
        });
        $grid->thumbnail_pic('缩略图')->image();
        $grid->source('来源');
        $grid->weibo_created_at('Weibo发布时间');
        $grid->comments_count('评论个数');
        $grid->attitudes_count('点赞个数');
        $grid->reposts_count('转发个数');
//        $grid->scheme('微博链接');
        $grid->column('repost_id')->expand(function ($model) {
            if($model->repost_id){
                $weibo = Weibo::where('id',$model->repost_id)->first()->toArray();
                $wb = [
                    'id' =>$weibo['id'],
                    'weibo用户名' =>$weibo['screen_name'],
                    'text' =>$weibo['text'],
                    'weibo_created_at' =>$weibo['weibo_created_at'],
                    'comments_count' =>$weibo['comments_count'],
                    'attitudes_count' =>$weibo['attitudes_count'],
                    'reposts_count' =>$weibo['reposts_count'],

                ];
                return new Table(['key','value'], $wb);
            }
        });
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
        $show = new Show(Weibo::findOrFail($id));

        $show->id('Id');
        $show->screen_name('微博用户名');
//        $show->text('内容');
        $show->text('text')->unescape();
        $show->thumbnail_pic('缩略图')->image();
        $show->original_pic('pic')->image();
        $show->source('来源');
        $show->weibo_created_at('Weibo发布时间');
        $show->comments_count('评论个数');
        $show->attitudes_count('点赞个数');
        $show->reposts_count('转发个数');
        $show->scheme('微博链接');
        $show->is_flag('是否转发')->using([0=>'原创',1=>'转发']);
        $show->repost_id('转发的 id');
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
        $form = new Form(new Weibo);

        $form->text('screen_name', 'Screen name');
        $form->textarea('text', 'Text');
        $form->text('thumbnail_pic', 'Thumbnail pic');
        $form->text('original_pic', 'Original pic');
        $form->text('source', 'Source');
        $form->text('weibo_created_at', 'Weibo created at');
        $form->number('comments_count', 'Comments count');
        $form->number('attitudes_count', 'Attitudes count');
        $form->number('reposts_count', 'Reposts count');
        $form->text('scheme', 'Scheme');
        $form->number('is_flag', 'Is flag');
        $form->number('repost_id', 'Repost id');

        return $form;
    }
}
