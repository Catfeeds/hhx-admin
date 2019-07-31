<?php

namespace App\Models;

use App\Jobs\SyncNet;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Model;

class Csvs extends Model
{
    protected $guarded=[];
    const TYPES = ['网易云', '其他'];
    const STATUS =['未同步','同步'];

}
