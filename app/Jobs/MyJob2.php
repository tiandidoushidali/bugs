<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Redis\WechatRedis;

class MyJob2 implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $key;
    private $value;
    private $redis;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($key, $value, WechatRedis $redis)
    {
        //
        $this->key = $key;
        $this->value = $value;
        $this->redis = $redis;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->redis->hset('queue.test', $this->key, $this->value);
    }
}
