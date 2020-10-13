<?php
namespace app\admin\model;

use think\Model;
use think\Validate;

class BaseModel extends model
{
    protected $errorMsg;
    // 关闭自动写入update_time字段
    protected $updateTime = false;


    public function __construct(array $data = [])
    {
        $this->table = env('database.prefix', '').$this->table;
        parent::__construct($data);
    }

    public function _create($data)
    {
        if ($this->save($data)) {
            return $this->id;
        } else {
            return false;
        };
    }

    public function _createAll($data)
    {
        if ($res = $this->insertAll($data)) {
            return $res;
        } else {
            return false;
        }
    }

    public function _findOne($where = 1, $field = '*')
    {
        return $this->where($where)->field($field)->find();
    }

    public function _findAll($where = 1, $field = '*',$order = null)
    {
        $query = $this->where($where);
        if ($field) {
            $query->field($field);
        }
        if ($order) {
            $query->order($order);
        }
        return $query->select();
    }

    public function _findInAll($where = 1, $whereIn = null, $field = '*',$order = null)
    {
        $query = $this->where($where);
        if ($whereIn) {
            if (!is_array($whereIn)) {
                return false;
            }
            list($_field, $_codition) = $whereIn;
            $query->whereIn($_field, $_codition);
        }
        if ($field) {
            $query->field($field);
        }
        if ($order) {
            $query->order($order);
        }
        return $query->select()->toArray();
    }

    public function _findList($where = null, $field = '*', $limit = 15, $order = null)
    {
        $query = $this->where($where);

        if ($field) {
            $query->field($field);
        }

        if ($limit) {
            if (is_array($limit)) {
                list($offset, $count) = $limit;
                $query->limit($offset, $count);
            } else {
                $query->limit($limit);
            }
        }

        if ($order) {
            $query->order($order);
        }
        return $query->select();
    }

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    public function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                [$validate, $scene] = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }
        if (!$v->check($data)) {
            $this->errorMsg = $v->getError();
            return false;
        }
        return true;
    }

    public function getError()
    {
        return $this->errorMsg;
    }
}
