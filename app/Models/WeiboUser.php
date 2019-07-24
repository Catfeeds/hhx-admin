<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class WeiboUser extends Model
{
    protected $guarded=[];
    public function saveData($data_us){
        $data = array_only($data_us, ['avatar_hd','cover_image_phone','description','follow_count','followers_count','gender','id','mbrank','mbtype','screen_name','statuses_count']);
//        $data_us = $data->only('avatar_hd','cover_image_phone','description','follow_count','followers_count','gender','id','mbrank','mbtype','screen_name','statuses_count');
        $weibo_user = $this->SearchData($data);
        if(!$weibo_user){
            $data['weibo_id'] = $data['id'];
            unset($data['id']);
            $this->create($data);
            $us = [
                'new'=>1,
                'wcount' =>0
            ];
        }else{
            Log::info($data);
            $weibo_user->updated_at = now();
            $weibo_user->update($data);
            $max = Weibo::where('weibo_id',$weibo_user->weibo_id)->where('is_flag',0)->max('weibo_info_id');
            $us =[
                'new'=>0,
                'wcount' =>$max?$max:0
            ];
        }
        return $us;
    }



    public function SearchData($data){
        $where =[
            'weibo_id' =>$data['id'],
        ];
        $weibo_user = $this->where($where)->first();
        if($weibo_user){
            return $weibo_user;
        }
        return false;
    }
}
