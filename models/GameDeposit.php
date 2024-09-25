<?php

namespace app\models;
use Webpatser\Uuid\Uuid;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "mpesa_payments".
 *
 * @property string $id
 * @property string|null $TransID
 * @property string|null $FirstName
 * @property string|null $MiddleName
 * @property string|null $LastName
 * @property string|null $MSISDN
 * @property string|null $InvoiceNumber
 * @property string|null $BusinessShortCode
 * @property string|null $ThirdPartyTransID
 * @property string|null $TransactionType
 * @property string|null $OrgAccountBalance
 * @property string|null $BillRefNumber
 * @property string|null $TransAmount
 * @property int $is_archived
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */

class GameDeposit extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game_collection';
    }

     /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['operator'], 'string', 'max' => 20],
            [['TransID'], 'string', 'max' => 100],
            [['FirstName', 'MiddleName', 'LastName', 'MSISDN', 'InvoiceNumber', 'BusinessShortCode', 'ThirdPartyTransID', 'TransactionType', 'OrgAccountBalance', 'BillRefNumber', 'TransAmount'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    public static function getDb() {
        return Yii::$app->sms_db;
    }

    public static function logDeposit($TransId, $msisdn, $amount,$state,$ThirdPartyTransID)
    {
        $model = new GameDeposit();
        $model->id = Uuid::generate()->string;
        $model->TransID = $TransId;
        $model->MSISDN = $msisdn;
        $model->ThirdPartyTransID = $ThirdPartyTransID;
        $model->TransAmount = $amount;
        $model->BusinessShortCode = "174379";
        $model->state = $state;
        $model->created_at = date("Y-m-d H:i:s");
        $model->save(false);

    }


}