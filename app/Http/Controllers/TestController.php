<?php

namespace App\Http\Controllers;

use App\Utils\HttpSign;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;

use App\Jobs\MyJob2;

use App\Http\Requests\Request;


use App\Redis\WechatRedis;
use App\Utils\HttpProtocol;

class TestController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function testSign()
    {
        $sign = HttpProtocol::sign('aaa', [' a '=>'a c','b'=>'b', 'c'=>null, 'd'=>[1,2,null,4], 'e'=>'我爱你zhongguo', 'f'=>'ffff']);
        $sign1= HttpProtocol::sign1('aaa', [' a '=>'a c','b'=>'b', 'c'=>null, 'd'=>[1,2,null,4], 'e'=>'我爱你zhongguo', 'f'=>'ffff']);

        echo $sign;
        echo '</br>';
        echo $sign1;

    }
    public function redisSentinelsTest(WechatRedis $redis)
    {
        $n = 1;
        aa:{
            echo "$n-".time()."==";
            sleep(1);
            $n ++;
        }

        if($n < 10)
            goto aa;

        exit;
        $aa = 0;dump(isset($aa));
        $time = time();
        $redis->redis->set('rong', 'rong'.$time);

        dump($redis->redis->get('rong'));
    }
    public function test()
    {
        echo 1;exit;
        $sms = (array)config('app.sms_white_list');
dump($sms);
        dump(in_array(18111111111,explode(',', config('app.sms_white_list'))));;exit;
        $content = array(array('name' => 'Abigail', 'state' => 'CA'),array('name' => 'Abigail', 'state' => 'CA'));
        $status = 301;
        $value = 'text/html;charset=utf-8';
        return response($content,$status)->header('Content-Type',$value)
            ->withCookie('site','LaravelAcademy.org');
    }
    public function test1()
    {
        $str = md5(uniqid(mt_rand(), true));
        $uuid  = substr($str,0,8) . '-';
        $uuid .= substr($str,8,4) . '-';
        $uuid .= substr($str,12,4) . '-';
        $uuid .= substr($str,16,4) . '-';
        $uuid .= substr($str,20,12);
        return $uuid;
    }
    
    public function mailTest()
    {
        $name = '学院君';
        $flag = Mail::send('emails.test',['name'=>$name],function($message){
            $to = '460659268@qq.com';
            $message ->to($to)->subject('测试邮件');
        });dump($flag);
        if($flag){
            echo '发送邮件成功，请查收！';
        }else{
            echo '发送邮件失败，请重试！';
        }
    }

    public function jobTest(Request $request, WechatRedis $redis)
    {
        $platform = $request->input('platform');
        $job      = new MyJob2('key_'.str_random(4), str_random(10), $redis);
        switch($platform)
        {
            case 'redisqueuen':$job = $job->onQueue('redisqueuen');
            default:;
        }
        $queueId = $this->dispatch($job);
        dd($queueId);
    }

    public function staticTest(Request $request)
    {
        $sign = $request->input('sign', '123');
        HttpSign::setAppSecret($sign);

        echo HttpSign::getAppSecret();
    }
    public function staticTest1()
    {
        echo HttpSign::getAppSecret();
    }
}
