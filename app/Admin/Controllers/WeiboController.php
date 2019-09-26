<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\SyncWeibo;
use App\Handlers\WeiboHandler;
use App\Models\Weibo;
use App\Http\Controllers\Controller;
use App\Models\WeiboPics;
use App\Models\WeiboUser;
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
    protected $fileName = 'WB';
    public function index(Content $content)
    {
        return $content
            ->header($this->fileName)
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
            ->header($this->fileName)
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
            ->header($this->fileName)
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
            ->header($this->fileName)
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
        $grid->screen_name('微博用户名')->modal('用户信息', function ($model) {
            $user = WeiboUser::where('weibo_id',$model->weibo_id)->select('screen_name','description','follow_count',
                'followers_count', 'gender','statuses_count' ,'avatar_hd' )->first()->toArray();
            if($user['gender'] == 'm'){
                $user['gender'] ='boy';
            }else{
                $user['gender'] ='girl';
            }
            $user['avatar_hd'] = '<img src=" '.env('APP_URL')."/uploads/".$user["avatar_hd"].'">';
            return new Table(['key', 'value'], $user);
        });
        $grid->column('text')->display(function () {
            return $this->text;
        });
        $grid->thumbnail_pic('缩略图')->image();

        $grid->pic_num('pic_num')->modal('多图', function ($model) {
            if($model->pic_num >1){
                unset($data_u);
                $num = 0;
                $pics = WeiboPics::where('weibo_info_id',$model->weibo_info_id)->select('url')->get();
                foreach ($pics as $pic){
                    $num ++;
                    $data_u[$num] = '<img src=" '.env('APP_URL')."/uploads/".$pic->url.'">';
                }
            }elseif($model->pic_num ==1){
                $data_u['1'] = '<img src=" '.env('APP_URL')."/uploads/".$model->thumbnail_pic .'">';
            }
            else{
                $data_u['pic'] = '一张图片都没有';
            }
            return new Table(['key', 'value'], $data_u);
        });
        $grid->source('来源');
        $grid->weibo_created_at('Weibo发布时间');
        $grid->comments_count('评论个数');
        $grid->attitudes_count('点赞个数');
        $grid->reposts_count('转发个数');
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
        $grid->tools(function ($tools) {
            $tools->append(new SyncWeibo());
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
        $show = new Show(Weibo::findOrFail($id));

        $show->id('Id');
        $show->screen_name('微博用户名');
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

    public function syncData(){
        WeiboHandler::getData();
    }
}
