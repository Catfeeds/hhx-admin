<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestLog extends Model
{
    protected $fillable = ['illustration', 'week_day', 'interest_id'];

    public function daily()
    {
        return $this->belongsTo(Daily::class, 'daily_id');
    }
}
