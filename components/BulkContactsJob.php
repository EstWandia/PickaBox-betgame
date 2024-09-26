<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\BulkSms;
use yii\base\BaseObject;

class BulkContactsJob extends BaseObject implements \yii\queue\JobInterface
{
    public $message;
    public $sender;
    public function execute($queue)
    {
        //code to send sms by id
        BulkSms::bulkContacts($this->message,$this->sender);
    }

}
?>