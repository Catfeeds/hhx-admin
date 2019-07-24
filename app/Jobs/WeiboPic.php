<?php

namespace App\Jobs;

use App\Models\Weibo;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;


class WeiboPic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $data =[];
        $num = 0;
        Weibo::whereNull('updated_at')->whereNotNull('thumbnail_pic')->select('id','thumbnail_pic')->chunk(100, function ($weibos)use($num,$client) {
            foreach ($weibos as $weibo){
                if($weibo->thumbnail_pic){
//                    $num = $num +1;
//                    $e = time().$num .'.jpg';
//                    $filename ='uploads/new_weibo/'.$e;
                    $url = $weibo->thumbnail_pic;
//                    $client = new Client(['verify'=>false]);
//                    $response = $client->get($url,['save_to'=>$filename]);
//                    if(file_exits($filename)){
//                        dd("下载成功");
//                    }

                    try {

                        $client = new \GuzzleHttp\Client();

                        $data = $client->request('get',$url)->getBody()->getContents();

                        Storage::disk('local')->put('filename', $data);

                    } catch (\GuzzleHttp\RequestException $e) {
                        dd($e->getMessage());
                        echo 'fetch fail';

                    }
//                    $return_content = $client->request('GET', $url);

//                    $fp= @fopen($filename,"a"); //将文件绑定到流
//                    fwrite($fp,$return_content); //写入文件
//                    $data[$weibo->id] = 'new_weibo/'.$e;
                }
                dd('8');
            }
        });
        foreach ($data as $k =>$v){
            $we = Weibo::where('id',$k)->first();
            $we ->thumbnail_pic = $v;
            $we ->save();
        }
    }
}
