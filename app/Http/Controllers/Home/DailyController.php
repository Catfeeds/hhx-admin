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
        $data = DailyHandler::getWeekData();
        return view('Emails.Week',$data);
    }

}