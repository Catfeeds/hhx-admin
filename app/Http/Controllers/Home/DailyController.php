<?php
/**
 * Created by PhpStorm.
 * User: a123
 * Date: 2019-10-02
 * Time: 16:49
 */

namespace App\Http\Controllers\Home;

use App\Handlers\DailyHandler;
use App\Models\Daily;
use App\Models\DirectionLog;
use App\Models\InterestLog;
use App\Models\Weibo;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class DailyController extends Controller
{
    public function index(Request $request){
        $data = DailyHandler::getData();
        return view('Emails.Daily',$data);
    }


    public function week(){
        $week_again = date("Y-m-d",strtotime("this week"));
        $dailys = Daily::where('created_at','>',$week_again)->get();
        $daily_ids = $dailys->pluck('id')->toArray();
        $daily_summary = $dailys->pluck('summary')->toArray();
        $daily_grow_up = $dailys->pluck('grow_up')->toArray();
        $daily_Img = $dailys->pluck('Img')->toArray();
        $daily_collocation = $dailys->pluck('collocation')->toArray();
        $directionLogs = DirectionLog::whereIn('daily_id',[$daily_ids])->get();
        $directionSum = $directionLogs->sum('money');
        $interest_logs = InterestLog::whereIn('daily_id',[$daily_ids])->get();
        $weibos = Weibo::where('weibo_created_at','>',$week_again)->where('is_flag',0)->get()->toArray();
        $data = [
            'week_again' =>$week_again,
            'dailys' =>$dailys,
            'direction_logs' =>$directionLogs,
            'directionSum' =>$directionSum,
            'interest_logs' =>$interest_logs,
            'daily_summary' =>$daily_summary,
            'daily_grow_up' =>$daily_grow_up,
            'daily_Img' =>$daily_Img,
            'daily_collocation' =>$daily_collocation,
            'weibos' =>$weibos,

        ];
        return view('Emails.Week',$data);
    }

}