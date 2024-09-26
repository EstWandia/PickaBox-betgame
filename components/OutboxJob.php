<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\Outbox;
use yii\base\BaseObject;

class OutboxJob extends BaseObject implements \yii\queue\JobInterface
{
    public $id;
    public function execute($queue)
    {
        //code to send sms by id
        Outbox::sendOutbox($this->id);
    }

}
?>