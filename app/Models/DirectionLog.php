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
        switch ($type){
            case 1:
                $start = date("Y-m-d",strtotime("this week"));
                break;
            case 2:
                $start = date("Y-m-d",strtotime("this mouth"));
                break;
            case 3:
                $start = date("Y-m-d",strtotime("this year"));
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
}
