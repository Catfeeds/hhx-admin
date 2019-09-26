<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;

class DbTop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DbTop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '豆瓣250更新图片';

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
        $num = 0;
        \App\Models\DbTop::query()->select('id','img')->chunk(100, function ($dbs)use($num) {
            foreach ($dbs as $db){
                if($db->img){
                    $url = $db->img;
                    $num = $num +1;
                    $e = time().$num .'.jpg';
                    $filename ='uploads/db_top/'.$e;
                    $client = new Client(['verify' => false]);  //忽略SSL错误
                    $client->get($url, ['save_to' => public_path($filename)]);
                    $db->img = 'db_top/'.$e;
                    $db->save();
                }
            }
        });
    }
}
