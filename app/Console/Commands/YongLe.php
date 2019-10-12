<?php

namespace App\Console\Commands;

use App\Handlers\YongLeHandler;
use Illuminate\Console\Command;

class YongLe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:YongLe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '永乐定时更新';

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
        YongLeHandler::getData();
    }
}
