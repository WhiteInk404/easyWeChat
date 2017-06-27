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

    public function thumb($filename,$width,$height)
    {
        //获取原图像$filename的宽度$width_orig和高度$height_orig
        list($width_orig,$height_orig) = getimagesize($filename);
        //根据参数$width和$height值，换算出等比例缩放的高度和宽度
        if ($width && ($width_orig<$height_orig)){
            $width = ($height/$height_orig)*$width_orig;
        }else{
            $height = ($width / $width_orig)*$height_orig;
        }

        header('Content-Type: image/jpeg');
        //将原图缩放到这个新创建的图片资源中
        $image_p = imagecreatetruecolor($width, $height);
        //获取原图的图像资源
        $image = imagecreatefromjpeg($filename);

        //使用imagecopyresampled()函数进行缩放设置
        imagecopyresampled($image_p,$image,0,0,0,0,$width,$height,$width_orig,$height_orig);

/*        //将缩放后的图片$image_p保存，100(质量最佳，文件最大)
        imagejpeg($image_p);

        imagedestroy($image_p);
        imagedestroy($image);*/
        return $image_p;
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

        /**
         * resimple qrcode image to 300*300
         *
         */
//        header ('Content-Type: image/png');
//        $qrcode_source = imagecreatefromjpeg($qrcodeurl);
//        $qrcode_thumb = imagecreatetruecolor(300, 300);
//        imagecopyresampled($qrcode_thumb, $qrcode_source, 0, 0, 0, 0, 300, 300, 430, 430);
//
        $qrcode_thumb = $this->thumb($qrcodeurl,300,300);

        /**
         * add headimage to qrcode
         */
        $head_source = imagecreatefromjpeg($this->person($openId));
        imagecopy($qrcode_thumb, $head_source, 118, 118, 0, 0, 64, 64);

        imagejpeg($qrcode_thumb);

    }

}
