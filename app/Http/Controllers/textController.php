<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/3
 * Time : 10:33
 */

namespace App\Http\Controllers;


class textController extends Controller
{
    static $URL_PRE = "https://search.damai.cn/searchajax.html?keyword=";
    public function text(){
        $name = "林宥嘉";
        $url_one = self::$URL_PRE.$name.'&currPage=1&pageSize=30';
//        $html = request_get($url_one);
//        dd($html);
    }
}