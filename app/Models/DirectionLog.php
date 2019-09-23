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
            if($model->daily_id != 0){
                DB::table('dailies')->whereDailyId($model->daily_id)->increment('money', $model->daily_id);
            }
        });
    }
}
