<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Damai extends Model
{
    /**
     * 保存数据
     * @param $data
     * @param $name
     */
    public function saveData($data,$name){
        if(!$this->SearchData($data,$name)){
            $damai = new Damai;
            $damai ->actors = $name;
            $damai ->cityname = $data['cityname'];
            $damai ->nameNoHtml = $data['nameNoHtml'];
            $damai ->price_str = $data['price_str'];
            $damai ->showtime = $data['showtime'];
            $damai ->venue = $data['venue'];
            $damai ->showstatus = $data['showstatus'];
            $damai ->save();
        }

    }

    /**
     * 保存前查找
     * @param $data
     * @param $name
     * @return bool
     */
    public function SearchData($data,$name){
        $where =[
            'actors' =>$name,
            'cityname'=>$data['cityname'],
            'venue' =>$data['venue']
        ];
        if($this->where($where)->first()){
            return true;
        }
        return false;
    }
}
