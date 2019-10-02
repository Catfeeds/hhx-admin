<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/7/3
 * Time : 10:33
 */

namespace App\Http\Controllers;


use App\Models\Daily;
use App\Models\DirectionLog;
use App\Models\InterestLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class textController extends Controller
{
//    static $URL_PRE = "https://search.damai.cn/searchajax.html?keyword=";
//    public function text(){
//        $name = "林宥嘉";
//        $url_one = self::$URL_PRE.$name.'&currPage=1&pageSize=30';
//        $client = new \GuzzleHttp\Client();
//        $res = $client->request('GET', $url_one);
//        if($res->getStatusCode()=='200'){
//            $data = json_decode($res->getBody(),true);
//        }
//        $count = $data["pageData"]["maxTotalResults"];
//
//
//    }
        public function index(Request $request){
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
            return view('Emails.Daily',$data);
        }


}