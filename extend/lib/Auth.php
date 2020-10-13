<?php
namespace lib;

use app\admin\model\AuthGroupAcessModel;
use app\admin\model\AuthGroupModel;
use app\admin\model\AuthRuleModel;
use think\facade\Session;

class Auth
{
    protected static $instance;

    public $rules = [];

    public $uid = 0;

    public function __construct()
    {
        $this->uid = Session::get('admin.id');
    }

    public function __get($name)
    {
        return Session::get('admin.' . $name);
    }

    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }

        return self::$instance;
    }

    public function check($name = '', $uid = null)
    {
        $uid = is_null($uid)?$this->uid:$uid;

        if (!$this->rules) {
            $this->rules = $this->getRules($uid);
        }
        $adminModuleName = env('EXTENSION.ADMIN_MODULE_NAME');

        if (strpos($name, '/' . $adminModuleName . '/') === 0) {
            $name = str_replace('/'.$adminModuleName.'/', '',$name);
            $name = str_replace('.html', '',$name);
            list($class,$action) = explode('/',$name);
            $name = strtolower(parse_name($class)).'/'.$action;
        }
        $urls = array_column($this->rules,'url');
        if (is_string($name)) {
            if (!in_array($name, $urls)) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function match($path, $arr)
    {
        if (!$path) {
            return false;
        }

        $arr = array_map('strtolower', $arr);
        // 不需要鉴权
        if (in_array($path, $arr)) {
            return true;
        }

        // 需要鉴权
        return false;
    }

    public function getRules($uid = null)
    {
        $uid = is_null($uid)?$this->uid:$uid;
        $authGroupAccessModel = new AuthGroupAcessModel();
        $groupIds = $authGroupAccessModel->getUserGroupIds($uid);

        $authGroupModel = new AuthGroupModel();
        $groupInfos = $authGroupModel->getAuthGroups($groupIds);
        $rules = array_column($groupInfos, 'rules');

        $ruleIds = [];
        foreach ($rules as $val) {
            $ruleIds = array_merge($ruleIds,explode(',',$val));
        }
        $ruleIds = array_unique($ruleIds);

        $authRuleModel = new AuthRuleModel();
        $this->rules = $authRuleModel->byIdGetRules($ruleIds);

        return $this->rules;
    }

    public function getMenus($uid = null)
    {
        $uid = is_null($uid)?$this->uid:$uid;
        if (!$this->rules) {
            $this->getRules($uid);
        }
        $menus = [];
        foreach ($this->rules as $rval) {
            if ($rval['is_menu']) {
                $menus[] = $rval;
            }
        }
        $menus = arr2tree($menus);
        return $menus;
    }

    public function isLogin()
    {
        if ($admin = Session::get('admin')) {
            return true;
        } else {
            return false;
        }
    }

}
