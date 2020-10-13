<?php


namespace app\admin\controller;

use app\admin\CurdController;
use app\admin\model\AuthGroupAcessModel;
use app\admin\model\AuthRuleModel;
use think\facade\View;

class AuthGroup extends CurdController
{
    protected function _vdata(&$list)
    {
        $list = selectTree($list, $pid = 0, $lvl = 0,"name");
    }

    protected function _create_before(&$postData)
    {
        $postData['status'] = isset($postData['status'])?$postData['status']:0;
    }

    protected function _create_fetch_data()
    {
        $list = $this->model->getSelectTree();
        View::assign('list',$list);
        $authRuleModel = new AuthRuleModel();
        $rules = $authRuleModel->getList();
        foreach ($rules as &$rval) {
            $rval['spread'] = true;
        }
        unset($rval);
        $rules = arr2tree($rules,'id','pid','children');
        View::assign('roleList',$rules);
    }

    protected function _edit_before(&$postData)
    {
        $postData['status'] = isset($postData['status'])?$postData['status']:0;
    }

    protected function _edit_fetch_data($info)
    {
        $list = $this->model->getSelectTree();
        View::assign('list',$list);

        $thisRules = $info->rules?explode(',',$info->rules):[];

        $authRuleModel = new AuthRuleModel();
        $rules = $authRuleModel->getList();
        $rules = array_column($rules,null,'id');

        $newArr = [];
        foreach ($thisRules as $rval) {
            $newArr[] = $rules[$rval];
        }
        $sonName = 'children';
        $thisRules = $this->getLastChild(arr2tree($newArr,'id','pid',$sonName), $sonName);

        foreach ($rules as &$rval) {
            $rval['spread'] = true;
            if (in_array($rval['id'], $thisRules)) {
                $rval['checked'] = true;
            } else {
                $rval['checked'] = false;
            }
        }
        unset($rval);
        $rules = arr2tree($rules,'id','pid',$sonName);
        View::assign('roleList',$rules);

    }

    protected function getLastChild($arr, $son)
    {
        static $tmp = [];
        foreach ($arr as $rval) {
            if (isset($rval[$son]) && $rval[$son]) {
                $this->getLastChild($rval[$son], $son);
            } else {
                $tmp[] = $rval['id'];
            }
        }
        return $tmp;
    }

    public function delete()
    {
        if ($this->request->isAjax()) {
            $ids = $this->request->request('ids');
            if (!$ids) {
                return json(['returnCode' => '0011', 'msg' => '删除失败！', 'data' => null]);
            }
            $result = $this->model->_findInAll(['delete_time' => 0],['pid',$ids]);
            if ($result) {
                return json(['returnCode' => '0012', 'msg' => '删除失败,该角色下还有子节点！', 'data' => null]);
            }

            //判断下面是否还有成员
            $authGroupAcessModel = new AuthGroupAcessModel();
            $users = $authGroupAcessModel->_findInAll(1,['group_id', $ids]);
            if ($users) {
                return json(['returnCode' => '0012', 'msg' => '删除失败,该角色下还有管理员！', 'data' => null]);
            }
            if ($this->model->where('pid','in', $ids)->whereIn('id',$ids,'or')->useSoftDelete('delete_time', time())->delete()) {
                $ids = is_array($ids)?implode(',',$ids):$ids;
                \app\admin\model\AdminLogModel::add('delete', '删除数据id:'.$ids);
                return json(['returnCode' => '200', 'msg' => '删除成功！', 'data' => null]);
            } else {
                return json(['returnCode' => '0011', 'msg' => '删除失败！', 'data' => null]);
            }
        } else {
            return json(['returnCode' => '0010', 'msg' => '请求方式错误！', 'data' => null]);
        }
    }
}
