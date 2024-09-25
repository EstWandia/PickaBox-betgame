<?php

namespace app\models;
use Webpatser\Uuid\Uuid;
use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "disbursements".
 *
 * @property string $id
 * @property string|null $bet_id
 * @property string|null $transaction_id
 * @property string|null $msisdn
 * @property float $amount
 * @property string|null $conversation_id
 * @property int $state
 * */
class GameDisbursement extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_disbursement';
    }

    public static function getDb()
    {
        return Yii::$app->sms_db;
    }

    public static function logDisbursement($bet_id,$amount, $msisdn)
    {
        $model = new GameDisbursement();
        $model->id = Uuid::generate()->string;
        $model->bet_id = $bet_id;
        $model->amount = $amount;
        $model->msisdn = $msisdn;
        $model->save(false);
    }


}