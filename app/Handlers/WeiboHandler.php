<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/24
 * Time : 9:21
 */

namespace App\Handlers;


use App\Models\Weibo;
use App\Models\WeiboUser;

class WeiboHandler
{
    static public function getHtml($url){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        if($res->getStatusCode()=='200'){
            return json_decode($res->getBody(),true);
        }
        return false;
    }


//    主程序
    static public function getData(){
        # [uid :1836758555,q:Hhx_06]
        $uid = '1836758555';
        $q = 'Hhx_06';
        $luicode = '10000011';
        $all = '100103type= 1&q='.$q;
        $lfid = urlencode($all);
        $type = 'uid';
        $value = $uid;
        # 用户信息
        $containerid1 = '100505' . $uid;
        # 微博信息
        $containerid2 = '107603' . $uid;
        $url1 = 'https://m.weibo.cn/api/container/getIndex?uid='.$uid.'&luicode='.$luicode.'&lfid'.$lfid.'&type='.$type.'&value='.$value.'&containerid='.$containerid1;
        $data1 = self::getHtml($url1)['data']['userInfo'];
        $weiboUser = new WeiboUser();
        $us =$weiboUser ->saveData($data1);
//        $count = ceil($data1['statuses_count']/10);
        $count = 2;
        for($i=1;$i<=$count;$i++){
            print($i);
            $url2 = 'https://m.weibo.cn/api/container/getIndex?uid='.$uid.'&luicode='.$luicode.'&lfid'.$lfid.'&type='.$type.'&value='.$value.'&containerid='.$containerid2.'&page='.$i;
            $data_all= self::getHtml($url2)['data']['cards'];
            if($data_all ){
                $weibo = new Weibo();
                $weibo->saveData($data_all,$us);
            }
        }
        dd('结束');

    }

    static public function parsePic(){
        $data =[];
        $num = 0;
        $weibos = Weibo::whereNull('updated_at')->whereNotNull('thumbnail_pic')->select('id','thumbnail_pic')->get();
        foreach ($weibos as $weibo){
            if($weibo->thumbnail_pic){
                $url = $weibo->thumbnail_pic;
                $return_content = self::http_get_data($url);
                $num = $num +1;
                $e = time().$num .'.jpg';
                $filename ='uploads/new_weibo/'.$e;
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
    }

    static public function http_get_data($url) {

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