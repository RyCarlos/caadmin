<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/13
 * Time: 14:12
 */

namespace app\admin\controller;


use app\admin\BaseController;
use think\facade\View;

class Icon extends BaseController
{
    /**
     * 图标
     */
    public function index()
    {
        $field = $this->request->get('field', 'icon');
        $data = ['field' => $field];
        View::assign($data);
        return View::fetch();
    }
}
