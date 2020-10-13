<?php
namespace app\admin\model;

class AuthRuleModel extends BaseModel
{
    protected $table = 'auth_rule';

    public function getRules()
    {
        $data = $this->_findAll(['delete_time' => 0,'is_menu' => 1, 'status' => 1]);
        if ($data) {
            $data = $data->toArray();
        }
        return $data;
    }

    public function getList()
    {
        $data = $this->_findAll(['delete_time' => 0, 'status' => 1],'id,pid,title,is_menu');
        if ($data) {
            $data = $data->toArray();
        }
        return $data;
    }

    public function byIdGetRules($ruleIds)
    {
        return $this->_findInAll(['delete_time' => 0,'status' => 1],['id',$ruleIds]);
    }
}
