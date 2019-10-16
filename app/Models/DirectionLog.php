<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DirectionLog extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if($model->daily_id != 0 && $model->status == 0){
                DB::table('dailies')->whereId($model->daily_id)->increment('money', $model->money);
            }
            if($model->status == 0){
                Direction::whereId($model->direction_id)->increment('all_num', $model->money);
            }else{
                Direction::whereId($model->direction_id)->decrement('all_num', $model->money);
            }

        });
    }

    static public function getIllustration(){
        return  DirectionLog::query()->limit(7)->orderBy('id' ,'desc')->pluck('illustration','id');
    }

    static public function getData($type =1){
        $now = time();
        switch ($type){
            case 1:
                $start = date("Y-m-d",strtotime("this week"));
                break;
            case 2:
                $start = date('Y-m-01', strtotime(date("Y-m-d")));
                break;
            case 3:
                $start = date('Y-m-d', mktime(0, 0,0, 1, 1, date('Y', $now)));
                break;
            default:
                $start = '2019-01-01';
        }
        $directions = Direction::query()->select('name','id')->get();
        foreach($directions as $direction){
            $data[$direction->name] = DirectionLog::whereBetween('created_at',[$start,Carbon::now()])->where('direction_id',$direction->id)->sum('money');
        }
        return $data;
    }


    static public function getSummaryData(){
        $week_again = date("Y-m-d",strtotime("this week"));
        $mouth_again = date('Y-m-01', strtotime(date("Y-m-d")));

        $week = DirectionLog::whereBetween('created_at',[$week_again,Carbon::now()])->sum('money');
        $mouth = DirectionLog::whereBetween('created_at',[$mouth_again,Carbon::now()])->sum('money');
        return '<h3><span class="label label-info">本周合计'.$week.'</span><span class="label label-success">本月合计'.$mouth.'</span></h3>';

    }


}
