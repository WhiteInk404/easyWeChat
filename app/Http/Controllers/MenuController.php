<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class MenuController extends Controller
{
    public $menu;

    /**
     * MenuController constructor.
     * @param $menu
     */
    public function __construct(Application $app)
    {
        $this->menu = $app->menu;
    }

    public function menu()
    {
        $buttons = [
            [
                "type" => "view",
                "name" => "经济学人",
                "url"  => "http://mp.weixin.qq.com/mp/homepage?__biz=MzAxMjczOTc0OA==&hid=4&sn=5f87c0ee8f7fae5e4c79837be16ed58f#wechat_redirect"
            ],

            [
                "name"       => "菜单",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "历史文章",
                        "url"  => "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzAxMjczOTc0OA==&scene=124#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "视频教程",
                        "url"  => "http://v.youku.com/v_show/id_XMTgxNTAwOTIwNA==.html?spm=a2hzp.8253869.0.0&from=y1.7-2"
                    ],
                    [
                        "type" => "view",
                        "name" => "红包奖励",
                        "url" => "https://www.wecee.me/web/share/sshare/token/ZjNlYjBhYWNjYjA0OTlmZmYxOTc3ZWYxZmRiZGE4ODhiZDdjMTkzZi4xNDkyNzYyMjA5LjMyNQ=="
                    ],
                ],
            ],

            [
                "type" => "view",
                "name" => "预约课程",
                "url"  => "http://a.app.qq.com/o/simple.jsp?pkgname=me.wecee.student"
            ],

        ];
        $this->menu->add($buttons);
    }
}
