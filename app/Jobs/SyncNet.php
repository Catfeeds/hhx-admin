<?php

namespace App\Jobs;

use App\Models\Csvs;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncNet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $csvs = Csvs::whereStatus(0)->whereType(0)->get();
        $firstline = true;
        $items =[];
        foreach($csvs as $csv){
            $file_path = env('APP_URL').'/uploads/'.$csv->file;
            $file = fopen($file_path, 'r');
            while($data = fgetcsv($file)) {
                if($firstline){
                    $firstline = false;
                    continue;
                }
                $data_us ['songName']=$data[0];
                $data_us ['songUrl']=$data[1];
                $e = explode(',',$data[2]);
                $data_us ['singNo']= $e[1];
                $data_us ['singName']= $e[0];
                $data_us ['created_at'] = Carbon::now();
                $items [] = $data_us;
            }
            $csv->count = count($items);
            $csv->status = 1;
            $csv->updated_at = Carbon::now();
            $csv->save();
        }
        $chunks = array_chunk($items, 10);
        foreach ($chunks as $chunk) {
            DB::table('net_eases')->insert($chunk);
        }
    }
}
