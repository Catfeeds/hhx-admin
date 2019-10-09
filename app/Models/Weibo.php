<?php

namespace App\Models;

use App\Jobs\WeiboPic;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Weibo extends Model
{
    protected $guarded=[];
    public function saveData($data,$us){
        foreach ($data as $value){
            if(!$value || ($us['status'] ==1 && $value['mblog']['id'] <= $us['flag'])){
                break;
            }
            if(isset($value['mblog']['retweeted_status'])){
                $data_one = $this->parseData($value['mblog']['retweeted_status']);
                $data_one['is_flag'] =1;
                $new_id = DB::table('weibos')->insertGetId($data_one);
                $data_two = $this->parseData($value['mblog']);
                $data_two['repost_id'] = $new_id;
                print($this->id);
            }else{
                $data_two = $this->parseData($value['mblog']);
            }
            $data_two['scheme'] =$value['scheme'];
            $data_all[] =$data_two;
            if($value['mblog']['pic_num']>1){
                foreach ($value['mblog']['pics'] as $pic){
                    $pic_us['weibo_info_id'] = $value['mblog']['id'];
                    $pic_us['url'] = $pic['url'];
                    $pic_us['created_at'] = Carbon::now();
                    $pic_all[] = $pic_us;
                }
            }
        }
        if(isset($pic_all) && !empty($data_all)){
            DB::table('weibo_pics')->insert($pic_all);
            DB::table('weibos')->insert($data_all);
        }
        unset($data_all);
        unset($pic_all);
        dispatch(new WeiboPic());
    }

    public function parseData($data){
        $len = substr_count($data['created_at'], '-');
        if($len ==1){
            $wb_created_at = date('Y').'-'.$data['created_at'];
        }elseif($len ==0){
            $wb_created_at =  date("Y-m-d");
        }else{
            $wb_created_at = $data['created_at'];
        }
        $data_us =[
            'thumbnail_pic' =>isset($data['thumbnail_pic'])?$data['thumbnail_pic']:'',
            'original_pic' =>isset($data['original_pic'])?$data['original_pic']:'',
            'source' =>isset($data['source'])?$data['source']:'',
            'weibo_created_at' => $wb_created_at,
            'text' =>$data['text'],
            'comments_count' =>$data['comments_count'],
            'attitudes_count' =>$data['attitudes_count'],
            'reposts_count' =>$data['reposts_count'],
            'screen_name' =>$data['user']['screen_name'],
            'repost_id' =>0,
            'is_flag' =>0,
            'weibo_info_id'=>$data['id'],
            'weibo_id' =>$data['user']['id'],
            'pic_num'=>$data['pic_num'],
            'created_at' =>Carbon::now(),
        ];
        return $data_us;
    }



}
