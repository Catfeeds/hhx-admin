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
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class DailyHandler
{
    static public function getData(){
        Log::info(time().'daily已经执行');
        $daily = Daily::orderBy('id','desc')->first();
        $direction_logs = DirectionLog::where('daily_id',$daily->id)->get();
        $interest_logs = InterestLog::where('daily_id',$daily->id)->get();
        $yesterDate = Carbon::yesterday()->toDateString();
        $week = date("w",time()-36400);
        $weeks = [0=>'日',1=>'一',2=>'二',3=>'三',4=>'四',5=>'五',6=>'六'];
        $data =[
            'daily' =>$daily,
            'direction_logs' =>$direction_logs,
            'interest_logs'=>$interest_logs,
            'week' =>$weeks[$week],
            'yesterDate'=>$yesterDate,
        ];
        $view = 'Emails.Daily';
//        $data = DailyHandler::getData();
        $toMail = 'hhx06@outlook.com';
        Mail::send($view,$data ,function ($message) use ($toMail) {
            $message->subject('[ daily] 日报 - ' .date('Y-m-d'));
            $message->to($toMail);
        });
        Log::info('its ok');
//        return $data;
    }

    static public function getHhx(){
        Log::info(time().'HHX is success');
    }
}