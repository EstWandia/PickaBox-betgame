<?php

namespace app\components;
use app\models\TransactionLog;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class DepositJob extends BaseObject implements JobInterface
{
    public $id;

    public function execute($queue)
    {
        TransactionLog::processStk($this->id);
    }
}