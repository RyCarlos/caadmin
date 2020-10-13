<?php
// 应用公共文件

//生成随机数
if (!function_exists('random')) {
    function random($length, $type = 0, $hash = '')
    {
        if ($type == 0) {
            $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        } else if ($type == 1) {
            $chars = '0123456789';
        } else if ($type == 2) {
            $chars = 'abcdefghijklmnopqrstuvwxyz';
        }
        $max = strlen($chars) - 1;
        mt_srand(( double )microtime() * 1000000);
        for ($i = 0; $i < $length; $i++) {
            $hash .= $chars [mt_rand(0, $max)];
        }
        return $hash;
    }
}

//数组转树形结构
if (!function_exists('arr2tree')) {
    function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        $tree = [];
        $map = array_column($list,null,'id');
        foreach ($list as $item) {
            if (isset($item[$pid]) && isset($map[$item[$pid]])) {
                $map[$item[$pid]][$son][] = &$map[$item[$id]];
            } else {
                $tree[] = &$map[$item[$id]];
            };
        }
        unset($map);
        return $tree;
    }
}

//生成select树形结构
if (!function_exists('selectTree')) {
    function selectTree($arr, $pid = 0, $lvl = 0,$title="title")
    {
        static $res = [];
        foreach ($arr as $key => $vo) {
            if ($pid == $vo['pid']) {
                if (!isset($vo['position'])) $vo['position'] = '';
                $vo['position'] = str_repeat('├  ', $lvl). $vo[$title];
                $res[] = $vo;
                $temp = $lvl + 1;
                selectTree($arr, $vo['id'], $temp, $title);
            }
        }
        return $res;
    }
}

//获取指定元素的所有父元素
if (!function_exists('getParents')) {
    function getParents($arr, $myid = 0, $containMy = true,$pidName = 'pid')
    {
        $pid = 0;
        $newArr = [];
        foreach ($arr as $value) {
            if (!isset($value['id'])) {
                continue;
            }
            if ($value['id'] == $myid) {
                if ($containMy) {
                    $newArr[] = $value;
                }
                $pid = $value[$pidName];
                break;
            }
        }
        if ($pid) {
            $tmpArr = getParents($arr ,$pid);
            $newArr = array_merge($tmpArr, $newArr);
        }
        return $newArr;
    }
}
