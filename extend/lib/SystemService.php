<?php


namespace lib;


use think\exception\HttpResponseException;
use think\Response;

class SystemService
{
    /**
     * 返回成功的操作
     * @param mixed $msg 消息内容
     * @param array $data 返回数据
     * @param integer $code 返回代码
     */
    public static function success($msg, $data = [], $code = 1, $count = 0)
    {
        $result = ['code' => $code, 'msg' => $msg, 'data' => $data, 'count' => $count];
        throw new HttpResponseException(Response::create($result, 'json', 200, self::corsRequestHander()));
    }

    /**
     * 返回失败的请求
     * @param mixed $msg 消息内容
     * @param array $data 返回数据
     * @param integer $code 返回代码
     */
    public static function error($msg, $data = [], $code = 0, $count = 0)
    {
        $result = ['code' => $code, 'msg' => $msg, 'data' => $data, 'count' => $count];
        throw new HttpResponseException(Response::create($result, 'json', 200, self::corsRequestHander()));
    }

    /**
     * Cors Request Header信息
     * @return array
     */
    public static function corsRequestHander()
    {
        return [
            'Access-Control-Allow-Origin' => request()->header('origin', '*'),
            'Access-Control-Allow-Methods' => 'GET,POST,OPTIONS',
            'Access-Control-Allow-Credentials' => "true",
        ];
    }

    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id 父ID Key
     * @param string $pid ID Key
     * @param string $son 定义子数据Key
     * @return array
     */
    public static function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) $map[$item[$id]] = $item;
        foreach ($list as $item) if (isset($item[$pid]) && isset($map[$item[$pid]])) {
            $map[$item[$pid]][$son][] = &$map[$item[$id]];
        } else $tree[] = &$map[$item[$id]];
        unset($map);
        return $tree;
    }
}
