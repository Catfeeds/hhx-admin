<?php

namespace App\Console\Commands;

use App\Handlers\WeiboHandler;
use App\Jobs\WeiboPic;
use Illuminate\Console\Command;

class Weibo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:weibo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'weibo';

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
//        WeiboHandler::parsePic();
        dispatch(new WeiboPic());

    }
}
