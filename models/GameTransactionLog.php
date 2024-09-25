<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transaction_log".
 *
 * @property string $id
 * @property string $json_data
 * @property string $date
 * @property string|null $api_type
 * @property string|null $CheckoutRequestID
 */

class GameTransactionLog extends ActiveRecord
{
     /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_log';
    }

    public static function getDb() {
        return Yii::$app->sms_db;
    }

    public static function log($id, $data,$api_type,$state)
    {
            $model=new GameTransactionLog();
            $model->id = $id;
            $model->json_data=$data;
            $model->api_type=$api_type;
            $model->date=date("Y-m-d H:i:s");
            $model->state=$state;
            $model->save(false);
    }
}