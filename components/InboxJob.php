<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\Outbox;
use app\models\Inbox;
use yii\base\BaseObject;

class InboxJob extends BaseObject implements \yii\queue\JobInterface
{
    public $id;
    public function execute($queue)
    {
        //code to send sms by id
        $inbox=Inbox::findOne($this->id);
        $inbox->state=1;
        $inbox->save(false);
        Inbox::checkSms($inbox);
    }

}
?>