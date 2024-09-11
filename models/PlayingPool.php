<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "playing_pool".
 *
 * @property string $id
 * @property string $transid
 * @property string $name
 * @property string $msisdn
 * @property string $reference
 * @property float $amount
 * @property string $created_at
 * @property string $updated_at
 * @property int|null $state
 * @property string|null $deleted_at
 */
class PlayingPool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'playing_pool';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'transid', 'name', 'msisdn', 'reference', 'amount', 'created_at', 'updated_at'], 'required'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['state'], 'integer'],
            [['id'], 'string', 'max' => 36],
            [['transid', 'name', 'msisdn', 'reference'], 'string', 'max' => 255],
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
            'transid' => 'Transid',
            'name' => 'Name',
            'msisdn' => 'Msisdn',
            'reference' => 'Reference',
            'amount' => 'Amount',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'state' => 'State',
            'deleted_at' => 'Deleted At',
        ];
    }
}
