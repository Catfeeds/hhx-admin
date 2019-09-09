<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{

    public function interests()
    {
        return $this->hasMany(Interest::class, 'daily_id');
    }

}
