<?php

namespace App\Utils;

class HttpProtocol {
    /**
     * @param $appSecret
     * @param $params
     * @param string $method
     * @return string
     * 参数签名
     */
    public static function sign($appSecret, $params, $method = 'md5') {
        if (!is_array($params)) $params = array();

        ksort($params);

        $text = '';

        foreach ($params as $k => $v) {
//            if(empty($v)) continue;
            if(!is_array($v))
            {
                $text .= $k . $v;
            }else
            {
                $v     = static::signArrayToString($v);
                $text .= $k . $v;
            }
        }

        $signText = $appSecret . $text . $appSecret;
        $signText = preg_replace("/\s/","",$signText);

        return self::hash($method, $signText);
    }
    /**
     * @param $appSecret
     * @param $params
     * @param string $method
     * @return string
     * 参数签名
     */
    public static function sign1($appSecret, $params, $method = 'md5') {
        if (!is_array($params)) $params = array();

        ksort($params);

        $text = '';

        foreach ($params as $k => $v) {
//            if(empty($v)) continue;
            if(!is_array($v))
            {
                $text.= $k . '=' . $v. '&';
            }else
            {
                $v     = static::signArrayToString($v);
                $text.= $k . '=' . $v. '&';
            }
        }
        $text     = mb_substr($text,0,-1,'utf-8');
        $signText = $appSecret . $text . $appSecret;
        $signText = preg_replace("/\s/","",$signText);

        return self::hash($method, $signText);
    }

    private static function hash($method, $text) {
        switch ($method) {
            case 'md5':
                $signature = md5($text);
                break;
            case 'sha1':
                $signature = sha1($text);
                break;
            default:
                $signature = md5($text);
                break;
        }
        return $signature;
    }
    /**
     * 将签名参数中的数组转化为字符串
     * [1111,2222] 转为 "[1111,2222]"
     */
    private static function signArrayToString(array $signArr = [])
    {
        $text = '[';
        $text .= implode(',', $signArr);
        $text .= ']';

        return $text;
    }
}