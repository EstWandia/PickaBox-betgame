<?php

namespace app\models;

use app\components\myhelper;
use Yii;

/**
 * This is the model class for table "mpesa_payments".
 *
 * @property string $id
 * @property string|null $transid
 * @property string|null $name
 * @property string|null $msisdn
 * @property string|null $reference
 * @property string|null $amount
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property int $state
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
            [['state',], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['transid', 'deleted_at'], 'string', 'max' => 100],
            [['name', 'msisdn', 'reference', 'amount'], 'string', 'max' => 255],
            [['transid'], 'unique'],
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
            'transid' => 'Trans ID',
            'name' => 'Name',
            'msisdn' => 'msisdn',
            'reference' => 'Reference',
            'amount' => 'Trans Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
            'state' => 'State',
        ];
    }
    public static function savePlayAmount($id) {
        $mpesa = MpesaPayments::findOne($id);
    
        if ($mpesa !== null) {
            $existingRecord = PlayingPool::findOne($mpesa->id);
    
            if ($existingRecord === null) {
                $model = new PlayingPool();
    
                $model->id = $mpesa->id;
                $model->transid = $mpesa->transid;
                $model->reference = $mpesa->reference;
                $model->name = $mpesa->name;
                $model->msisdn = $mpesa->msisdn;
                $model->amount = (int)(0.80 * $mpesa->amount);
                $model->created_at = date("Y-m-d H:i:s");
                $model->updated_at = date("Y-m-d H:i:s");
    
                $model->save(false);
            }
         }
        }
        public  static function getStkPush(){
            $accessToken = trim(myhelper::getToken());
            
            $businessShortCode ='174379';
            $passkey= 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
            $timestamp =date('YmdHis');
            var_dump($timestamp);
            $stkPushUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $password=base64_encode($businessShortCode . $passkey . $timestamp);
    
            $headers = [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            ];
            $payload = [
                'BusinessShortCode' => '174379',
                'Password' =>$password,
                'Timestamp' => date('YmdHis'),
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => 1,
                'PartyA' => '254759273807',
                'PartyB' => '174379',
                'PhoneNumber' => '254759273807',
                'CallBackURL' => 'https://58a3-41-209-57-169.ngrok-free.app/mpesa/paymentcallback',
                'AccountReference' => 'Test123',
                'TransactionDesc' => 'Payment for services'
            ];
            $response= myhelper::curlPost($payload,$headers,$stkPushUrl);
            var_dump($response);exit;
    
            $result = json_decode($response, true);
    
            if (isset($result['ResponseCode']) && isset($result['ResponseCode'])) {
                if (isset($data['Body']['stkCallback']['CallbackMetadata']['Item'])) {
                    $item = $data['Body']['stkCallback']['CallbackMetadata']['Item'];
                    $mpesaData = array_column($item, 'value', 'Name');
                    return $mpesaData;
                }
            } else {
                
                throw new \Exception('Error initiating payment: ' . $response);
            }
        }
    }