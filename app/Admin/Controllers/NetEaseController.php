<?php

namespace App\Admin\Controllers;

use App\Models\NetEase;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use League\Csv\Reader;
use League\Flysystem\Exception;

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
        return
            $content
            ->header('Index')
            ->description('description')
            ->row(view('admin.ImportPopup'))
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
        $grid->tools(function ($tool) {
            $importButton = <<<EOF
        <a href="javascript:initLayer()" class="btn btn-sm btn-info">
        <i class="fa fa-cloud"></i>&nbsp;&nbsp;导入
 </a>
EOF;
            $tool->append($importButton);
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

    /**
     * 导入数据
     * @return array
     */
    public function import()
    {
        ini_set('memory_limit','2048M');
        ini_set('max_execution_time',3600);
        $request = \request();
        $validFields = config('system.app_account.export_fields');
        $file = $request->file('file');
        $items = [];
        dd($file);
        $tableStructure = \DB::select("describe net_eases");
        $tableFields = collect($tableStructure)->pluck('Field')->toArray();

//        字段名黑名单，表结构里有，但配置的白名单里没有，需要过滤
//        $invalidFields = array_diff_key(array_flip($tableFields), $validFields);

        if (!$file->isValid()) {
            return ['status_code' => 10001, 'message' => '上传失败'];
        }
        if (!in_array($file->getMimeType(), ['text/plain'])) {
            return ['status_code' => 10002, 'message' => '请上传csv文件'];
        }
        try{
            $csv = Reader::createFromPath($file->getRealPath(), 'r')->setHeaderOffset(0);
        }catch (Exception $e){
            return ['status_code' => 10003, 'message' => '读取csv文件失败'];
        }

        foreach ($csv as $data){
            $data_us ['songName']=$data['music'];
            $data_us ['songNo']=$data['link'];
            $ed = explode(",",$data['artist_name']);
            $data_us ['singName']= $ed[0];
            $data_us ['singNo']= $ed[0];
            $data_us ['songUrl'] = 'data/'.$ed[0].'/'.$data['music'].'.mp3';
            $data_us ['songLyric'] = 'data/'.$ed[0].'/'.$data['music'].'.txt';
            $data_us ['created_at'] = Carbon::now();
            $items[] = $data_us;
        }
        $chunks = array_chunk($items, 10);
        foreach ($chunks as $chunk) {
            NetEase::insert($chunk);
        }
        $added_amount = count($items);
        return ['status_code' => 200, 'message' => "新增{$added_amount}条"];
    }
}
