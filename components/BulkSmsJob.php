<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\BulkSms;
use yii\base\BaseObject;

class BulkSmsJob extends BaseObject implements \yii\queue\JobInterface
{
    public $id;
    public function execute($queue)
    {
        //code to send sms by id
        BulkSms::sendBatch($this->id);
    }

}
?>