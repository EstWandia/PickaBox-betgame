<?php

namespace app\components;

use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use app\models\BulkSms;
use app\models\Outbox;
use app\models\ContactInfo;
use yii\db\IntegrityException;

class ScheduleSmsJob extends BaseObject implements JobInterface
{
    public $contacts;
    public $schedule;

    public function execute($queue)
    {
        $success = [];
        $error = [];


        if (is_array($this->contacts)) {

            foreach ($this->contacts as $contactData) {


                $model = new Outbox();
                $model->receiver = $contactData['msisdn'];
                $model->sender = $contactData['sendername'];
                $model->message = $contactData['message'];
                $model->state = 1;
                $model->category = "bulk";

                try {
                    $model->save(false);
                    $success[] = $contactData['msisdn'];
                } catch (IntegrityException $e) {
                    $error[] = $contactData['msisdn'];
                }
            }

            // Create batch for sending SMS
            BulkSms::createBatch();
            // Delete records from Contacts where sendername matches the group
            ContactInfo::deleteAll(['sendername' => $contactData['sendername']]);


            if (!empty($error)) {
                // Yii::error("Scheduled SMS Job encountered errors: " . implode(", ", $error), __METHOD__);
            }
        } else {
            // Yii::error("Expected contacts to be an array, got " . gettype($this->contacts), __METHOD__);
        }
    }
}
