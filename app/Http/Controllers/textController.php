<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/3
 * Time : 10:33
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class textController extends Controller
{
//    static $URL_PRE = "https://search.damai.cn/searchajax.html?keyword=";
//    public function text(){
//        $name = "林宥嘉";
//        $url_one = self::$URL_PRE.$name.'&currPage=1&pageSize=30';
//        $client = new \GuzzleHttp\Client();
//        $res = $client->request('GET', $url_one);
//        if($res->getStatusCode()=='200'){
//            $data = json_decode($res->getBody(),true);
//        }
//        $count = $data["pageData"]["maxTotalResults"];
//
//
//    }
        public function index(Request $request){
            

        }


}