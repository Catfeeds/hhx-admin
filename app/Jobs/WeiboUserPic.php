<?php

namespace App\Jobs;

use App\Models\WeiboUser;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WeiboUserPic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //用户头像以及封面
        $weiboUsers = WeiboUser::select('id','avatar_hd','cover_image_phone')->whereNull('updated_at')->get();
        $num =0;
        $num2 =100;
        foreach ($weiboUsers as $user){
            if($user->avatar_hd && strpos($user->avatar_hd,'https') !== false){
                $url = $user->avatar_hd;
                $num = $num +1;
                $e = time().$num .'.jpg';
                $filename ='storage/weibo_user_h/'.$e;
                $client = new Client(['verify' => false]);  //忽略SSL错误
                $client->get($url, ['save_to' => public_path($filename)]);

                $url2 = $user->cover_image_phone;
                $num2 = $num2 -1;
                $e2 = time().$num2 .'.jpg';
                $filename2 ='storage/weibo_user_h/'.$e2;
                $client = new Client(['verify' => false]);  //忽略SSL错误
                $client->get($url2, ['save_to' => public_path($filename2)]);
                $user ->avatar_hd = 'weibo_user_h/'.$e;
                $user ->cover_image_phone = 'weibo_user_h/'.$e2;
                $user->save();
            }
        }
    }
}
