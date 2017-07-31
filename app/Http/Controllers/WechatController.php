<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use EasyWeChat\Message\Material;

use Log;

class WechatController extends Controller
{
    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $userApi = $wechat->user;

        $wechat->server->setMessageHandler(function($message) use ($userApi,$wechat){


            switch ($message->MsgType) {
                case 'event':
                    if ($message->Event == 'subscribe')
                        return "Hi ".$userApi->get($message->FromUserName)->nickname."\nWelcome to WeCee!\n客服微信：xuechun_1991";
                    elseif ($message->Event == 'VIEW')
                        return '';
                    elseif ($message->Event == 'CLICK' && $message->EventKey == 'ywcdt')

                        return new Material('mpnews', 'wnbcD3E9njenEUjhH9A05wplfnnECwQQhOSmnn79hXs');

                    else
                        return '';
                    break;
                case 'text':
                    if ($message->Content == '7000')
                        return "链接: https://pan.baidu.com/s/1jIl4nMu 密码: xfqf";
                    else if ($message->Content == '海报')
                        return "海报";
                    else
                        return "你好，".$userApi->get($message->FromUserName)->nickname."。\n如果您需要客服帮助，请添加微信号：xuechun_1991";
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }
            // ...

        });

        Log::info('return response.');

        return $wechat->server->serve()->send();
    }


}
