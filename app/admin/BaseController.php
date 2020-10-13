<?php
declare (strict_types = 1);

namespace app\admin;

use lib\Auth;
use think\App;
use think\exception\HttpResponseException;
use think\facade\Session;
use think\facade\View;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 无需登录的方法,同时也就不需要鉴权了
     * @var array
     */
    protected $noNeedLogin = ['admin.login','admin.loginout'];

    /**
     * 无需鉴权的方法,但需要登录
     * @var array
     */
    protected $noNeedRight = ['index.index','index.welcome','icon.index'];

    /**
     * 权限控制类
     * @var null
     */
    protected $auth = null;

    /**
     * 管理员id
     * @var nummber
     */
    protected $adminId;

    protected $model;

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;
        $this->auth = Auth::instance();
        // 控制器初始化
        $this->initialize();
    }

    /**
     * 自定义重定向方法
     * @param $args
     */
    protected function _redirect(...$args)
    {
        // 此处 throw new HttpResponseException 这个异常一定要写
        throw new HttpResponseException(redirect(...$args));
    }

    // 初始化
    protected function initialize()
    {
        $action = strtolower($this->request->action());
        $class = strtolower(parse_name($this->request->controller()));
        $target = $class.'.'.$action;
        $path = str_replace('.', '/', $class) . '/' . $action;

        $config =  [
            'adminModuleName' => env('EXTENSION.ADMIN_MODULE_NAME')
        ];
        if (!in_array($target, $this->noNeedLogin)) {
            if (false === $this->auth->isLogin()) {
                Session::clear();
                return $this->_redirect((string) url('admin/login'));
            };
            $rules = $this->auth->getRules();
            // 判断是否需要验证权限
            if (!$this->auth->match($target,$this->noNeedRight)) {
                // 判断控制器和方法判断是否有对应权限
                if (!$this->auth->check($path)) {
                    echo '没有操作权限';exit();
                }
            }
            $ruleIds = array_column($rules, 'id');
            $menus = $this->auth->getMenus();
            $config['admin'] = [
                'uid'   => $this->auth->uid,
                'ruleIds'  => $ruleIds
            ];
            View::assign([
                'menus'  => $menus,     //左侧导航菜单渲染
                'config' => $config,     //站点配置渲染
                'auth'   => $this->auth  //权限控制
            ]);
        } else {
            View::assign([
                'config' => $config     //站点配置渲染
            ]);
        }
    }


    public function index()
    {
        return View::fetch();
    }
}
