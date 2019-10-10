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
//        dd($weibos);
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
        Log::info('its ok');
    }
}