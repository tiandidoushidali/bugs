<?php
namespace App\Utils;

class HttpSign
{
    private static $appSecret = '--passport_key--';

    public static function setAppSecret($secret)
    {
        static::$appSecret = $secret;
    }
    public static function getAppSecret()
    {
        return static::$appSecret;
    }
    public static function getSign($signParams)
    {
        $sign = HttpProtocol::sign(static::$appSecret, $signParams);

        return $sign;
    }

    public static function getHttpParameters($signParams, $platformid = 'passport')
    {
        $sign = static::getSign($signParams);

        $params = array(
            "sign"          => $sign,
            "platform_id"    => $platformid
        );
        !$signParams OR $params["params"]   = $signParams;

        return $params;
    }

}
