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

class NetEaseJJController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    protected $headName = "netEaseJJ";
    protected $SingNo = '3684';
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
        $grid->model()->where('SingNo', '=',$this->SingNo);
        $grid->id('Id');
        $grid->singNo('SingNo');
        $grid->singName('SingName');
        $grid->songName('SongName');
        $grid->songUrl('SongUrl');
        $grid->localUrl()->video(['server' => env('APP_URL'),'videoWidth' => 480, 'videoHeight' => 480]);
        $grid->column('SongLyric')->modal(function () {
            $filenames =  env('APP_URL').'/data/'.$this->singName.'/'.$this->songName.'.txt';
            $h = './data/'.$this->singName.'/'.$this->songName.'.txt';

            if(file_exists($h)){
                $filename= fopen($filenames, "r");
                $data_us = [];
                $num =0;
                $data_us['歌曲'] = $this->songName;
                while(! feof($filename))
                {
                    $content = fgets($filename); //逐行取出
                    $num++;
                    $data_us[(string)$num] = $content;
                }
                fclose($filename);
                return new Table(['key', 'value'], $data_us);
            }

        });
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');
        $grid->paginate(10);
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
        $show->singName('SingName');
        $show->songName('SongName');
        $show->songUrl('SongUrl');
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
        $form->text('singName', 'SingName');
        $form->text('songUrl', 'SongUrl');
        $form->text('songName', 'SongName');
        return $form;
    }

}
