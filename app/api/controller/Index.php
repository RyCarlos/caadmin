<?php
namespace app\api\controller;

use app\api\BaseController;

class Index extends BaseController
{
    public function index()
    {

    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
