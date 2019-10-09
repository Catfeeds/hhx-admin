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
        $weibo_users = WeiboUser::select('screen_name','weibo_id')->get();
        foreach ($weibo_users as $weibo_user){
            $uid=$weibo_user->weibo_id;
            $luicode = '10000011';
            $all = '100103type= 1&q='.$weibo_user->screen_name;
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
            $count = ceil($data1['statuses_count']/10);
            for($i=1;$i<= 10;$i++){
                print($i);
                $url2 = 'https://m.weibo.cn/api/container/getIndex?uid='.$uid.'&luicode='.$luicode.'&lfid'.$lfid.'&type='.$type.'&value='.$value.'&containerid='.$containerid2.'&page='.$i;
                $data_all= self::getHtml($url2)['data']['cards'];
                if($data_all){
                    $weibo = new Weibo();
                    $weibo->saveData($data_all,$us);
                }
            }
            if($us['status'] == 0){
                WeiboUser::where('weibo_id',$us['weibo_id'])->update(['status'=>1]);
            }

        }


        dd('结束');

    }


}