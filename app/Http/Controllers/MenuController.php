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
                "type" => "click",
                "name" => "英文晨读团",
                "key"  => "ywcdt"
            ],

            [
                "name"       => "使用APP",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "视频教程",
                        "url"  => "http://v.youku.com/v_show/id_XMTgxNTAwOTIwNA==.html?spm=a2hzp.8253869.0.0&from=y1.7-2"
                    ],
                    [
                        "type" => "view",
                        "name" => "红包奖励",
                        "url"  => "https://www.wecee.me/web/share/sshare/token/ZjNlYjBhYWNjYjA0OTlmZmYxOTc3ZWYxZmRiZGE4ODhiZDdjMTkzZi4xNDkyNzYyMjA5LjMyNQ=="
                    ],
                    [
                        "type" => "view",
                        "name" => "预约课程",
                        "url"  => "http://a.app.qq.com/o/simple.jsp?pkgname=me.wecee.student"
                    ],
                ],
            ],

            [
                "type" => "view",
                "name" => "测词汇量",
                "url"  => "http://reading.baicizhan.com/vocab_test"
            ],

        ];
        $this->menu->add($buttons);
    }
}
