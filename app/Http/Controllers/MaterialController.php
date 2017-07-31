<?php

namespace App\Http\Controllers;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;

use App\Http\Requests;

class MaterialController extends Controller
{
    public $material;

    /**
     * MaterialController constructor.
     * @param $material
     */
    public function __construct(Application $material)
    {
        $this->material = $material->material;
    }

    public function image()
    {
        $image =$this->material->uploadImage(public_path().'/avatar.jpg');

        return $image;
    }

    public function news()
    {
        $news = $this->material->lists('news', 50, 20);

        return $news;
    }
}
