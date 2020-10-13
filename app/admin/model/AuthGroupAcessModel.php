<?php
namespace app\admin\model;

class AuthGroupAcessModel extends BaseModel
{
    protected $table = 'auth_group_access';

    public function getUserGroupIds($uid)
    {
        $result = $this->_findAll(['user_id' => $uid],'group_id')->toArray();
        $groupIds = array_column($result,'group_id');
        return $groupIds;
    }

    public function getAuthGroupAccess($users)
    {
        $list = $this->whereIn('user_id',$users)->select()->toArray();
        return $list;
    }
}
