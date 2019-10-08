<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/10/8
 * Time : 11:48
 */

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

use App\Models\DbMusicTop;
use Illuminate\Support\Facades\Request;
class DbMusicTopController extends Controller
{
    public function top250(Request $request){
        $datas = DbMusicTop::query()->paginate(10);
        $data['data'] =$datas;
        return view('Home.Douban.music_top250',$data);
    }

}