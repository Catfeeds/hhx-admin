<?php

namespace App\Console\Commands;

use App\Models\Csvs;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class NetEase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:NetEase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入网易云csv文件';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csvc = Csvs::whereStatus(0)->whereType(0)->get();
        $firstline = true;
        $items =[];
        foreach($csvc as $csv){
            $file_path = storage_path('app/'.$csv->file);
            $file = fopen($file_path, 'r');
            while($data = fgetcsv($file)) {
                if($firstline){
                    $firstline = false;
                    continue;
                }
                $data_us ['songName']=$data[0];
                $data_us ['songNo']=$data[1];
                $data_us ['singNo']='12709';
                $data_us ['singName']= 'S.H.E';
                $data_us ['songUrl'] = 'data/'.$data_us ['singName'].'/'.$data[0].'.mp3';
                $data_us ['songLyric'] = 'data/'.$data_us ['singName'].'/'.$data[0].'.txt';
                $data_us ['created_at'] = Carbon::now();
                $items [] = $data_us;
            }
            $csv->status = 1;
            $csv->updated_at = Carbon::now();
            $csv->save();
        }
        $chunks = array_chunk($items, 10);
        foreach ($chunks as $chunk) {
            DB::table('net_eases')->insert($chunk);
        }
        $added_amount = count($items);
        dd('新增'.$added_amount.'条');
    }
}
