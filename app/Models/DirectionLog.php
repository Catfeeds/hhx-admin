<?php

namespace App\Models;

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
}
