<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Damai extends Model
{

    protected $guarded=[];
    /**
     * 保存数据
     * @param $data
     * @param $name
     */
    public function saveData($data){
        $damai = $this->SearchData($data);
        $data_us['actors'] = $data['actors'];
        $data_us['cityname'] = $data['cityname'];
        $data_us['nameNoHtml'] = $data['nameNoHtml'];
        $data_us['price_str'] = $data['price_str'];
        $data_us['showtime'] = $data['showtime'];
        $data_us['venue'] = $data['venue'];
        $data_us['showstatus'] = $data['showstatus'];
//        dd($data_us);
        if(!$damai){
            $this->create($data_us);
        }else{
            $damai->updated_at = now();
            $damai->update($data_us);
        }

    }

    /**
     * 保存前查找
     * @param $data
     * @param $name
     * @return bool
     */
    public function SearchData($data){
        $where =[
            'actors' =>$data['actors'],
            'cityname'=>$data['cityname'],
            'venue' =>$data['venue']
        ];

        $damai = $this->where($where)->first();
        if($damai){
            return $damai;
        }
        return false;
    }
}
