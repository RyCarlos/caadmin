<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/10
 * Time: 16:22
 */

namespace lib;


class Fun
{
    /**
     * cookie设置
     * @param $var 设置的cookie名
     * @param $value 设置的cookie值
     * @param $life 设置的过期时间：为整型，单位秒 如60表示60秒后过期
     * @param $path 设置的cookie作用路径
     * @param $domain 设置的cookie作用域名
     */
    public static function ssetcookie($array, $life = 3600, $path = '/', $domain = '')
    {
        global $_SERVER;
        $_cookName_ary = array_keys($array);
        for ($i = 0; $i < count($array); $i++) {
            setcookie($_cookName_ary [$i], $array [$_cookName_ary [$i]], $life ? (time() + $life) : 0, $path, $domain, $_SERVER ['SERVER_PORT'] == 443 ? 1 : 0);
        }
    }

    public static function encodelogin($_userid, $_login_time, $randkey, $HTTP_USER_AGENT)
    {
        $key = self::addkey($_userid, $_login_time, $randkey, $HTTP_USER_AGENT); //加密key  //$randkey = lib_Fun::random(3)   $HTTP_USER_AGENT = $_SERVER["HTTP_USER_AGENT"];;
        $datakey = self::authcode($_userid . "_" . $_login_time . "_" . $randkey, "",
            Constant::LOGINKEY); //数据key
        $array = array(Constant::LOGIN_COOKIE_DATA_NAME => $datakey, Constant::
        LOGIN_COOKIE_ENCRYPT_NAME => $key);
        $_COOKIE[Constant::LOGIN_COOKIE_DATA_NAME] = $datakey;
        $_COOKIE[Constant::LOGIN_COOKIE_ENCRYPT_NAME] = $key;
        self::ssetcookie($array, 86400, '/', Constant::Domain);
    }

    public static function decodelogin()
    {
        $HTTP_USER_AGENT = $_SERVER["HTTP_USER_AGENT"];
        if (empty($_COOKIE[Constant::LOGIN_COOKIE_DATA_NAME])) return false;
        if (empty($_COOKIE[Constant::LOGIN_COOKIE_ENCRYPT_NAME])) return false;
        $datakey = $_COOKIE[Constant::LOGIN_COOKIE_DATA_NAME]; //数据key
        $key = $_COOKIE[Constant::LOGIN_COOKIE_ENCRYPT_NAME]; //加密key
        $datakeystr = self::authcode($datakey, $operation = 'DECODE', Constant::
        LOGINKEY);
        $dataarray = explode("_", $datakeystr);
        $_userid = (int)$dataarray[0];
        $_login_time = (int)$dataarray[1];
        $randkey = $dataarray[2];
        if (!$_userid || !$_login_time || !$randkey) {
            return false;
        }
        if ($key != self::addkey($_userid, $_login_time, $randkey, $HTTP_USER_AGENT)) {
            return false;
        }
        return $_userid;
    }

    public static function addkey($_userid, $_login_time, $randkey, $HTTP_USER_AGENT)
    {
        return md5(md5($_userid . $_login_time . Constant::LOGINKEY) . $HTTP_USER_AGENT .
            $randkey);
    }

    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry =
    0)
    {

        $ckey_length = 4; // 随机密钥长度 取值 0-32;
        // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        // 当此值为 0 时，则不产生随机密钥
        //取消UC_KEY，改为必须传入$key才能运行
        if (empty($key)) {
            exit('PARAM $key IS EMPTY! ENCODE/DECODE IS NOT WORK!');
        } else {
            $key = md5($key);
        }


        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) :
            substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) :
            sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb),
                0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) &&
                substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)
            ) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }
}