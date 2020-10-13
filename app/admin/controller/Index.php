<?php
namespace app\admin\controller;

use app\admin\BaseController;
use think\App;
use think\facade\View;

class Index extends BaseController
{
    public function welcome()
    {
        return View::fetch();
    }
}
