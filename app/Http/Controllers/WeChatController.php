<?php
/**
 * Created by PhpStorm
 * User : Hhx
 * Date : 2019/10/16
 * Time : 12:06
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;

class WeChatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    return '收到事件消息';
                    break;
                case 'text':
                    return '已经收到您的消息,可惜我并不会回复您的。';
                    break;
                case 'image':
                    return '您的图片,我已经收到,但是 我是不会看的';
                    break;
                case 'voice':
                    return '您说了什么,风太大我听不清楚';
                    break;
                case 'video':
                    return '视频,您都敢发 我很佩服';
                    break;
                case 'location':
                    return '位置信息已经收到,然后呢';
                    break;
                case 'link':
                    return '该链接已经失效';
                    break;
                case 'file':
                    return '文件太大,读取失败';
                // ... 其它消息
                default:
                    return '今天天气晴';
                    break;
            }
        });

        return $app->server->serve();
    }
}