<?php

namespace App\Admin\Controllers;

use App\Models\Csvs;
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
use Encore\Admin\Widgets\Table;

class NetEaseController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $headName = "netEase";
    public function index(Content $content)
    {
        return
            $content
            ->header($this->headName)
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
        $grid = new Grid(new NetEase);

        $grid->id('Id');
//        $grid->singNo('SingNo');
        $grid->songNo('SongNo');
        $grid->singName('SingName');
        $grid->songName('SongName');
        $grid->songUrl('SongUrl')->audio(['server' => env('APP_URL').'/']);
        $grid->songLyric('SongLyric')->modal('Lyric', function ($model) {
            $filenames =  env('APP_URL').'/'.$model->songLyric;
            $filename= fopen($filenames, "r");
            $data_us = [];
            $num =0;
            $data_us['歌曲'] = $model->songName;
            while(! feof($filename))
            {
                $content = fgets($filename); //逐行取出
                $num++;
                $data_us[(string)$num] = $content;
            }
            fclose($filename);
//            dd($data_us);
//            $h1 = implode(" ", $data_us);

            return new Table(['key', 'value'], $data_us);
        });;
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
        $file = $request->file('file');
        if (!$file->isValid()) {
            return ['status_code' => 10001, 'message' => '上传失败'];
        }
        if (!in_array($file->getMimeType(), ['text/plain'])) {
            return ['status_code' => 10002, 'message' => '请上传csv文件'];
        }
        $path = $request->file('file')->store('file');
        $data['file'] = $path;
        $data['status'] =0;
        $csv =new Csvs();
        $csv->create($data);
        return ['status_code' => 200, 'message' => $data['file']];
    }
}
