<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use EasyWeChat\Message\News;

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
                        return new News([
                            'title'       => '英文晨读 | 慢慢来，比较快',
                            'description' => '我们看到太阳发出的光需要8分钟，\n看到海王星反射出的光需要4个小时，\n看到银河系边缘的光至少需要2.4万年，\n看到宇宙中距离我们最远的那颗星星发出的光需要139亿年。\n所有的光芒，都需要时间才能被看到……\n\n慢慢来，比较快。\n我们一起加油！',
                            'url'         => 'http://mp.weixin.qq.com/s?__biz=MzAxMjczOTc0OA==&mid=502809481&idx=1&sn=77b9452a1c9ec6aea42873d92e87c013&chksm=03a1d64234d65f54504126db81f3b7c9859a971ba5c8f17aaf5e7cf95c48a774884f8801f53d#rd',
                            'image'       => 'http://mmbiz.qpic.cn/mmbiz_png/ceiacP5ibxGyibJdiaynFtAfmyRun0Md6C9b0l6nticmucl9WbrkJDaEibgX31hEg8rmVXJAj4mMUVKjXjXV6P7mIErA/0?wx_fmt=png'
                            // ...
                        ]);
                    else
                        return '';
                    break;
                case 'text':
                    if ($message->Content == '7000')
                        return "链接: https://pan.baidu.com/s/1jIl4nMu 密码: xfqf";
                    else if ($message->Content == 'ywcdt'){
                        $news = new News();
                        $news->title = '英文晨读 | 慢慢来，比较快';
                        $news->description = '我们看到太阳发出的光需要8分钟，\n看到海王星反射出的光需要4个小时，\n看到银河系边缘的光至少需要2.4万年，\n看到宇宙中距离我们最远的那颗星星发出的光需要139亿年。\n所有的光芒，都需要时间才能被看到……\n\n慢慢来，比较快。\n我们一起加油！';
                        $news->url = 'http://mp.weixin.qq.com/s?__biz=MzAxMjczOTc0OA==&mid=502809481&idx=1&sn=77b9452a1c9ec6aea42873d92e87c013&chksm=03a1d64234d65f54504126db81f3b7c9859a971ba5c8f17aaf5e7cf95c48a774884f8801f53d#rd';
                        $news->image = 'http://mmbiz.qpic.cn/mmbiz_png/ceiacP5ibxGyibJdiaynFtAfmyRun0Md6C9b0l6nticmucl9WbrkJDaEibgX31hEg8rmVXJAj4mMUVKjXjXV6P7mIErA/0?wx_fmt=png';
                        }
                        return $news;
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
