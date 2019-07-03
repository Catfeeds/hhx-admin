<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/2
 * Time : 17:52
 */

class DamaiHandler{

    /**
     * 获取页面html
     * @param $url
     * @return string
     */
    static public function getHtml($url){
        $response = request_post($url);
        if($response['status_code'] ==200){
            return $response['text'];
        }
        return '';
    }


    static public function getPageCount($html){
        return json_decode($html)["pageData"]["maxTotalResults"];
    }




}