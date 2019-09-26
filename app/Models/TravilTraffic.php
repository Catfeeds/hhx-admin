<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TravilTraffic extends Model
{
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            DB::table('hhx_travils')->where('id',$model->hhx_travil_id)->increment('money', $model->money);

        });
    }
}
