<?php
namespace app\commands;
/**
 * Created by PhpStorm.
 * User: yanrong
 * Date: 2017/8/14
 * Time: 下午2:47
 */
use yii\console\Controller;

use yii\queue\redis\Queue;
class QueueController extends Controller
{

    public $queue;
    /**
     * @inheritdoc
     */
    public function actionInit()
    {
        $this->queue = new Queue();
        $this->init();
    }

    /**
     * Runs all jobs from redis-queue.
     */
    public function actionRun()
    {
        $this->queue->run();
    }

    /**
     * Listens redis-queue and runs new jobs.
     *
     * @param int $wait timeout
     */
    public function actionListen($wait = null)
    {
        $this->queue->listen($wait);
    }
}