<?php

namespace App\Models;

use App\Jobs\WeiboUserPic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
            $data['created_at'] = now();
            unset($data['id']);
            DB::table('weibo_users')->insert($data);
            unset($data);
            $us = [
                'status'=>0,
                //新用户 小于的都保存
                'flag' =>0,
            ];
        }else{
            $weibo_user->updated_at = now();
            $weibo_user->update($data);
            if($weibo_user->status ==0){
                $flag = Weibo::where('weibo_id',$weibo_user->weibo_id)->where('is_flag',0)->min('weibo_info_id');
                $status = 0;
            }else{
                $flag = Weibo::where('weibo_id',$weibo_user->weibo_id)->where('is_flag',0)->max('weibo_info_id');
                $status = 1;
            }
            $us =[
                'status'=>$status,
                'flag' =>$flag,
            ];

        }
        dispatch(new WeiboUserPic());
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
