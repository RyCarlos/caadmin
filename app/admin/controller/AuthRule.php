<?php


namespace app\admin\controller;

use app\admin\CurdController;
use think\facade\View;

class AuthRule extends CurdController
{
    public function index()
    {
        if ($this->request->isAjax()) {
            $where[] = ['is_menu','=',1];
            $where[] = ['delete_time','=',0];
            $where = array_merge($where, $this->_search_where());
            $list = $this->model->_findAll($where,'*')->toArray();
            $this->_vdata($list);
            return json(['returnCode' => 200,'msg' => '查询成功','data' => $list]);
        } else {
            $this->_index_fetch_data();
            return View::fetch();
        }
    }

    protected function _vdata(&$list)
    {
        $list = selectTree($list);
    }

    protected function _create_fetch_data()
    {
        $rules = selectTree($this->model->getRules());
        View::assign('menuList', $rules);
    }

    protected function _create_before(&$postData)
    {
        $postData['status'] = isset($postData['status'])?$postData['status']:0;
    }

    protected function _edit_before(&$postData)
    {
        $postData['status'] = isset($postData['status'])?$postData['status']:0;
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
                    return json(['returnCode' => 0012,'msg' => '新增失败','data' => null]);
                }
                $this->model->commit();
                \app\admin\model\AdminLogModel::add('create', '新增数据id:'.$id);
                return json(['returnCode' => 200,'msg' => '新增成功','data' => null]);
            } else {
                return json(['returnCode' => 0011,'msg' => '新增失败','data' => null]);
            }
        } else {
            $this->_create_fetch_data();
            return View::fetch();
        }
    }

    protected function _create_after(&$postData)
    {
        $ppid = $postData['pid'];
        if ($ppid) {
            //设置所有父辈元素非菜单项为禁用状态
            $menus = $this->model->_findAll();
            $parents = getParents($menus,$ppid);
            $parentIds = array_column($parents,'id');
            $upData = ['status' => 0];
            $upWhere = ['status' => 1,'delete_time' => 0];
            if (!$this->model->where($upWhere)->whereIn('id',$parentIds)->update($upData)) {
                return false;
            }
        }

        $default = [
            ['title' => '查看','url'   => 'index'],
            ['title' => '添加', 'url'   => 'create'],
            ['title' => '编辑', 'url'   => 'edit'],
            ['title' => '删除', 'url'   => 'delete'],
            ['title' => '批量删除', 'url'   => 'delete'],
        ];
        $pid = $postData['id'];
        $data = [];
        foreach ($default as $value) {
            $data[] = [
                'pid'           => $pid,
                'is_menu'       => 0,
                'title'         => $value['title'],
                'url'           => $value['url'],
                'status'        => 1,
                'create_time'   => time()
            ];
        }
        if ($this->model->_createAll($data)) {
            return true;
        } else {
            return false;
        }
    }

    protected function _edit_fetch_data($id)
    {
        $rules = selectTree($this->model->getRules());
        View::assign('menuList', $rules);
    }

    public function delete()
    {
        if ($this->request->isAjax()) {
            $ids = $this->request->request('ids');
            if (!$ids) {
                return json(['returnCode' => '0011', 'msg' => '删除失败！', 'data' => null]);
            }
            $result = $this->model->_findInAll(['is_menu' => 1,'delete_time' => 0],['pid',$ids]);
            if ($result) {
                return json(['returnCode' => '0012', 'msg' => '删除失败,该菜单下还有子节点！', 'data' => null]);
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
