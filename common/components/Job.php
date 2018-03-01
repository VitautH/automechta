<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 20.01.2018
 * Time: 12:04
 */

namespace common\components;

use Yii;
use yii\base\Component;

class Job extends Component
{
    private $queue;
    private $nameJob;
    private $classJob;
    private $methodJob;
    private $delay;

    public function __construct(array $config = [])
    {
        $this->queue = $config['jobs'];
        foreach ($this->queue as $queue) {
            $this->nameJob = $queue['nameJob'];
            $this->classJob = $queue['classJob'];
            $this->methodJob = $queue['methodJob'];
            $this->delay = $queue['timerJob'];
            $this->push();
        }

    }

    private function push()
    {
        if (!Yii::$app->cache->exists('Job_' . $this->nameJob)) {
            Yii::$app->cache->hmset('Job_' . $this->nameJob, ['message' => '', 'error' => ''], $this->delay);
            $this->execute(Yii::createObject([
                'class' => $this->classJob,
            ]), $this->methodJob);
        }

    }

    private function execute($class, $methodJob = null)
    {
        if ($methodJob !== null) {
            return $class->$methodJob();
        } else {
            return $class;
        }
    }


}