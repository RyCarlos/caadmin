<?php
declare (strict_types = 1);

namespace app\admin;

use think\App;
use think\facade\View;

/**
 * 控制器基础类
 */
class CurdController extends BaseController
{
    protected $model;

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app, $model = null)
    {
        parent::__construct($app);

        $class = strtolower($this->request->controller());
        //模型初始化绑定
        if (!$model) {
            $modelName = '\app\admin\\model\\'.ucfirst($class).'Model';
            $this->model = new $modelName;
        } else {
            $this->model = $model;
        }
    }

    /**
     * 鉴权
     * @return bool
     */
    protected function match()
    {
        return true;
    }


    /*** 列表 start ***/

    public function index()
    {
        if ($this->request->isAjax()) {
            $where[] = array('delete_time', '=', 0);
            $where = array_merge($where, $this->_search_where());

            $page = intval($this->request->request('page',0));
            $limit = intval($this->request->request('limit',10));

            $list = $this->model->_findList($where,'*',[($page-1)*$limit,$limit])->toArray();
            $count = $this->model->_findAll($where)->count();

            $this->_vdata($list);
            return json(['returnCode' => '200','msg' => '查询成功','data' => $list,'count' => $count]);
        } else {
            $this->_index_fetch_data();
            return View::fetch();
        }
    }

    protected function _vdata(&$list)
    {
    }

    protected function _index_fetch_data()
    {
    }

    /*** 列表 end ***/



    /*** 新增 start ***/

    protected function _create_before(&$postData)
    {
    }

    public function create()
    {
        if ($this->request->isAjax()) {
            $postData = $this->request->post();
            $this->_create_before($postData);
            $id = $this->model->_create($postData);
            if ($id) {
                $postData['id'] = $id;
                $this->_create_after($postData);
                \app\admin\model\AdminLogModel::add('add', '新增数据id:'.$id);
                return json(['returnCode' => '200','msg' => '新增成功','data' => null]);
            } else {
                return json(['returnCode' => '0011','msg' => '新增失败','data' => null]);
            }
        } else {
            $this->_create_fetch_data();
            return View::fetch();
        }
    }

    protected function _create_fetch_data()
    {
    }

    protected function _create_after(&$postData)
    {

    }

    /*** 新增 end ***/



    /*** 更新 start ***/

    protected function _edit_before(&$postData)
    {

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

            $this->_edit_before($postData);
            if ($info->save($postData)) {
                $this->_edit_after($postData);
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

    protected function _edit_fetch_data($info)
    {

    }

    protected function _edit_after(&$postData)
    {

    }

    /*** 更新 end ***/




    public function delete()
    {
        if ($this->request->isAjax()) {
            $ids = $this->request->request('ids');
            if (!$ids) {
                return json(['returnCode' => '0011', 'msg' => '删除失败！', 'data' => null]);
            }
            if ($this->model->useSoftDelete('delete_time', time())->delete($ids)) {
                $ids = is_array($ids)?implode(',',$ids):$ids;
                \app\admin\model\AdminLogModel::add('delete', '删除数据id:'.$ids);
                return json(['returnCode' => '200', 'msg' => '删除成功！', 'data' => null]);
            } else {
                return json(['returnCode' => '0011', 'msg' => '删除成功！', 'data' => null]);
            }
        } else {
            return json(['returnCode' => '0010', 'msg' => '请求方式错误！', 'data' => null]);
        }
    }


    protected function _search_where()
    {
        $searchWhere = [];
        if ($searchData = $this->request->param('searchData')) {
            $searchData = json_decode($searchData,true);
            foreach ($searchData as $key => $val) {
                $condition = $val['condition'];
                $filed = $val['key'];
                $value = trim($val['val']);
                if (empty($value)) continue;
                switch ($condition) {
                    case '=':
                        $searchWhere[] = [$filed,'=',$value];
                        break;
                    case 'like':
                        $searchWhere[] = [
                            $filed,'like', '%'.$value.'%'
                        ];
                        break;
                    case 'between':
                        $timeRange = array_map(function ($v) {return $v = strtotime($v);}, explode(' - ', $value));
                        $searchWhere[] = [
                            $filed,'between', $timeRange
                        ];
                        break;
                }
            }
        }
        return $searchWhere;
    }

}
