<?php

namespace app\models;

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
    }