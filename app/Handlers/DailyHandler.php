<?php
/**
 * Created by PhpStorm.
 * User: a123
 * Date: 2019-10-02
 * Time: 11:44
 */

namespace App\Handlers;
use App\Models\Daily;
use App\Models\DirectionLog;
use App\Models\InterestLog;
use App\Models\Weibo;
use App\Models\WeiboPics;
use Carbon\Carbon;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class DailyHandler
{
    static public function getData(){
        $daily = Daily::orderBy('id','desc')->first();
        $direction_logs = DirectionLog::where('daily_id',$daily->id)->get();
        $interest_logs = InterestLog::where('daily_id',$daily->id)->get();
        $yesterDate = Carbon::yesterday()->toDateString();
        $week = date("w",time()-36400);
        $weeks = [0=>'日',1=>'一',2=>'二',3=>'三',4=>'四',5=>'五',6=>'六'];
        $weibos = Weibo::where('weibo_created_at','>',$yesterDate)->where('is_flag',0)->get()->toArray();
        if($weibos){
            foreach ($weibos as$key=> $weibo){
                if($weibo['pic_num'] >1){
                    $pics = WeiboPics::where('weibo_info_id',$weibo['weibo_info_id'])->limit($weibo['pic_num'])->pluck('url')->toArray();
                    $weibos[$key]['pics'] = $pics;
                }else{
                    $weibos[$key]['pics'] = '';
                }
            }
        }
        $data =[
            'daily' =>$daily,
            'direction_logs' =>$direction_logs,
            'interest_logs'=>$interest_logs,
            'week' =>$weeks[$week],
            'yesterDate'=>$yesterDate,
            'weibos' =>$weibos
        ];
        return $data;
    }

    static public function getHhx(){
        $view = 'Emails.Daily';
        $data = DailyHandler::getData();
        $toMail = 'hhx06@outlook.com';
        Mail::send($view,$data ,function ($message) use ($toMail) {
            $message->subject('[ daily] 日报 - ' .date('Y-m-d'));
            $message->to($toMail);
        });
        Log::info(date('Y-m-d').'daily its ok');
    }

    static public function getWeekData(){
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
        return $data;
    }

    static public function getHhxWeek(){
        $view = 'Emails.Week';
        $data = DailyHandler::getWeekData();
        $toMail = 'hhx06@outlook.com';
        Mail::send($view,$data ,function ($message) use ($toMail) {
            $week_again = date("Y-m-d",strtotime("this week"));
            $message->subject('[week] 周报 - '.$week_again.'-' .date('Y-m-d'));
            $message->to($toMail);
        });
        Log::info(date('Y-m-d').'week its ok');
    }


    static public function sendMessage(){
        Log::info('START');

        $app = app('wechat.official_account');

        $message = new Text('自动发消息是可行的吗？');
        $app->customer_service->message($message)->to('oUCgBwP5gOn79QGN60Fb9GS19kwk')->send();
        Log::info('END');
        return $app->server->serve();


    }
    
}