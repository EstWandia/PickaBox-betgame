<?php
/*send sms code using queue*/
namespace app\components;
use Yii;
use app\models\Outbox;
use app\models\SentSms;
use yii\base\BaseObject;

class BlacklistedJob extends BaseObject implements \yii\queue\JobInterface
{
    public function execute($queue)
    {
        //code to send sms by id
        SentSms::blacklisted();
    }

}
?>