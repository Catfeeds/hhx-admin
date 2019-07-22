<?php

namespace App\Http\Controllers\Basic;

use App\Models\Weibo;
use App\Models\WeiboPics;
use App\Models\WeiboUser;
use App\Models\WeiboVideo;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class BasicController extends Controller
{
    public function getPic1(){
//        $weibos = Weibo::whereNull('updated_at')->whereNotNull('thumbnail_pic')->select('id','thumbnail_pic')->get();
//
//
//        foreach ($weibos as $weibo){
//            if($weibo->thumbnail_pic){
//                $url = $weibo->thumbnail_pic;
//                $return_content = self::http_get_data($url);
//                $num = $num +1;
//                $e = time().$num .'.jpg';
//                $filename ='uploads/new_weibo/'.$e;
//                $fp= @fopen($filename,"a"); //将文件绑定到流
//                fwrite($fp,$return_content); //写入文件
//                $data[$weibo->id] = 'weibo/'.$e;
//            }
//        }
//        foreach ($data as $k =>$v){
//            $we = Weibo::where('id',$k)->first();
//            $we ->thumbnail_pic = $v;
//            $we ->save();
//        }
        $data =[];
        $num = 0;
        Weibo::whereNull('updated_at')->whereNotNull('thumbnail_pic')->select('id','thumbnail_pic')->chunk(100, function ($weibos)use($num) {
            foreach ($weibos as $weibo){
                if($weibo->thumbnail_pic){
                    $url = $weibo->thumbnail_pic;
                    $return_content = self::http_get_data($url);
                    $num = $num +1;
                    $e = time().$num .'.jpg';
                    $filename ='uploads/new_weibo/'.$e;
                    $fp= @fopen($filename,"a"); //将文件绑定到流
                    fwrite($fp,$return_content); //写入文件
                    $data[$weibo->id] = 'new_weibo/'.$e;
                }
            }
        });
        foreach ($data as $k =>$v){
            $we = Weibo::where('id',$k)->first();
            $we ->thumbnail_pic = $v;
            $we ->save();
        }

        dd('ok1');
    }

    public function getPic2(){
        $weiboUsers = WeiboUser::whereNull('updated_at')->select('id','avatar_hd','cover_image_phone')->get();
        $num =0;
        $num2 =100;
        foreach ($weiboUsers as $user){
            if($user->avatar_hd){
                $url = $user->avatar_hd;
                $return_content = self::http_get_data($url);
                $num = $num +1;
                $e = time().$num .'.jpg';
                $filename ='uploads/weibo_user/'.$e;
                $fp= @fopen($filename,"a"); //将文件绑定到流
                fwrite($fp,$return_content); //写入文件

                $url2 = $user->cover_image_phone;
                $return_content2 = self::http_get_data($url2);
                $num2 = $num2 -1;
                $e2 = time().$num2 .'.jpg';
                $filename2 ='uploads/weibo/'.$e2;
                $fp2= @fopen($filename2,"a"); //将文件绑定到流
                fwrite($fp2,$return_content2); //写入文件
                $user ->avatar_hd = 'weibo/'.$e;
                $user ->cover_image_phone = 'weibo/'.$e2;
                $user->save();
            }
        }
        dd('ok2');
    }

    public function getPic3(){
        $weiboPic = WeiboPics::whereNull('updated_at')->select('id','url')->get();
        $num =0;
        foreach ($weiboPic as $pic){
            if($pic->url){
                $url = $pic->url;
                $return_content = self::http_get_data($url);
                $num = $num +1;
                $e = time().$num .'.jpg';
                $filename ='uploads/weibo_pic/'.$e;
                $fp= @fopen($filename,"a"); //将文件绑定到流
                fwrite($fp,$return_content); //写入文件
                $pic ->url = 'weibo/'.$e;
                $pic->save();
            }
        }
        dd('ok3');
    }


    function http_get_data($url) {

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_URL, $url );
        ob_start ();
        curl_exec ( $ch );
        $return_content = ob_get_contents ();
        ob_end_clean ();
        $return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        return $return_content;
    }

    public function getPic55(){
        $pics = WeiboPics::query()->get();
        foreach ($pics as $pic){
            $weibo = Weibo::where('weibo_info_id',$pic->weibo_info_id)->first();
            $weibo ->pic_num += 1;
            $weibo ->save();
        }
        dd('555');
    }

    public function getPic(){
//        $url ='http://f.video.weibocdn.com/000oLbxklx07v6AcbRfG01041200cE1B0E010.mp4?label=mp4_hd&template=640x368.24.0&Expires=1563763986&ssig=lALHWRiFG%2B&KID=unistore,video';
//        $return_content = self::http_get_data($url);
//        $num = 6;
//        $e = time().$num .'.mp4';
//        $filename ='uploads/weiboVideo/'.$e;
//        $fp= @fopen($filename,"a"); //将文件绑定到流
//        fwrite($fp,$return_content); //写入文件
//        dd('6');
        $num = 0;
        $data =[];

        $videos = WeiboVideo::select('url','id')->get();
        foreach ($videos as $video){
            if(strpos($video->url,'m.weibo.cn') !== false){
                $return_content = self::http_get_data($video->url);
                $e = time().$num .'.mp4';
                $filename ='uploads/weiboVideo/'.$e;
                $fp= @fopen($filename,"a"); //将文件绑定到流
                fwrite($fp,$return_content); //写入文件
                $data[$video->id] = 'weiboVideo/'.$e;
            }else{
                $data[$video->id] ='';
            }
        }
        foreach ($data as $k =>$v){
            $we = WeiboVideo::where('id',$k)->first();
            $we ->url = $v;
            $we ->save();
        }
        dd('9');


    }



}
