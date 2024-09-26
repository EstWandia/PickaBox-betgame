<?php
/*send sms code using queue*/
namespace app\components;
use app\models\Contact;
use yii\base\BaseObject;

class ImportContactJob extends BaseObject implements \yii\queue\JobInterface
{
    public $filename;
    public $category;
    public function execute($queue)
    {
        //code to send sms by id
        Contact::importContact($this->filename,$this->category);
    }

}
?>