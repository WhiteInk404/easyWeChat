<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class PosterController extends Controller
{
    public $wechat;

    /**
     * PosterController constructor.
     * @param $wechat
     */
    public function __construct(Application $wechat)
    {
        $this->wechat = $wechat;
    }

    public function person($openId)
    {
        $userinfo = $this->wechat->user->get($openId);
//        var_dump($userinfo);

        $headimgurl = substr($userinfo['headimgurl'],0,strripos($userinfo['headimgurl'], "/"))."/64";
//        var_dump($headimgurl);
        return $headimgurl;
    }

    public function getqrcode($openId)
    {
        $qrcodeinfo = $this->wechat->qrcode->forever(56);
        $qrcodeurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($qrcodeinfo["ticket"]);
//        $ticket = $qrcodeinfo->ticket; // 或者 $result['ticket']
//        $url = $qrcodeinfo->url;
//
//        var_dump($qrcodeurl);
//        var_dump($ticket);
//        var_dump($url);
        $qrcode_source = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQHq8DwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyckRWaFY5QTJhaVAxMDAwMGcwM00AAgQC_1FZAwQAAAAA";
        imagecopyresampled($qrcode_thumb, $qrcode_source, 0, 0, 0, 0, 300, 300, 430, 430);

        return $qrcode_thumb;

    }

}
