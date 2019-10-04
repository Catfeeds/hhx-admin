<?php

namespace App\Console\Commands;

use App\Handlers\DailyHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendemail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '发送邮件';

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
//        $content = '这是一封的测试邮件.';
//        $toMail = 'hhx06@outlook.com';
//        Mail::raw($content, function ($message) use ($toMail) {
//            $message->subject('[ notice ] 会收到提醒的吗 - ' .date('Y-m-d H:i:s'));
//            $message->to($toMail);
//        });
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
