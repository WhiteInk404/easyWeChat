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
                    if ($message->Event == 'subscribe'){
                        if ($message->EventKey == 'qrscene_ywcdt')
                            return new News([
                                'title'       => '英文晨读 | 慢慢来，比较快',
                                'description' => '我们看到太阳发出的光需要8分钟，看到海王星反射出的光需要4个小时，看到银河系边缘的光至少需要2.4万年，看到宇宙中距离我们最远的那颗星星发出的光需要139亿年。所有的光芒，都需要时间才能被看到……慢慢来，比较快。我们一起加油！',
                                'url'         => 'http://mp.weixin.qq.com/s/eyzx7UX_fLJvLLdpZd6zow',
                                'image'       => 'http://mmbiz.qpic.cn/mmbiz_jpg/ceiacP5ibxGy8674ccv8BAje3ic2z4uuMxyOhRqIWhVicBPfoOabYx8KpHlcUJrEzSHibibv4SYAClKaw3XXehRBS6cA/0?wx_fmt=jpeg'
                                // ...
                            ]);
                        else
                            return "同学你好，我是Johnny。\n\n欢迎优秀的你来到这里，和我们一起学英语，睁眼看世界\n\n――――――――\n\n如果您需要客服帮助，请添加我的个人微信号：johnnypeibai1";
                    }
                    elseif ($message->Event == 'SCAN' && $message->EventKey == 'ywcdt')
                        return new News([
                                'title'       => '英文晨读 | 慢慢来，比较快',
                                'description' => '我们看到太阳发出的光需要8分钟，看到海王星反射出的光需要4个小时，看到银河系边缘的光至少需要2.4万年，看到宇宙中距离我们最远的那颗星星发出的光需要139亿年。所有的光芒，都需要时间才能被看到……慢慢来，比较快。我们一起加油！',
                                'url'         => 'http://mp.weixin.qq.com/s/eyzx7UX_fLJvLLdpZd6zow',
                                'image'       => 'http://mmbiz.qpic.cn/mmbiz_jpg/ceiacP5ibxGy8674ccv8BAje3ic2z4uuMxyOhRqIWhVicBPfoOabYx8KpHlcUJrEzSHibibv4SYAClKaw3XXehRBS6cA/0?wx_fmt=jpeg'
                                // ...
                            ]);
                    elseif ($message->Event == 'CLICK' && $message->EventKey == 'ywcdt')
                        return new News([
                            'title'       => '英文晨读 | 慢慢来，比较快',
                            'description' => '我们看到太阳发出的光需要8分钟，看到海王星反射出的光需要4个小时，看到银河系边缘的光至少需要2.4万年，看到宇宙中距离我们最远的那颗星星发出的光需要139亿年。所有的光芒，都需要时间才能被看到……慢慢来，比较快。我们一起加油！',
                            'url'         => 'http://mp.weixin.qq.com/s/eyzx7UX_fLJvLLdpZd6zow',
                            'image'       => 'http://mmbiz.qpic.cn/mmbiz_jpg/ceiacP5ibxGy8674ccv8BAje3ic2z4uuMxyOhRqIWhVicBPfoOabYx8KpHlcUJrEzSHibibv4SYAClKaw3XXehRBS6cA/0?wx_fmt=jpeg'
                            // ...
                        ]);
                    else
                        return '';
                    break;
                case 'text':
                    if ($message->Content == '7000')
                        return "链接: https://pan.baidu.com/s/1jIl4nMu 密码: xfqf";
                    else if ($message->Content == 'ywcdt')
                        return new News([
                            'title'       => '英文晨读 | 慢慢来，比较快',
                            'description' => '我们看到太阳发出的光需要8分钟，\n看到海王星反射出的光需要4个小时，\n看到银河系边缘的光至少需要2.4万年，\n看到宇宙中距离我们最远的那颗星星发出的光需要139亿年。\n所有的光芒，都需要时间才能被看到……\n\n慢慢来，比较快。\n我们一起加油！',
                            'url'         => 'http://mp.weixin.qq.com/s/eyzx7UX_fLJvLLdpZd6zow',
                            'image'       => 'http://mmbiz.qpic.cn/mmbiz_jpg/ceiacP5ibxGy8674ccv8BAje3ic2z4uuMxyOhRqIWhVicBPfoOabYx8KpHlcUJrEzSHibibv4SYAClKaw3XXehRBS6cA/0?wx_fmt=jpeg'
                            // ...
                        ]);
                    else
                        return "你好～".$userApi->get($message->FromUserName)->nickname."\n\n我是Johnny，很高兴遇见你～\n\n加我微信（johnnypeibai1）\n\n随时撩我～";
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
