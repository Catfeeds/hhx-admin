<?php

namespace App\Http\Controllers\Basic;

use App\Models\Weibo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class BasicController extends Controller
{
    public function getPic(){

        $weibos = Weibo::whereNull('updated_at')->select('id','thumbnail_pic')->get();
        $data =[];
        $num = 0;
        foreach ($weibos as $weibo){
            if($weibo->thumbnail_pic){
                $url = $weibo->thumbnail_pic;
                $return_content = self::http_get_data($url);
                $num = $num +1;
                $e = time().$num .'.jpg';
                $filename ='uploads/'.$e;
                $fp= @fopen($filename,"a"); //将文件绑定到流
                fwrite($fp,$return_content); //写入文件
                $data[$weibo->id] = $e;
            }
        }
        foreach ($data as $k =>$v){
            $we = Weibo::where('id',$k)->first();
            $we ->thumbnail_pic = $v;
            $we ->save();
        }
        dd('ok2');
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



}
