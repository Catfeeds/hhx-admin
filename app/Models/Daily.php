<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{

    public function interests()
    {
        return $this->hasMany(Interest::class, 'daily_id');
    }

    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $data = Daily::getTimeDay();
            $interestLogs = InterestLog::whereDailyId(0)->get();
            foreach($interestLogs as $value){
                if(in_array($value->created_at ->toDateString(),$data)){
                    $value ->daily_id = array_search($value->created_at ->toDateString(), $data);
                    $value ->save();
                }
            }
            $directionLogs = DirectionLog::whereDailyId(0)->get();
            foreach($directionLogs as $value){
                if(in_array($value->created_at ->toDateString(),$data)){
                    $value ->daily_id = array_search($value->created_at ->toDateString(), $data);
                    $value ->save();
                }
            }

        });
    }
    /*
     * 获取最近七天的
     */
    static public function getTimeDay(){
        $data =  Daily::query()->limit(7)->orderBy('id' ,'desc')->pluck('created_at','id')
            ->map(function ($item, $key) {
            return $item->toDateString();
        });
        return $data->all();
    }

}
