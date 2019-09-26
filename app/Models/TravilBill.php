<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TravilBill extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            if($model->direction_id != 0){
                $money = DirectionLog::whereId($model->direction_id)->value('money');
                DB::table('hhx_travils')->where('id',$model->hhx_travil_id)->increment('money', $money);
            }
        });
    }
}
