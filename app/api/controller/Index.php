<?php
namespace app\api\controller;

use app\api\BaseController;

class Index extends BaseController
{
    public function index()
    {
        return json(['status' => 0,'msg' => '他来了']);
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
