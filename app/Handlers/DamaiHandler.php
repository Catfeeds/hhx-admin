<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/2
 * Time : 17:52
 */

namespace App\Handlers;

use Illuminate\Support\Facades\Log;

class DamaiHandler{

    static $Common_Url = "https://search.damai.cn/searchajax.html?keyword=";
    static $Midd_Common ="&currPage=1&pageSize=";
    static $Default_PageSize = 30;

    /**
     * 获取html
     * @param $url
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * 获取总个数
     * @param $url
     * @return int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function getDataCount($url){
        if(self::getHtml($url)){
            return self::getHtml($url)["pageData"]["maxTotalResults"];
        }
        return 0;
    }

    /**
     * 获取页面数据
     * @param $url
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function getDataAll($url){
        if(self::getHtml($url)){
            return self::getHtml($url)["pageData"]["resultData"];
        }
    }

    /**
     * 获取数据请求
     * @param string $name
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function getUrl($name ="田馥甄"){
        $url = self::$Common_Url.$name.self::$Midd_Common.self::$Default_PageSize;
        $count = self::getDataCount($url);
        if($count ==0){
            return '';
        }
        $url_data = self::$Common_Url.$name.self::$Midd_Common.$count;
        return  self::getDataAll($url_data);
    }



    /**
     * 保存数据库
     * @param $datas
     */
    static public function saveMysql($data){
        $damai = new \App\Models\Damai();
        $damai ->saveData($data);
    }

    /**
     * 定时任务
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function carbonGet(){

        $names = ["田馥甄","戴佩妮","杨千嬅","吴青峰"];
        foreach($names as $name){
            $datas = self::getUrl($name);
            if($datas){
                foreach ($datas as $data){
                    $data['actors'] = $name;
                    self::saveMysql($data);
//                    self::saveRedis($data,$name);
                    unset($data);
                }
                unset($datas);
            }
        }
        unset($names);
        Log::info(date('Y-m-d').'damai its ok');
    }

}
