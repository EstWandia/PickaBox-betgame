<?php

namespace app\models;

use Yii;

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
 * @property int $state
 * @property string|null $station_id
 * @property string|null $operator
 * @property int $tickets
 * @property int|null $moved
 */
class MpesaPayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mpesa_payments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['is_archived', 'state', 'tickets', 'moved'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['TransID', 'deleted_at'], 'string', 'max' => 100],
            [['FirstName', 'MiddleName', 'LastName', 'MSISDN', 'InvoiceNumber', 'BusinessShortCode', 'ThirdPartyTransID', 'TransactionType', 'OrgAccountBalance', 'BillRefNumber', 'TransAmount'], 'string', 'max' => 255],
            [['station_id'], 'string', 'max' => 50],
            [['operator'], 'string', 'max' => 20],
            [['TransID'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'TransID' => 'Trans ID',
            'FirstName' => 'First Name',
            'MiddleName' => 'Middle Name',
            'LastName' => 'Last Name',
            'MSISDN' => 'Msisdn',
            'InvoiceNumber' => 'Invoice Number',
            'BusinessShortCode' => 'Business Short Code',
            'ThirdPartyTransID' => 'Third Party Trans ID',
            'TransactionType' => 'Transaction Type',
            'OrgAccountBalance' => 'Org Account Balance',
            'BillRefNumber' => 'Bill Ref Number',
            'TransAmount' => 'Trans Amount',
            'is_archived' => 'Is Archived',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'state' => 'State',
            'station_id' => 'Station ID',
            'operator' => 'Operator',
            'tickets' => 'Tickets',
            'moved' => 'Moved',
        ];
    }
}
