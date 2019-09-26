<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\DbTopExporter;
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
        $grid->no('编号')->display(function ($no){
            return 'No.'.$no;
        });
        $grid->img('封面')->image();
        $grid->c_title('中文名');
        $grid->w_title('英文名');
        $grid->year('年');
        $grid->rating_num('评分')->sortable();
        $grid->inq('Inq');
        $grid->comment_num('评论数');
        $grid->director('导演');
//        $grid->screen_writer('编剧')->limit(30);
        $grid->actor('主演');
        $grid->time_long('时长');
        $grid->status('状态')->select(['0'=>'未看','1'=>'已看','2'=>'不感兴趣']);
        $grid->filter(function($filter){
            // 在这里添加字段过滤器
            $filter->like('c_title', '中文名');
            $filter->like('year', '年');
        });
        $grid->actions(function ($actions) {
            // 去掉删除
            $actions->disableDelete();
            // 去掉编辑
            $actions->disableEdit();
        });
        $grid->disableCreateButton();
        $grid->disableRowSelector();
        $grid->exporter(new DbTopExporter());

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
        $show->no('编号')->display(function ($no){
            return 'No.'.$no;
        });
        $show->img('封面');
        $show->c_title('中文名');
        $show->w_title('英文名');
        $show->rating_num('评分');
        $show->inq('Inq');
        $show->comment_num('评论数');
        $show->url('Url');
        $show->director('导演');
        $show->screen_writer('编剧');
        $show->actor('主演');
        $show->type('类型');
        $show->time_long('时长');
        $show->release_date('上映日期');
        $show->intro('简介');
        $show->status('状态');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');
        $show->year('年份');

        return $show;
    }


}
