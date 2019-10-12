<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/5
 * Time : 9:00
 */

namespace App\Handlers;

use App\Models\YongLe;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
                'yname' => $data["name"],
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
        $arr = [];
        $data_us = YongLe::query()->pluck('cityname','yname')->toArray();
        foreach ($datas as $data){
           $ar=array('vname' => $data["vname"],
               'yname' => $data["name"],
               'status' => $data["status"],
               'performer' => $data["performer"],
               'prices'=>$data["prices"],
               'cityname'=>$data["cityname"],
               'enddate'=>$data["enddate"],
               'created_at' =>Carbon::now()
           );
           if(!isset($data_us[$data["name"]])){
               $arr[] = $ar;
           }
        }
        if(count($arr)>0){
            DB::table('yongles')->insert($arr);
        }
    }


    /**
     * 获取数据
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function getData(){
        $names = ['田馥甄','吴青峰','焦安溥','戴佩妮','林俊杰','杨千嬅','杨乃文'];
        foreach ($names as $name){
            $data = self::sendUrl($name);
            if($data){
                foreach ($data as $da){
                    self::saveRedis($da,$name);
                }
                self::saveMysql($data);
            }
        }
       dd('end');

    }

}
