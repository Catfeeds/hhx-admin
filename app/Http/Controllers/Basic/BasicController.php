<?php

namespace App\Http\Controllers\Basic;

use App\Models\Weibo;
use App\Models\WeiboPics;
use App\Models\WeiboUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class BasicController extends Controller
{
    public function getPic1(){

        $weibos = Weibo::whereNull('updated_at')->whereNotNull('thumbnail_pic')->select('id','thumbnail_pic')->get();
        $data =[];
        $num = 0;
        foreach ($weibos as $weibo){
            if($weibo->thumbnail_pic){
                $url = $weibo->thumbnail_pic;
                $return_content = self::http_get_data($url);
                $num = $num +1;
                $e = time().$num .'.jpg';
                $filename ='uploads/weibo/'.$e;
                $fp= @fopen($filename,"a"); //将文件绑定到流
                fwrite($fp,$return_content); //写入文件
                $data[$weibo->id] = 'weibo/'.$e;
            }
        }
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
                $filename ='uploads/weibo/'.$e;
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
                $filename ='uploads/weibo/'.$e;
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



}
