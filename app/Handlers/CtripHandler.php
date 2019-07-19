<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/9
 * Time : 17:54
 */
namespace App\Handlers;

use App\Models\Ctrip;

class CtripHandler{
    /**
     * 获取html
     * @param $url
     * @param $data
     * @param $c
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function getHtml($url,$data){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST',$url,['form_params'=>$data]);
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
    static public function getDataAll($url,$data){
        if(self::getHtml($url,$data)){
            return self::getHtml($url,$data)["data"]["oneWayPrice"][0];
        }
    }

    /**
     * 解析数据
     * @param $url
     * @param $data
     * @param $c
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function parseData($url,$data,$c){
        $datas = self::getDataAll($url,$data);
        $minkey = array_search(min($datas),$datas);
        $arr['depAirportCode'] = $c['depAirportCode'];
        $arr['arrAirportCode'] = $c['arrAirportCode'];
        $arr['depAirportName'] = $c['depAirportName'];
        $arr['arrAirportName'] = $c['arrAirportName'];
        $arr['minDate'] = $minkey;
        $arr['minPrice'] = min($datas);
        return $arr;
    }

    /**
     * 单个参数
     * @return mixed
     */
    static public function simpleData(){
        $c['depAirportCode'] = "dlc";
        $c['arrAirportCode'] = "cgo";
        $c['depAirportName'] = "大连";
        $c['arrAirportName'] = "郑州";
        return $c;
    }

    /**
     * 默认数据请求
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    static public function defaultRequest(){
        $url = 'https://flights.ctrip.com/itinerary/api/12808/lowestPrice';
        $c = self::simpleData();
        $data =[
            'flightWay'=>"Oneway",
            'dcity'=>$c['depAirportCode'],
            'acity'=>$c['arrAirportCode'],
            'army'=>"false"
        ];
        $arr = self::parseData($url,$data,$c);
        //保存数据库
        $ctrip = new Ctrip();
        $ctrip->saveData($arr);
        dd('default');
    }

    static public function mysqlRequest(){
        $all = Ctrip::where('status',1)->get();
        $url = 'https://flights.ctrip.com/itinerary/api/12808/lowestPrice';
        foreach ($all as $value){
            $data =[
                'flightWay'=>"Oneway",
                'dcity'=>$value->depAirportCode,
                'acity'=>$value->arrAirportCode,
                'army'=>"false"
            ];
            $arr = self::parseData($url,$data,$value->toArray());
            $ctrip = new Ctrip();
            $ctrip->saveData($arr);
        }
    }

    /**
     * 主入口
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    //php artisan command:ctrip
    static public function getData(){
        self::mysqlRequest();
    }

}