<?php
namespace app\admin\model;

use lib\Auth;

class AdminLogModel extends BaseModel
{
    protected $table = 'admin_log';

    public static function add($category, $msg)
    {
        $auth = Auth::instance();
        $admin_id = $auth->isLogin() ? $auth->uid : 0;
        $username = $auth->isLogin() ? $auth->username : '';

        $content = request()->param();
        foreach ($content as $k => $v) {
            if (is_string($v) && strlen($v) > 200 || stripos($k, 'password') !== false) {
                unset($content[$k]);
            }
        }
        self::create([
            'admin_id' => $admin_id,
            'username' => $username,
            'url' => substr(request()->url(), 0, 1500),
            'category' => $category,
            'content'   => !is_scalar($content) ? json_encode($content) : $content,
            'message' => $msg,
            'ip' => request()->ip(),
            'useragent' => substr(request()->server('HTTP_USER_AGENT'), 0, 255),
            'create_time'   => time()
        ]);
    }
}
