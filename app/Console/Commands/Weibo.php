<?php

namespace App\Console\Commands;

use App\Handlers\WeiboHandler;

use App\Models\WeiboPics;
use App\Models\WeiboUser;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class Weibo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:weibo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'weibo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        WeiboHandler::getData();
//        weibo tupian
//        $num = 0;
//        \App\Models\Weibo::whereNull('updated_at')->whereNotNull('thumbnail_pic')->select('id','thumbnail_pic')->chunk(100, function ($weibos)use($num) {
//            foreach ($weibos as $weibo){
//                if($weibo->thumbnail_pic){
//                    $url = $weibo->thumbnail_pic;
//                    $num = $num +1;
//                    $e = time().$num .'.jpg';
//                    $filename ='/storage/weibo_pic_h/'.$e;
//                    $client = new Client(['verify' => false]);  //忽略SSL错误
//                    $data[$weibo->id] = 'weibo_pic_h/'.$e;
//                    $client->get($url, ['save_to' => public_path($filename)]);
//                }
//            }
//            if(!empty($data)){
//                foreach ($data as $k =>$v){
//                    $we =\App\Models\Weibo::where('id',$k)->first();
//                    $we ->thumbnail_pic = $v;
//                    $we ->save();
//                }
//            }
//        });
//        WeiboPics::whereNull('updated_at')->select('id','url')->chunk(100, function ($weiboPic)use($num) {
//            foreach ($weiboPic as $pic){
//                if($pic->url){
//                    $url = $pic->url;
//                    $num = $num +1;
//                    $e = time().$num .'.jpg';
//                    $filename ='storage/weibo_pic_p/'.$e;
//                    $client = new Client(['verify' => false]);  //忽略SSL错误
//                    $client->get($url, ['save_to' => public_path($filename)]);
//                    $pic ->url = 'weibo_pic_p/'.$e;
//                    $pic->save();
//                }
//            }
//        });
//         删除微博重复数据
//        $hh = \App\Models\Weibo::query()->pluck('weibo_info_id','id')->toArray();
//        $hh2 =array_flip(array_flip($hh));
//        $h = array_diff_assoc($hh,$hh2);
//        $t = array_keys($h);
//        \App\Models\Weibo::destroy($t);

//        $weiboUsers = WeiboUser::select('id','avatar_hd','cover_image_phone')->whereNull('updated_at')->get();
//        $num =0;
//        $num2 =100;
//        foreach ($weiboUsers as $user){
//            if($user->avatar_hd && strpos($user->avatar_hd,'https') !== false){
//                $url = $user->avatar_hd;
//                $num = $num +1;
//                $e = time().$num .'.jpg';
//                $filename ='storage/weibo_user_h/'.$e;
//                $client = new Client(['verify' => false]);  //忽略SSL错误
//                $client->get($url, ['save_to' => public_path($filename)]);
//
//                $url2 = $user->cover_image_phone;
//                $num2 = $num2 -1;
//                $e2 = time().$num2 .'.jpg';
//                $filename2 ='storage/weibo_user_h/'.$e2;
//                $client = new Client(['verify' => false]);  //忽略SSL错误
//                $client->get($url2, ['save_to' => public_path($filename2)]);
//                $user ->avatar_hd = 'weibo_user_h/'.$e;
//                $user ->cover_image_phone = 'weibo_user_h/'.$e2;
//                $user->save();
//            }
//        }
    }
}
