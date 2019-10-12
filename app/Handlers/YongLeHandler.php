<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/5
 * Time : 9:00
 */

namespace App\Handlers;

class YongLeHandler
{
    static $URL_PRE = "https://www.228.com.cn/s/";
    static $URL_END = "/?j=1&p=1";

    /**
     * 获取页面内容
     * @param $url
     * @return bool|mixed
     */
    static public function getHtml($url){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', $url);
        if($res->getStatusCode()=='200'){
            return json_decode($res->getBody(),true);
        }
        return false;
    }

    /**
     * 获取页面数据
     * @param $url
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function getDataAll($url){
        if(self::getHtml($url)){
            return self::getHtml($url)["products"];
        }
    }

    /**
     * 发送数据请求
     * @param string $name
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function sendUrl($name ="田馥甄"){
        $url = self::$URL_PRE.$name.self::$URL_END;
        return  self::getDataAll($url);
    }

    /**
     * 保存到redis
     * @param $datas
     * @param $name
     */
    static public function saveRedis($data ,$name){
        $redis = app('redis');
        $key ='yl:'.$name.':'.$data["cityname"];
        $redis->hmset($key,
            array('vname' => $data["vname"],
                'yname' => $data["yname"],
                'status' => $data["status"],
                'performer' => $data["performer"],
                'prices'=>$data["prices"],
                'cityname'=>$data["cityname"],
                'enddate'=>$data["enddate"]
            )
        );
    }

    /**
     * 保存数据库
     * @param $datas
     */
    static public function saveMysql($datas){
        $yongle = new \App\Models\YongLe();

    }


    static public function getData(){
       $name = '李荣浩';
       $data = self::sendUrl($name);
       self::saveRedis($data,$name);
       dd('end');

    }

}
