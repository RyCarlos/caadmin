<?php
namespace app\admin\model;

class AdminModel extends BaseModel
{
    protected $table = 'admin';

    public function login(array $postData)
    {
        $rule = [
            'username' => 'require|max:10',
            'password' => 'require'
        ];
        $message = [
            'username.require' => '用户名不能为空',
            'username.max' => '用户名长度不能大于25',
            'password.require' => '密码不能为空'
        ];
        if ($res = $this->validate($postData, $rule, $message)) {
            $info = $this->_findOne(['username' => $postData['username']],'id,username,avatar,password');
            if (!$info) {
                $this->errorMsg = '用户名不存在';
                return false;
            } else {
                if ($info->password === md5($postData['password'] . env('extension.HMACPWD'))) {
                    unset($info['password']);
                    return $info;
                } else {
                    $this->errorMsg = '密码错误！';
                    return false;
                }
            }
        } else {
            return false;
        }
    }
}
