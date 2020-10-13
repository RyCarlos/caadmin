<?php
namespace app\admin\model;

class AuthGroupModel extends BaseModel
{
    protected $table = 'auth_group';

    public function getSelectTree()
    {
        $data = $this->_findAll(['delete_time' => 0]);
        if ($data) {
            $data = selectTree($data->toArray(),0,0,"name");
        }
        return $data;
    }

    public function getAuthGroups($groupIds = null)
    {
        if ($groupIds && is_array($groupIds)) {
            return $this->_findInAll(1,['id',$groupIds]);
        } else {
            return $this->_findInAll(1);
        }
    }
}
