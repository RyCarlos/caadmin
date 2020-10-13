<?php
namespace app\admin\controller;

use app\admin\CurdController;
use app\admin\model\AuthGroupModel;
use app\admin\model\AuthGroupAcessModel;
use think\facade\Session;
use think\facade\View;

class Admin extends CurdController
{

    /**
     * 登录
     */
    public function login()
    {
        if ($this->isLogin()) {
            return redirect((string) url('admin/index/index'))->send();
        } else {
            if ($this->request->isPost()) {
                $postData = $this->request->only(['username','password'],'post');
                $result = $this->model->login($postData);
                if (false === $result) {
                    $msg = $this->model->getError();
                    return json(['returnCode' => 300,'data' => null,'msg' => $msg]);
                } else {
                    Session::set('admin',$result->toArray());
                    return json(['returnCode' => 200,'data' => null,'msg' => '登录成功']);
                }
            } else {
                View::assign([
                    'webTitle'  => '后台管理登录'
                ]);
                return View::fetch();
            }
        }

    }

    /**
     * 退出登录
     */
    public function loginOut()
    {
        Session::clear();
        redirect(url('admin/admin/login'))->send();
    }

    /**
     * 忘记密码
     */
    public function forgetPass()
    {
    }


    protected function _vdata(&$list)
    {
        $users = array_column($list,'id');
        $authGroupAcessModel = new AuthGroupAcessModel();
        $authUserGroupAcess = $authGroupAcessModel->getAuthGroupAccess($users);
        $authUserGroupAcessIds = array_unique(array_column($authUserGroupAcess,'group_id'));


        $authGroupModel = new AuthGroupModel();
        $authGroups = $authGroupModel->_findInAll(null,['id',$authUserGroupAcessIds],'id,name');
        $authGroups = array_column($authGroups,'name','id');

        $newArr = [];
        foreach ($authUserGroupAcess as $rval) {
            $newArr[$rval['user_id']][] = $authGroups[$rval['group_id']];
        }

        foreach ($list as &$lval) {
            $lval['group_ids'] = $newArr[$lval['id']];
        }
    }

    public function create()
    {
        if ($this->request->isAjax()) {
            $postData = $this->request->post();
            $this->_create_before($postData);
            $this->model->startTrans();
            $id = $this->model->_create($postData);
            if ($id) {
                $postData['id'] = $id;
                if (!$this->_create_after($postData)) {
                    $this->model->rollBack();
                    return json(['returnCode' => '0012','msg' => '新增失败','data' => null]);
                }
                $this->model->commit();

                \app\admin\model\AdminLogModel::add('create', '新增数据id:'.$id);
                return json(['returnCode' => '200','msg' => '新增成功','data' => null]);
            } else {
                $this->model->rollBack();
                return json(['returnCode' => '0011','msg' => '新增失败','data' => null]);
            }
        } else {
            $this->_create_fetch_data();
            return View::fetch();
        }
    }

    protected function _create_before(&$postData)
    {
        $default = '123456';
        if (!$postData['password']) {
            $postData['password'] = md5($default . env('extension.HMACPWD'));
        }
    }

    protected function _create_fetch_data()
    {
        $roleModel = new AuthGroupModel();
        $list = $roleModel->getSelectTree();
        $arr = [];
        foreach ($list as $lval) {
            $arr[] = [
                'id' => $lval['id'],
                'value' => $lval['id'],
                'name' => $lval['position']
            ];
        }
        View::assign('list',$arr);
    }

    protected function _create_after(&$postData)
    {
        $uid = $postData['id'];
        $authGroupAcessModel = new AuthGroupAcessModel();
        $groupIds = isset($postData['group_ids'])?$postData['group_ids']:'';
        if (!$groupIds) {
            return false;
        }
        $groupIds = explode(',',$groupIds);

        foreach ($groupIds as $val) {
            $data[] = [
                'user_id' => $uid,
                'group_id' => $val
            ];
        }

        if ($authGroupAcessModel->insertAll($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($id = null)
    {
        $id = intval($id);
        if ($this->request->isAjax()) {
            $postData = $this->request->post();
            if ($id <= 0) {
                return json(['returnCode' => '0011','msg' => '参数错误！','data' => null]);
            }

            $info = $this->model->_findOne(['id' => $id]);
            if (!$info) {
                return json(['returnCode' => '0011','msg' => '数据不存在！','data' => null]);
            }
            $this->model->startTrans();
            $this->_edit_before($postData);
            if ($info->save($postData)) {
                $this->_edit_after($postData);
                $this->model->commit();

                \app\admin\model\AdminLogModel::add('edit', '编辑数据id:'.$id);
                return json(['returnCode' => '200','msg' => '编辑成功！','data' => null]);
            } else{
                return json(['returnCode' => '0011','msg' => '编辑失败，请联系管理员！','data' => null]);
            }

        } else {
            if ($id <= 0) {
                echo "参数错误";exit();
            }

            $info = $this->model->_findOne(['id' => $id]);
            if (!$info) {
                echo "数据不存在！";exit();
            }

            $this->_edit_fetch_data($info);
            return View::fetch('',['data' => $info]);
        }
    }

    protected function _edit_after(&$postData)
    {
        $uid = $postData['id'];
        $roleIds = isset($postData['group_ids'])?$postData['group_ids']:'';
        if (!$roleIds) {
            return false;
        }
        $roleIds = explode(',',$roleIds);
        $authGroupAcessModel = new AuthGroupAcessModel();
        $userGroupIds = $authGroupAcessModel->getUserGroupIds($uid);
        $needInsert = array_diff($roleIds,$userGroupIds);
        $needDelete = array_diff($userGroupIds,$roleIds);
        $data = [];
        $ins = true;
        $del = true;
        foreach ($needInsert as $val) {
            $data[] = [
                'user_id' => $uid,
                'group_id' => $val
            ];
        }
        if ($data) {
            $ins = $authGroupAcessModel->insertAll($data);
        }
        if ($needDelete) {
            $del = $authGroupAcessModel->where(['user_id' => $uid])->whereIn('group_id',$needDelete)->delete();
        }

        if ($ins && $del) {
            return true;
        } else {
            return false;
        }
    }

    protected function _edit_fetch_data($info)
    {
        $uid = $info['id'];
        $authGroupAcessModel = new AuthGroupAcessModel();
        $userGroupIds = $authGroupAcessModel->getUserGroupIds($uid);

        $authGroupModel = new AuthGroupModel();
        $list = $authGroupModel->getSelectTree();
        $arr = [];
        foreach ($list as $lval) {
            $arr[] = [
                'id' => $lval['id'],
                'value' => $lval['id'],
                'name' => $lval['position'],
                'selected' => in_array($lval['id'],$userGroupIds)?true:false
            ];
        }
        View::assign('list',$arr);
    }

    protected function _edit_before(&$postData)
    {
        if (!$postData['password']) {
            unset($postData['password']);
        } else {
            $postData['password'] = md5($postData['password'] . env('extension.HMACPWD'));
        }

        if (!isset($postData['status'])) {
            $postData['status'] = 0;
        }
    }
}
