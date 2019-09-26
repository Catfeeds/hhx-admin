<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HhxTravil extends Model
{
    static public function getName(){
        return  HhxTravil::query()->limit(7)->orderBy('id' ,'desc')->pluck('name','id');
    }
}
